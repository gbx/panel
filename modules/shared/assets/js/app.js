var $app = $app || {};

$app.actions = {};

$app.loader = {

  timeout : false,

  show : function(delay, parent) {
    $app.loader.hide();  
    $app.dropdown.close();
    
    if(!delay)  delay  = 0;
    if(!parent) parent = 'body'; 

    // preload the loading image
    var img = $('<img />').attr('src', $app.baseurl + '/modules/shared/assets/images/loader.white.gif'); 
    
    img.on('load', function() {

      $app.loader.timeout = window.setTimeout(function() {
        
        var l = $('<div class="load"><i>loading…</i></div>');
        $(parent).append(l);

        // for some reasons the animated gif is not showing
        // by default, but when the background image is reassigned with a short delay it's working. weird!
        window.setTimeout(function() {
          l.find('i').css('background-image', 'url(' + img.attr('src') + ')');
        }, 10)

      }, delay);

    });
    
  },
  hide : function() {

    window.clearTimeout($app.loader.timeout);
    $app.loader.timeout;

    $('.load').remove();  

  }

};

$app.dropdown = {

  cache : [],

  init : function() {

    // cache all dropdown elements
    $app.dropdown.cache = $('.dropdown');

    // dropdowns
    $(document).on({
      'keyup' : function(e) {    
        if(e.keyCode == 27) $app.dropdown.cache.hide();
      },
      'click' : function() {
        $app.dropdown.cache.hide();
      }
    });

    $app.dropdown.cache.on('click', function(e) {
      e.stopPropagation();
    });

  },

  open : function(id) {
    this.close();
    $(id).show();
  },

  close : function(id) {
    if(!id) return $app.dropdown.cache.hide();
    $(id).hide();
  },

  toggle : function(id) {
    this.close();
    $(id).toggle();
  }

};

$app.iframe = {

  init : function() {

    window.on('closeIframe', function() {
      $app.iframe.close();
    });

  },

  open : function(href, callback) {

    $app.iframe.close();

    // remove overflow on underlying app 
    $('body').addClass('has-overlay');

    if(!callback) callback = function() {};

    $app.loader.show(200, '.header');

    var overlay = $('<div class="iframe overlay"></div>').css('display', 'none');
    var iframe  = $('<iframe></iframe>').attr('src', href).on('load', function() {
      $app.loader.hide();
      callback.call(this, iframe, overlay);
      overlay.show();        
    });        
    
    $('body').append(overlay.append(iframe));

  },

  close: function() {

    // remove overflow on underlying app 
    $('body').removeClass('has-overlay');
    $('.iframe').remove();
  
  }

};

$.fn.actions = function() {

  return this.on('click', function() {

    var $this  = $(this);
    var href   = $this.attr('href');
    var id     = $this.data('id');
    var action = $this.data('action');

    switch(action) {
      case 'iframe':
        $app.iframe.open(href, function(iframe, overlay) {
          var contents  = iframe.contents();
          var focusable = contents.find('.field.focus').find('input, textarea, select').first();          
          if(!focusable.length) focusable = contents.find('.app');
          window.setTimeout(function() {
            focusable.focus();
          }, 100);
        });
        break;
      case 'show aside':
        $('.app').removeClass('is-collapsed');
        break;
      case 'hide aside':
        $('.app').addClass('is-collapsed');
        break;
      case 'toggle aside':
        $('.app').toggleClass('is-collapsed');
        break;
      case 'dropdown':
        $app.dropdown.toggle(href);
        break;
      case 'go':
        window.location.href = href;
        break;
      default:

        if(typeof($app.actions[action]) == 'function') {
          if($app.actions[action](a, href, id) === true) return true;
        }

        break;
    }

    if($this.is('a, button')) return false;

  });
  
};

/* Super simple markdown editor */
$.widget('kirby.wysiwtf', {

  _create : function() {
    
    var $this  = this;
    this.area  = this.element[0];
    this.field = this.element.parents('.field');
    this.bar   = this.field.find('.form-buttons');

    this.bar.find('button').on('click', function() {      
      
      // mark the current textarea as active so 
      // overlays can easily find the current area
      $('textarea.wysiwtf-is-active').removeClass('active');
      $this.element.addClass('wysiwtf-is-active');

      if($(this).attr('rel') == 'tag') {

        var button = $(this);
        var open   = button.attr('data-tag-open');
        var close  = button.attr('data-tag-close');
        var sample = button.attr('data-tag-sample');

        $this.element.wysiwtf('tag', open, close, sample);
        return false;
    
      }

    });  

  },  

  tag : function(open, close, sample) {

    if(!sample) sample = '';
    if(!close)  close  = '';

    // IE
    if(document.selection) {

      var selection = document.selection.createRange().text;
      if(!selection) selection = sample;

      this.area.focus();
      
      document.selection.createRange().text = open + selection + close;
  
    // Moz + Webkit
    } else if(this.area.selectionStart || this.area.selectionStart == '0') {

      var start  = this.area.selectionStart;
      var end    = this.area.selectionEnd;
      var scroll = this.area.scrollTop;
      var value  = this.area.value; 
      var text   = value.substring(start, end);

      if(!text) text = sample;

      var tag = open + text + close;

      this.area.value = value.substring(0, start) + tag + value.substring(end, value.length);
      this.area.focus();
  
      var cursor = start + tag.length;

      this.area.selectionStart = cursor;
      this.area.selectionEnd   = cursor;
      this.area.scrollTop      = scroll;
  
    } 

  },

  text : function(text) {

    // IE
    if(document.selection && !window.opera) {

      this.area.focus();
      selection = document.selection.createRange();
      selection.text = text;

    // Moz + Webkit
    } else if (this.area.selectionStart || this.area.selectionStart == '0') {

      var start = this.area.selectionStart;
      var end   = this.area.selectionEnd;
      var value = this.area.value;

      this.area.value = value.substring(0, start) + text + value.substring(end, value.length);
      this.area.focus();

    } else {

      this.area.value += text;
      this.area.focus();

    }    
  
  }

});


