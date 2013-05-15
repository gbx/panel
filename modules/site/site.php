<?php

// load needed stuff from the module library
require_once(dirname(__FILE__) . DS . 'lib' . DS . 'blueprint.php');

// load needed models
require_once(dirname(__FILE__) . DS . 'models' . DS . 'page.php');
require_once(dirname(__FILE__) . DS . 'models' . DS . 'file.php');

class SiteModule extends AppModule {

  protected $site = null;
  protected $title = 'Pages';
  protected $name = 'site';
  protected $layout = 'shared > default';
  protected $defaultController = 'pages';

  public function __construct() {

    // load the CMS bootstrapper
    require_once(ROOT_KIRBY . DS . 'bootstrap.php');

  }

  public function site() {    

    if(!is_null($this->site)) return $this->site;

    return $this->site = site(array(
      'url'        => dirname(app()->url()),
      'subfolder'  => dirname(app()->subfolder()),
      'currentURL' => get('page', '/')
    ));

  }

  public function page() {
    return (get('page')) ? $this->site()->activePage() : $this->site();
  }

  public function currentFile() {    
    return $this->page()->files()->find(get('file'));
  }

  public function header($tab = 'content', $dashboard = false) {

    $site = $this->site();
    $page = $this->page();

    // don't include the home page in the breadcrumb
    c::set('breadcrumb.home', false);

    // options 
    if($page->isSite()) {

      $headline   = $page->title();
      $breadcrumb = '';
      $back       = false;
      $options    = false;

    } else {

      // get all links for the breadcrumb
      $breadcrumbLinks = $site->breadcrumb();
      $headline        = $breadcrumbLinks->last()->title();
      $options         = true;

      // topbar with breadcrumb
      $breadcrumb = $this->snippet('site > breadcrumb', array(
        'breadcrumb' => $breadcrumbLinks->slice(0,-1)
      ));

      $back = array(
        'url'   => $this->pageURL($page->parent(), 'pages'),
        'title' => $page->parent()->title(),
      );

    }

    // headline
    $headline = $this->snippet('site > headline', array( 
      'text'    => $headline,
      'url'     => $this->pageURL($page, 'pages'),
      'options' => $options, 
      'back'    => $back, 
      'page'    => $page,
    ));

    // tabs
    $tabs = $this->snippet('shared > tabs', array(
      'tabs' => array(
        'pages' => array(
          'title'  => 'Pages', 
          'url'    => $this->pageURL($page, 'pages'),
          'active' => r($tab == 'pages', true),
          'count'  => $page->children()->count(),
        ),
        'content' => array(
          'title'  => 'Text', 
          'url'    => $this->pageURL($page, 'content'),
          'active' => r($tab == 'content', true),
        ),
        'files'   => array(
          'title'  => l::get('tabs.files'),
          'url'    => $this->pageURL($page, 'files'),
          'active' => r($tab == 'files', true),
          'count'  => $page->files()->filterBy('extension', '!=', 'txt')->count(),
        )
      )
    ));
      
    // header
    return $this->snippet('shared > header', array(
      'breadcrumb' => $breadcrumb,
      'headline'   => $headline,
      'tabs'       => $tabs
    ));

  }

  public function blueprint() {

    $page     = $this->page();
    $template = ($page->isSite()) ? 'site' : $page->template();

    return new Blueprint($template);

  }

  public function pageURL($page, $tab = false) {

    if(!$tab) $tab = app()->uri()->path()->nth(1);

    if($page == 'this') $page = $this->page();
    if($page == 'site') $page = $this->site();
    
    if(is_a($page, 'KirbySite')) {
      return app()->url('site/' . $tab);
    } else {
      return app()->url('site/' . $tab . '/?page=' . $page->uri());
    }

  }

  public function fileURL($file, $tab = 'show') {
    return app()->url('site/files/' . $tab . '/?page=' . $this->page()->uri() . '&file=' . urlencode($file->filename()));
  }

}
