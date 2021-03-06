$(function() {

  $(document).on({
    'keyup' : function(e) {    
      if(e.keyCode == 27 && window.parent) window.parent.$app.iframe.close();
    },
    'click' : function(e) {        
      if(window.parent) window.parent.$app.iframe.close();
    }
  });

  var app = $('.main');
  
  $('.main, input, textarea, select').on('click', function(e) {
    e.stopPropagation();
  });
  
  if(app.hasClass('centered')) {

    var centerOverlay = function() {

      app.css({
        'margin-top' : -(Math.round(app.innerHeight()/2)),
        'margin-left' : -(Math.round(app.innerWidth()/2)),
        'opacity' : 1
      });

    };

    $(window).on('resize', centerOverlay).trigger('resize');

  }

  app.find('button[name=cancel]').on('click', function() {
    $(document).trigger('click');
    return false;
  });

  // auto form features controllable with data attributes
  $('.form').each(function() {

    $form = $(this);

    if($form.data('autosubmit') == true) {

      $app.form.submit($form, function(r) {
        if($form.data('reload-parent') == true) {
          window.parent.location.reload();
        }
        $(document).trigger('click');
      });

    }
    
  });

})