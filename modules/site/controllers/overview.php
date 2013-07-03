<?php

/**
 * Page Dashboard
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class OverviewController extends Controller {

  public function index() {
    
    $this->layout->css = array(
      'site > assets/css/site.css'
    );

    $this->layout->navbar  = $this->module()->navbar();
    $this->layout->sidebar = $this->module()->sidebar('overview');

    $this->page        = $this->module()->page();

    $this->children    = $this->page->children()->paginate(5, array('method' => 'query'));
    $this->pagination  = $this->children()->pagination();

    $this->files       = $this->page->files()->filterBy('extension', '!=', 'txt')->paginate(10, array('method' => 'query'));

    // don't include the home page in the breadcrumb
    c::set('breadcrumb.home', false);

    $this->breadcrumb = $this->module()->site()->breadcrumb();

  }

}
