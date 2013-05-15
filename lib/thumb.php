<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Thumb
 * 
 * Generates thumbnails for image objects
 * 
 * @package Kirby Panel
 */
class PanelThumb {

  // the image object
  protected $obj = null;
  
  // the root of the final thumbnail
  protected $root = false;
  
  // the public url of the final thumbnail
  protected $url = false;
  
  // the original width
  protected $sourceWidth = 0;
  
  // the original height
  protected $sourceHeight = 0;
  
  // the end width
  protected $width = 0;
  
  // the end height
  protected $height = 0;
  
  // temporary width for rescaling
  protected $tmpWidth = 0;

  // temporary height for rescaling
  protected $tmpHeight = 0;
    
  // maximum allowed width
  protected $maxWidth = 0;

  // maximum allowed height
  protected $maxHeight = 0;
  
  // the image's mime type
  protected $mime = false;
  
  // the result status
  protected $status = array();
  
  // is upscaling allowed?
  protected $upscale = false;
  
  // the compressor quality for jpgs
  protected $quality = 100;
  
  // the alternative text for the final image tag
  protected $alt = false;
  
  // should the image be cropped?
  protected $crop = false;

  /**
   * Constructor
   * 
   * @param mixed $image The image object
   * @param array $options Options for the final thumbnail
   */
  public function __construct(Asset $image, $options=array()) {

    $this->root = c::get('thumb.cache.root', ROOT . '/thumbs');
    $this->url  = c::get('thumb.cache.url',  c::get('url')  . '/thumbs');

    // if the image is not available stop it
    if(!$image) return false;

    $this->obj = $image;
    
    // set some values from the image
    $this->sourceWidth  = $this->obj->width();
    $this->sourceHeight = $this->obj->height();
    $this->width        = $this->sourceWidth;
    $this->height       = $this->sourceHeight;
    $this->source       = $this->obj->root();
    $this->mime         = $this->obj->mime();
    
    // set the max width and height
    $this->maxWidth     = @$options['width'];
    $this->maxHeight    = @$options['height'];

    // set the quality
    $this->crop = @$options['crop'];

    // set the quality
    $this->quality = a::get($options, 'quality', c::get('thumb.quality', 100));

    // set the default upscale behavior
    $this->upscale = a::get($options, 'upscale', c::get('thumb.upscale', false));

    // set the alt text
    $this->alt = a::get($options, 'alt', $this->obj->name());

    // set the className text
    $this->className = @$options['class'];
    
    // set the new size
    $this->size();
        
    // create the thumbnail    
    $this->create();
                          
  }
  
  /**
   * Generates and returns the full html tag for the thumbnail
   * 
   * @return string
   */
  public function tag() {

    if(!$this->obj) return false;
    
    $class = (!empty($this->className)) ? ' class="' . $this->className . '"' : '';
    
    return '<img' . $class . ' src="' . $this->url() . '" width="' . $this->width . '" height="' . $this->height . '" alt="' . html($this->alt) . '" />';  

  }
  
  /**
   * Returns the filename for the thumbnail
   * 
   * @return string
   */
  public function filename() {
  
    $options = false;
  
    $options .= ($this->maxWidth)  ? '.' . $this->maxWidth  : '.' . 0;
    $options .= ($this->maxHeight) ? '.' . $this->maxHeight : '.' . 0;
    $options .= ($this->upscale)   ? '.' . $this->upscale   : '.' . 0;
    $options .= ($this->crop)      ? '.' . $this->crop      : '.' . 0;
    $options .= '.' . $this->quality;

    return md5($this->source) . $options . '.' . $this->obj->extension();

  }
   
  /**
   * Returns the full file path for the thumbnail file
   * 
   * @return string
   */
  public function file() {
    return $this->root . DS . $this->filename();
  }

  /**
   * Returns the absolute url for the thumbnail
   * 
   * @return string
   */
  public function url() {
    return (a::get($this->status, 'status') == 'error') ? $this->obj->url() : $this->url . '/' . $this->filename();
  }
  