$app.form = {     

  submit : function(form, callback, error) {

    $app.form.submitOnEnter(form);

    if(!error) error = function(response, form) {
  
      if(response.errors) {
        $.each(response.errors, function(i, e) {
          form.find('.field[data-name=' + i + ']').addClass('error');        
        });
    
        form.find('.field.error').first().find('input, textarea').first().focus();
      }
            
      var alert = $('<div class="alert">' + response.message + '<a class="close" href="#close">close</a></div>').on('click', function() {
        form.find('.field.error').removeClass('error');        
        $(this).remove();
        return false;
      });
      
      $('.form .alert').remove();
      $('.form .field').first().before(alert);      
  
    };
  
    $(form).on('submit', function() {      
      
      var form   = $(this);
      var data   = form.serialize();
      var action = form.attr('action');
      
      // mark as loading
      form.addClass('loading');
          
      // submit to the same url
      if(!action) action = window.location.href;

      $.ajax({
        url: action, 
        data: data, 
        type: form.attr('method'),
        dataType: 'json',
        success: function(response) {

          form.removeClass('loading');
    
          form.find('.field.error').removeClass('error');
          form.find('.alert').remove();
          
          // react on invalid json        
          if(typeof response != 'object') response = {
            status  : 'error',
            message : 'An error occurred'
          };
                         
          // react on errors    
          if(response.status == 'error') {
            return (error) ? error.call(this, response, form) : false;
          }
    
          return callback.call(this, response, form);
    
        }, 
        error: function(response) {
          error.call(this, {
            status  : 'error',
            message : 'The request failed'
          }, form);
        }
      });
  
      return false;
          
    });

  },

  submitOnEnter : function(form) {

    if(!form) var form = '.form';

    $(document).on('keydown', function(e) {
      if(e.metaKey && e.keyCode == 13) {
        $(form).trigger('submit');
      }
    });

  }

};

$.fn.form = function() {

  // make sure the date picker will be closed 
  // when the window is being resized
  $(window).resize(function() {
    $('.field.date .input').blur();
  });

  // form stuff
  return this.each(function() {

    var $form = $(this);

    // add formbuttons
    $form.find('textarea').wysiwtf();

    $form.find('.field').on({
      'click' : function() {
        $(this).find('.input').focus();
      },
      'fakeFocus' : function() {
        $form.find('.field.focus').not(this).trigger('fakeBlur');
        $(this).addClass('focus');
        $(this).parents('.fieldgroup').trigger('fakeFocus');
      },
      'fakeBlur' : function() {
        $(this).removeClass('focus');
      }
    });

    $form.find('.input').on({
      'focus' : function() {        
        $(this).parents('.field').trigger('fakeFocus');    
      },
      'blur' : function() {    
        $(this).parents('.field').trigger('fakeBlur');    
      }
    });

    $form.find('input[type=radio], input[type=checkbox]').on({
      'click' : function() {
        $(this).focus();
      }
    });

    // form datepicker
    $form.find('.field.date .input').pikaday({ 
      firstDay: 1,
      format: 'DD.MM.YYYY',
      i18n: {
        previousMonth : '&lsaquo;',
        nextMonth     : '&rsaquo;',
        months        : ['January','February','March','April','May','June','July','August','September','October','November','December'],
        weekdays      : ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
        weekdaysShort : ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']
      }
    });

    // make sure autofocusing really works
    $form.find('[autofocus]').trigger('focus').trigger('click');

    $form.find('.field.file input').on({
      'click' : function() {
        $(this).trigger('focus');
      },
      'change' : function() {
        var $this    = $(this);
        var span     = $this.next('span');
        var value    = $this.val().split(/\\/).pop();
        var fallback = span.data('text');
        var text     = (value != '') ? value : fallback;
        span.text(text);
      }
    });

    // alert closer
    $form.find('.alert').on('click', function() {
      $(this).remove();
      return false;
    });

  });

};

$app.init = function() {

  $(function() {
      
    // set the base url 
    $app.baseurl = $('base').attr('href');

    // init all dropdown events
    $app.dropdown.init();

    // apply all available actions
    $('[data-event="action"]').actions();

    // enhance forms 
    $('.form').form();

    // style select boxes
    $('select.customizable').customSelect();

  });

}();
