window.repositionItems = function() {
  var DEFAULT_CONTAINER_WIDTH = 1280;
  if ( $(window).width() >= DEFAULT_CONTAINER_WIDTH ) {

    var ratio = $( window ).width() / DEFAULT_CONTAINER_WIDTH;

    $( '.item-container' ).each(function( index ) {
      var height = $(this).data('orig-height') || 0;
      $(this).css("height", height * ratio);
    });

    $( '.item' ).each(function( index ) {
      var width = $(this).data('orig-width') || 0;
      var height = $(this).data('orig-height') || 0;

      var x = (parseFloat($(this).data('orig-x')) || 0) * ratio;
      var y = (parseFloat($(this).data('orig-y')) || 0) * ratio;

      $(this).css("height", height * ratio);
      $(this).css("width", width * ratio);

      $(this).css("left", x + 'px');
      $(this).css("top", y + 'px');

      $(this).attr('data-x', x)
      $(this).attr('data-y', y)

    });
  }
}