  /**
   * Returns the dimensions of the thumbnail as associative array
   * 
   * @return array
   */
  protected function size() {
        
    $maxWidth   = $this->maxWidth;        
    $maxHeight  = $this->maxHeight;
    $upscale    = $this->upscale;    
    $dimensions = new Dimensions($this->sourceWidth, $this->sourceHeight);

    if($this->crop == true) {

      if(!$maxWidth)  $maxWidth  = $maxHeight;      
      if(!$maxHeight) $maxHeight = $maxWidth;      

      $croppedDimensions = new Dimensions($maxWidth, $maxHeight);

      $sourceRatio = $dimensions->ratio();
      $thumbRatio  = $croppedDimensions->ratio();
                      
      if($sourceRatio > $thumbRatio) {
        // fit the height of the source
        $dimensions->fitHeight($maxHeight, true);
      } else {
        // fit the width of the source
        $dimensions->fitWidth($maxWidth, true);
      }
                          
      $this->tmpWidth  = $dimensions->width();
      $this->tmpHeight = $dimensions->height();
      $this->width     = $maxWidth;
      $this->height    = $maxHeight;
          
      return $dimensions;

    }
        
    // if there's a maxWidth and a maxHeight
    if($maxWidth && $maxHeight) {
      $dimensions->fitWidthAndHeight($maxWidth, $maxHeight, $upscale);
    } elseif($maxWidth) {
      $dimensions->fitWidth($maxWidth, $upscale);
    } elseif($maxHeight) {
      $dimensions->fitHeight($maxHeight, $upscale);
    } 

    $this->width  = $dimensions->width();
    $this->height = $dimensions->height();
        
    return $dimensions;
        
  }
  
  /**
   * Creates the thumbnail and tries to save it
   * 
   * @return array
   */
  protected function create() {
    
    $file = $this->file();            

    if(!function_exists('gd_info')) return $this->status = array(
      'status' => 'error',
      'msg'    => 'GD Lib is not installed'
    );

    if(file_exists($file) && (filectime($this->source) < filectime($file) || filemtime($this->source) < filemtime($file))) return $this->status = array(
      'status' => 'success',
      'msg'    => 'The file exists'
    );

    if(!is_writable(dirname($file))) return $this->status = array(
      'status' => 'error',
      'msg'    => 'The image file is not writable'
    );
            
    switch($this->mime) {
      case 'image/jpeg':
        $image = @imagecreatefromjpeg($this->source); 
        break;
      case 'image/png':
        $image = @imagecreatefrompng($this->source); 
        break;
      case 'image/gif':
        $image = @imagecreatefromgif($this->source); 
        break;
      default:
        return $this->status = array(
          'status' => 'error',
          'msg'    => 'The image mime type is invalid'
        );
        break;
    }       

    if(!$image) return array(
      'status' => 'error',
      'msg'    => 'The image could not be created'
    );
              
    // make enough memory available to scale bigger images
    ini_set('memory_limit', '128M');

    if($this->crop == true) {

      // Starting point of crop
      $startX = floor($this->tmpWidth  / 2) - floor($this->width / 2);
      $startY = floor($this->tmpHeight / 2) - floor($this->height / 2);
          
      // Adjust crop size if the image is too small
      if($startX < 0) $startX = 0;
      if($startY < 0) $startY = 0;
      
      // create a temporary resized version of the image first
      $thumb = imagecreatetruecolor($this->tmpWidth, $this->tmpHeight); 
      imagecopyresampled($thumb, $image, 0, 0, 0, 0, $this->tmpWidth, $this->tmpHeight, $this->sourceWidth, $this->sourceHeight); 
      
      // crop that image afterwards      
      $cropped = imagecreatetruecolor($this->width, $this->height); 
      imagecopyresampled($cropped, $thumb, 0, 0, $startX, $startY, $this->tmpWidth, $this->tmpHeight, $this->tmpWidth, $this->tmpHeight); 
      imagedestroy($thumb);
      
      // reasign the variable
      $thumb = $cropped;

    } else {
      $thumb = imagecreatetruecolor($this->width, $this->height); 
      imagecopyresampled($thumb, $image, 0, 0, 0, 0, $this->width, $this->height, $this->sourceWidth, $this->sourceHeight); 
    }    
    
    switch($this->mime) {
      case 'image/jpeg': imagejpeg($thumb, $file, $this->quality); break;
      case 'image/png' : imagepng($thumb, $file, 0); break; 
      case 'image/gif' : imagegif($thumb, $file); break;
    }

    imagedestroy($thumb);

    return $this->status = array(
      'status' => 'success',
      'msg'    => 'The image has been created',
    );
    
  }
  
}