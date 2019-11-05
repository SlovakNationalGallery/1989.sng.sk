function initInteract($element) {
  $('*').removeClass('resize');
  $('*').removeClass('drag-and-resize');

  $element.addClass('drag-and-resize');
  $container = $element.parent('.item-container');
  $container.addClass('resize');

  var preserveAspectRatio = ($element.hasClass('preserve-aspect-ratio')) ? true : false;

  if (!interact.isSet($element[0])) {
    interact($element[0])
    .draggable({
      onmove: window.dragMoveListener
    })
    .resizable({
      preserveAspectRatio: preserveAspectRatio,
      edges: { left: true, right: true, bottom: true, top: true }
    })
    .on('resizemove', function (event) {
      var target = event.target,
          x = (parseFloat(target.getAttribute('data-x')) || 0),
          y = (parseFloat(target.getAttribute('data-y')) || 0);

      // update the element's style
      target.style.width  = event.rect.width + 'px';
      target.style.height = event.rect.height + 'px';

      // translate when resizing from top or left edges
      x += event.deltaRect.left;
      y += event.deltaRect.top;

      target.style.left = x + 'px';
      target.style.top = y + 'px';

      target.setAttribute('data-x', x);
      target.setAttribute('data-y', y);
      // target.textContent = Math.round(event.rect.width) + '×' + Math.round(event.rect.height);
    });
  }

  if (!interact.isSet($container[0])) {
    interact($container[0])
      .resizable({
        edges: { left: false, right: false, bottom: true, top: false }
      })
      .on('resizemove', function (event) {
        var target = event.target;
        target.style.height  = event.rect.height + 'px';
      });
    }
}

$('.item').on('click', function (event) {
  initInteract($(this));
})

function dragMoveListener (event) {
  var target = event.target,

  // keep the dragged position in the data-x/data-y attributes
  x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
  y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

  // translate the element
  target.style.left = x + 'px';
  target.style.top = y + 'px';

  // update the posiion attributes
  target.setAttribute('data-x', x);
  target.setAttribute('data-y', y);
}

function exportItems() {
  var data = {};
  data['windowWidth'] = $( window ).width();
  data['items'] = {};

  $( '.item' ).each(function( index ) {
    var id = $(this).data('id');
    $container = $(this).parent('.item-container');
    data['items'][id] = {};
    data['items'][id]['pos-x'] = $(this).data('x');
    data['items'][id]['pos-y'] = $(this).data('y');
    data['items'][id]['width'] = $(this).width();
    data['items'][id]['height'] = $(this).height();
    data['items'][id]['container'] = $container.height();
  });

  return JSON.stringify(data);
}

function save() {
  $('#save').addClass("disabled");
  $('#save').html("saving...");
  $.ajax({
      url: './save',
      type: "POST",
      data: exportItems(),
      contentType: "application/json",
      // complete: callback
      success: function(data){
        $('#save').html("success");
        window.setTimeout(function () {
             $('#save').html("save");
             $('#save').removeClass("disabled");
         }, 2000);

      },
      failure: function(errMsg) {
        alert(errMsg);
      }
  });
}

window.dragMoveListener = dragMoveListener;


$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
});