<?php

// load the CMS bootstrapper
require_once(KIRBY_CMS_ROOT . DS . 'bootstrap.php');

// load models
app::load(array(
  'site > models/blueprint',
  'site > models/page',
  'site > models/file'
));

class SiteModule extends Module {

  protected $site   = null;
  protected $title  = 'Pages';
  protected $name   = 'site';
  protected $layout = 'shared > default';

  public function routes() {

    // pages tab
    router::register(array('GET', 'POST'),   'site',                'site > pages::index');    
    router::register(array('GET', 'POST'),   'site/pages',          'site > pages::index');
    router::register(array('GET', 'POST'),   'site/pages/add',      'site > pages::add');
    router::register(array('GET', 'POST'),   'site/pages/url',      'site > pages::url');
    router::register(array('GET', 'POST'),   'site/pages/template', 'site > pages::template');
    router::register(array('GET', 'DELETE'), 'site/pages/delete',   'site > pages::delete');

    // content tab
    router::register(array('GET', 'POST'),   'site/content',        'site > content::index');
  
    // files tab    
    router::register(array('GET', 'POST'),   'site/files',          'site > files::index');
    router::register(array('GET', 'POST'),   'site/files/upload',   'site > files::upload');
    router::register(array('GET', 'POST'),   'site/files/edit',     'site > files::edit');
    router::register(array('GET', 'POST'),   'site/files/replace',  'site > files::replace');
    router::register(array('GET', 'DELETE'), 'site/files/delete',   'site > files::delete');

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
    
    if($page->isSite()) {
      return app()->url('site/' . $tab);
    } else {
      return app()->url('site/' . $tab . '/?page=' . $page->uri());
    }

  }

  public function fileURL($file, $tab = 'show') {
    return app()->url('site/files/' . $tab . '/?page=' . $this->page()->uri() . '&file=' . urlencode($file->filename()));
  }

}
