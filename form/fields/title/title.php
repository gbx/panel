<?php 

namespace Kirby\Form\Field;

use Kirby\Toolkit\Form;
use Kirby\Form\Field;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Title Input Field
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Title extends Field {

  public function template() {
    return form::text(
      $this->name(), 
      $this->value(), 
      $this->attr()
    ); 
  }

}