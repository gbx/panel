<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * The Buttons class generates a list of formatting
 * buttons to simplify entering Markdown in textareas
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class PanelFormButtons {

  // the final array of html lines
  protected $html = array();

  /**
   * Constructor
   * 
   * @param array $active A list of keys of active buttons, which should be rendered
   */
  public function __construct($active = array()) {

    $available = array(
      'h1'     => '<button rel="tag" data-tag-open="# ">' . l::get('form.buttons.h1') . '</button>',
      'h2'     => '<button rel="tag" data-tag-open="## ">' . l::get('form.buttons.h2') . '</button>',
      'h3'     => '<button rel="tag" data-tag-open="### ">' . l::get('form.buttons.h3') . '</button>',
      'bold'   => '<button rel="tag" data-tag-open="**" data-tag-close="**" data-tag-sample="' . l::get('form.buttons.bold.sample') . '">' . l::get('form.buttons.bold') . '</button>',
      'italic' => '<button rel="tag" data-tag-open="*" data-tag-close="*" data-tag-sample="' . l::get('form.buttons.italic.sample') . '">' . l::get('form.buttons.italic') . '</button>',
      'link'   => '<button data-event="action" data-action="iframe" href="' . app()->url('shared/modals/link') . '">' . l::get('form.buttons.link') . '</button>',
      'email'  => '<button data-event="action" data-action="iframe" href="' . app()->url('shared/modals/email') . '">' . l::get('form.buttons.email') . '</button>',
      //'image'  => '<button data-event="action" data-action="iframe" href="' . app()->url('shared/modals/image') . '">' . l::get('form.buttons.image', 'image') . '</button>',
    );
     
    if(is_array($active)) {
      foreach($active as $b) {
        $buttons[] = a::get($available, $b);
      }
    } else {
      $buttons = $available;
    }
                
    $this->html[] = '<nav class="form-buttons">';
    $this->html[] = '<ul>';    

    foreach($buttons as $button) $this->html[] = '<li>' . $button . '</li>';    

    $this->html[] = '</ul>';    
    $this->html[] = '</nav>';    
    
    $this->html = implode(PHP_EOL, $this->html);

  }

  /**
   * Makes it possible to simply echo the class to get the button html
   * 
   * @return string
   */
  public function __toString() {
    return $this->html;
  }

}