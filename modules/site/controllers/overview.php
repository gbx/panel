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

    // navbar
    $this->layout->navbar = $this->module()->navbar('overview');

    // all info about the current page
    $this->page = $this->module()->page();

    // the entire subpages view
    $this->subpages = $this->module()->subpages();

    // files
    if($this->module()->blueprint()->files()) {
      $this->files = $this->page->files()->filterBy('extension', '!=', 'txt')->paginate(10, array('method' => 'query'));
    } else {
      $this->files = false;
    }

    if($this->page->isSite()) $this->view('site > overview/index.site');

  }

}
