$(function() {

  $('.form form').on('submit', function() {

    $form = $(this);

    var url  = $form.find('[name=url]').val();
    var text = $form.find('[name=text]').val();
    var area = $('textarea.wysiwtf-is-active', window.parent.document);

    // make sure the area is again focused
    area.focus();
    $(document).trigger('click');
    
    if(url == '') {
      return false;
    } else if(text == '') {
      var tag  = '(email: ' + url + ')';
    } else {
      var tag  = '(email: ' + url + ' text: ' + text + ')';
    }

    area.wysiwtf().wysiwtf('tag', tag);
    return false;

  });

});