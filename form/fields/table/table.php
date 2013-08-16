<?php 

namespace Kirby\Form\Field;

use Kirby\Toolkit\A;
use Kirby\Toolkit\Form;
use Kirby\Toolkit\Str;
use Kirby\Form\Field;
use Kirby\App;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Grid Field
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Table extends Field {

  protected $_items;

  public function label() {
    return false;
  }

  public function page() {    
    return app::module('site')->page($this->attribute('source'));
  }

  public function items() {
    
    if(!is_null($this->_items)) return $this->_items;

    // get the current page
    $page = $this->page();

    if(!$page) return array();

    // get all children
    $items = $page->children();

    if($sort = $this->attribute('sort')) {

      // set the sort order
      if($sort == 'flip') {
        $items = $items->flip();
      } else {

        $sort  = str::split(trim($sort), ' ');
        $order = $sort[0];
        $dir   = $sort[1];
        $items = $items->sortBy($order, $dir);

      }

    }

    if($status = $this->attribute('status')) {
      $items = ($status == 'invisible') ? $items->invisible() : $items->visible();
    }

    // set the limit
    $items = $items->paginate($this->attribute('limit', 10));

    return $this->_items = $items;

  }

  public function preview($item) {

    $previews = $this->attribute('previews');

    if(!$previews) return false;

    if(is_array($previews)) {

      switch($previews['type']) {
        case 'url':

          $url = a::get($previews, 'url');

          //dump($item->content()->toArray());

          return str::template($url, $item->content()->data());    
          break;
      }

    } else if($image = $item->images()->first()) {
      return $image->url();
    }

  }

}