$(function() {

  var sort = $('.pages');

  if(sort.length) {
    sort.sortable({ 
      scroll: true,
      connectWith: sort,
      handle: '.page-num',
      receive : function(e, ui) {
  
        var visibleList    = $('.subpages .visible')
        var countVisible   = visibleList.find('li').not('.empty').length;
        var invisibleList  = $('.subpages .invisible')
        var countInvisible = invisibleList.find('li').not('.empty').length;
  
        if(countVisible == 0) {
          visibleList.find('.empty').removeClass('hide');
        } else {
          visibleList.find('.empty').addClass('hide');
        }
  
        if(countInvisible == 0) {
          invisibleList.find('.empty').removeClass('hide');
        } else {
          invisibleList.find('.empty').addClass('hide');
        }
  
        if(ui.sender.hasClass('visible')) {
          ui.item.find('input').attr('name', 'invisible[]');
        } else {
          ui.item.find('input').attr('name', 'visible[]');
        }
      }
    }).disableSelection();
  }

});