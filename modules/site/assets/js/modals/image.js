$(function() {

  $('.form figure').on('click', function() {

    var area = $('textarea.wysiwtf-is-active', window.parent.document);
    var url  = $(this).data('url');
    var tag  = '(image: ' + url + ')';

    // make sure the area is again focused
    area.focus();
    $(document).trigger('click');

    area.wysiwtf().wysiwtf('tag', tag);
    return false;

  });

});