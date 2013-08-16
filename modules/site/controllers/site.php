<?php

use Kirby\Form;

/**
 * Site
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class SiteController extends Controller {

  public function dashboard() {

    $this->layout = new Layout('shared > application');
    $this->layout->sidebar = $this->module()->sidebar('dashboard');
    $this->layout->content = new View($this);

  }

  public function metatags() {

    $site      = $this->module()->site();
    $blueprint = $this->module()->blueprint($site); 
    $content   = $site->content();
    $data      = ($content) ? $content->data() : array();

    $this->layout = new Layout('shared > application');
    $this->layout->sidebar = $this->module()->sidebar('metatags');
    $this->layout->metabar = new Snippet('site > metabar.metatags');
    $this->layout->content = new View($this);
    $this->layout->content->form = new Form($blueprint->fields(), array(
      'data' => $data
    ));

  }

}
