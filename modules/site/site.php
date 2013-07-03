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
  protected $title  = 'Site';
  protected $name   = 'site';
  protected $layout = 'shared > application';

  public function routes() {

    // overview tab
    router::register(array('GET', 'POST'),   'site',                'site > overview::index');
    router::register(array('GET'),           'site/overview',       'site > overview::index');

    // pages tab
    router::register(array('GET', 'POST'),   'site/pages',          'site > pages::index');
    router::register(array('GET', 'POST'),   'site/pages/add',      'site > pages::add');
    router::register(array('GET', 'POST'),   'site/pages/url',      'site > pages::url');
    router::register(array('GET', 'POST'),   'site/pages/template', 'site > pages::template');
    router::register(array('GET', 'DELETE'), 'site/pages/delete',   'site > pages::delete');

    // content tab
    router::register(array('GET', 'POST'),   'site/content',        'site > content::index');
    router::register(array('GET', 'POST'),   'site/content/editor', 'site > content::editor');
  
    // files tab    
    router::register(array('GET', 'POST'),   'site/files',          'site > files::index');
    router::register(array('GET', 'POST'),   'site/files/upload',   'site > files::upload');
    router::register(array('GET', 'POST'),   'site/files/edit',     'site > files::edit');
    router::register(array('GET', 'POST'),   'site/files/replace',  'site > files::replace');
    router::register(array('GET', 'DELETE'), 'site/files/delete',   'site > files::delete');

    // form buttons modals
    router::register(array('GET'), 'site/insert/image', 'site > modals::image');

  }

  public function site() {    

    if(!is_null($this->site)) return $this->site;

    return $this->site = site(array(
      'url'        => dirname(app()->url()),
      'subfolder'  => dirname(app()->subfolder()),
      'currentURL' => get('uri', '/')
    ));

  }

  public function page() {
    return (get('uri')) ? $this->site()->activePage() : $this->site();
  }

  public function currentFile() {    
    return $this->page()->files()->find(get('file'));
  }

  public function navbar() {

    return false;

    $site = $this->site();
    $page = $this->page();


    // don't include the home page in the breadcrumb
    c::set('breadcrumb.home', false);

    // topbar with breadcrumb
    return $this->snippet('site > navbar', array(
      'breadcrumb' => $site->breadcrumb()
    ));

  }

  public function sidebar($active = 'content') {

    $site = $this->site();
    $page = $this->page();

    return $this->snippet('site > sidebar', array(
      'page'     => $page,
      'children' => $page->children(), 
      'files'    => $page->files()->filterBy('type', '!=', 'content'), 
      'active'   => $active
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
      return app()->url('site/' . $tab . '/?uri=' . $page->uri());
    }

  }

  public function fileURL($file, $tab = 'show') {
    return app()->url('site/files/' . $tab . '/?uri=' . $this->page()->uri() . '&file=' . urlencode($file->filename()));
  }

  public function url() {
    return app()->url();
  }

}
