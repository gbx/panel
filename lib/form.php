<?php 

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

// dependencies
require_once(ROOT_KIRBY_PANEL_LIB . DS . 'form' . DS . 'buttons.php');
require_once(ROOT_KIRBY_PANEL_LIB . DS . 'form' . DS . 'field.php');

/**
 * Form
 * 
 * A form builder class, which uses a simple 
 * description array to build all needed fields
 * This can be feeded from a YAML file for example
 * 
 * @package Kirby Panel
 */
class PanelForm extends Form {

  // a list with all field definition
  protected $fields = array();
  
  // the applicable data for the form
  protected $data = null;
  
  // a collection of options
  protected $options = null;

  // the css, which needs to be included inline
  protected $css = null;
  
  // the js, which needs to be included inline
  protected $js = null;

  /**
   * Constructor
   * 
   * @param array $fields A list of field definitions
   * @param array $data Data, which should be shown in the form
   * @param array $params An optional array of options to apply to the form
   */
  public function __construct($fields, $data = array(), $params = array()) {

    $defaults = array(
      'action'  => '',
      'method'  => 'POST',
      'upload'  => false,
      'attr'    => array(),
      'buttons' => array()
    );
    
    $this->options = options($defaults, $params);
    $this->data    = $data;

    foreach($fields as $name => $field) {
      $field['name'] = $name;      
      $this->fields[] = $this->field($field);
    }

  }

  /**
   * Returns the html for all fields
   * 
   * @return string
   */
  public function fields() {
    $output = array();

    $output[] = '<fieldset>';
    foreach($this->fields as $field) $output[] = $field;
    $output[] = '</fieldset>';

    return implode(PHP_EOL, $output);
  }

  /**
   * Returns the inline css for all fields
   * 
   * @return string
   */
  public function css() {

    $output = array();
    foreach($this->fields as $field) $output[$field->type()] = $field->css();
    $css = trim(implode(PHP_EOL, $output));

    // wrap in style tags and return
    return !empty($css) ? '<style>' . PHP_EOL . $css . PHP_EOL . '</style>' : '';

  }

  /**
   * Returns the inline js for all fields
   * 
   * @return string
   */
  public function js() {

    $output = array();
    foreach($this->fields as $field) $output[$field->type()] = $field->js();
    $js = trim(implode(PHP_EOL, $output));

    // wrap in script tags and return
    return !empty($js) ? '<script>' . PHP_EOL . $js . PHP_EOL . '</script>' : '';

  }

  /**
   * Loads a single field 
   * 
   * @param array $params An optional array of options for the field
   */
  public function field($params = array()) {
    return new PanelFormField($this, $params);
  }

  /**
   * Returns the applied data array
   * 
   * @return array
   */
  public function data() {
    return $this->data;
  }

  /**
   * Builds the entire form and returns the html
   * 
   * @return string
   */
  public function build() {

    $f = array();

    $f[] = $this->css();
    $f[] = $this->js();
    $f[] = $this->start(
      $this->options->action, 
      $this->options->method, 
      $this->options->upload, 
      $this->options->attr
    ); 
    $f[] = $this->fields(); 
    $f[] = $this->buttons(
      $this->options->buttons
    );
    $f[] = $this->end(); 
    
    return implode(PHP_EOL, $f);

  }

  /**
   * Generates a hidden field with a csfr token
   * 
   * @return string
   */
  static public function csfr() {
    return self::hidden('csfr', app()->csfr());
  }

  /**
   * Renders a fieldset with submit and cancel buttons
   * 
   * @param array $params With the optional params you can set or switch of the particular buttons
   * @return string
   */
  static public function buttons($params = array()) {

    $defaults = array(
      'submit' => l::get('content.save'), 
      'cancel' => l::get('content.cancel'), 
    );

    $options = array_merge($defaults, $params);

    $html[] = '<fieldset class="buttonbar is-collapsable">';
    $html[] = '<div class="buttons">';
    $html[] = self::csfr();
    
    if($options['cancel']) $html[] = self::reset('cancel', $options['cancel'], array('class' => 'round button cancel'));
    
    $html[] = '&nbsp;';

    if($options['submit']) $html[] = self::submit('submit', $options['submit'], array('class' => 'round button submit'));
    
    $html[] = '</div>';
    $html[] = '</fieldset>';

    return implode(PHP_EOL, $html);

  }

  /**
   * Echos the entire form
   * 
   * @return string
   */
  public function __toString() {
    return $this->build();
  }

}