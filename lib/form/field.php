<?php 

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Form Field
 * 
 * This class loads a custom form field
 * from the fields folder
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class PanelFormField {

  // The parent form object
  protected $form = null;
  
  // A collection of options (KirbyCollection)
  protected $options = null;
  
  // The rendered output
  protected $output = null;
  
  // The root for all field files
  protected $root = null;

  /**
   * Constructor
   * 
   * @param object The parent PanelForm object
   * @param array $params An additional array of options for the field
   */
  public function __construct(PanelForm $form, $params = array()) {

    $defaults = array(
      'label'     => false,
      'default'   => false,
      'size'      => false,
      'autolabel' => true,
      'buttons'   => false,
      'config'    => false,
      'file'      => false,
      'help'      => false,
      'type'      => false,
      'error'     => false,
      'class'     => false,
      'required'  => false,
      'focus'     => false,
    );

    $this->options = options($defaults, $params);
    $this->form    = $form;  
    
    // get the value for the field and store it in the options array to be extracted later
    $this->options->set('value', $this->value());

    // overwrite options with a custom config file
    $this->config();

    $this->output = array();
    $this->output[] = '<div class="' . $this->selectors() . '">';
    $this->output[] = $this->label();  
    $this->output[] = '<div class="wrapper">';
    $this->output[] = $this->template();
    $this->output[] = $this->buttons();  
    $this->output[] = '</div>';
    $this->output[] = $this->help();  
    $this->output[] = '</div>';

    return $this->output = implode(PHP_EOL, $this->output);    
      
  }

  /**
   * Returns a list of css selectors to add to the field div
   * 
   * @return string
   */
  public function selectors() {

    $selectors = array('field');
    if($this->option('type'))    $selectors[] = $this->option('type');
    if($this->option('class'))   $selectors[] = $this->option('class');
    if($this->option('size'))    $selectors[] = $this->option('size');
    if($this->option('error'))   $selectors[] = 'error';
    if($this->option('buttons')) $selectors[] = 'with-buttons';
    return implode(' ', $selectors);

  }  

  /**
   * Returns the full label tag for the field
   * 
   * @return string
   */
  public function label() {
    if(!$this->option('autolabel')) return false;
    $text     = $this->option('label', $this->option('name'));
    $required = $this->option('required') == true ? '<span class="required">*</span>' : '';
    return '<label>' . str::ucfirst($text) . $required . '</label>';   
  }

  /**
   * Returns the field type
   * 
   * @return string
   */
  public function type() {
    return $this->option('type');
  }

  /**
   * Returns the current value for the field
   * 
   * @return string
   */
  public function value() {
    // set the value, which should be placed in the field
    return (string)get($this->option('name'), a::get($this->form->data(), $this->option('name'), $this->option('default')));
  }

  /**
   * Checks if the field should be focused
   * 
   * @return boolean
   */
  public function focus() {
    return $this->option('autofocus') or $this->option('focus');
  }

  /**
   * Includes the field template and returns the rendered html
   * 
   * @return string
   */
  public function template() {

    $template = $this->root() . DS . $this->type() . '.php';

    if(!file_exists($template)) app()->raise('The field template could not be found: ' . $template);

    content::start();  
    require($template);
    return content::stop();      

  }

  /**
   * Returns a list of default attributes for the field
   * 
   * @param array $attr An optional array of additional attributes
   * @return array
   */
  public function attr($attr = array()) {

    $defaults = array(
      'class'     => 'input',
      'autofocus' => $this->focus(), 
    );

    return array_merge($defaults, $attr);

  }

  /**
   * Returns all options
   * 
   * @return object KirbyCollection
   */
  public function options() {
    return $this->options;
  }

  /**
   * Gets a particular option or a default value if not available
   * 
   * @param string $key The key for the option
   * @param mixed $default An optional default value
   * @return mixed
   */
  public function option($key, $default = null) {
    return $this->options->get($key, $default);
  }

  /**
   * Returns the name of the field
   * 
   * @return string
   */
  public function name() {      
    return html($this->option('name'));
  }

  /**
   * Returns the optional inline css for this field
   *
   * @return string
   */
  public function css() {
    $css = $this->root() . DS . $this->type() . '.css';    
    return (file_exists($css)) ? f::read($css) : false;
  }

  /**
   * Returns the optional inline js for this field
   *
   * @return string
   */
  public function js() {
    $js = $this->root() . DS . $this->type() . '.js';    
    return (file_exists($js)) ? f::read($js) : false;
  }

  /**
   * Returns the rendered KirbyAppFormButtons if
   * those should be added to the textarea
   * 
   * @return string
   */
  public function buttons() {
    if($this->type() == 'textarea' && $this->option('buttons')) {
      return new PanelFormButtons($this->option('buttons'));
    }
  }

  /**
   * Returns the help text tag if applicable
   * 
   * @return string
   */
  public function help() {
    if(!$this->option('help')) return false;
    return '<p class="description">' . html($this->option('help')) . '</p>';
  }

  /**
   * Includes the field config file if available
   * 
   * @return void
   */
  public function config() {
    $config = $this->root() . DS . $this->type() . '.config.php';
    if(file_exists($config)) require($config);
  }

  /**
   * Returns the root directory for this field
   * 
   * @return string
   */
  public function root() {
    if(!is_null($this->root)) return $this->root;
    
    $default = KIRBY_PANEL_ROOT_FIELDS . DS . $this->type();
    $custom  = KIRBY_PROJECT_ROOT_PANEL_FIELDS . DS . $this->type();
    $custom  = '';

    return $this->root = (is_dir($custom)) ? $custom : $default;
  
  }

  /**
   * Echos the field html
   * 
   * @return string
   */
  public function __toString() {
    return $this->output;
  }

}