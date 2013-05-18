$(function() {

  $('textarea').on('keydown', function() {

    var text = $(this).val();

    $('.editor .right').load(window.location.href, {
      text: text
    });

  });

});