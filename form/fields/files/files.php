<?php 

namespace Kirby\Form\Field;

use Kirby\Toolkit\Form;
use Kirby\Form\Field;
use Kirby\App;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Files Field
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Files extends Field {

  public function label() {
    return false;
  }

  public function page() {
    return app::module('site')->page($this->attribute('source'));
  }

  public function items() {
    
    $page = $this->page();

    if(!$page) return false;

    return $page->files()->filterBy('type', '!=', 'content')->paginate($this->attribute('limit', 10));

  }

}