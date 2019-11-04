document.addEventListener("DOMContentLoaded", function() {



});

function initInteract($element) {
  // item
  $element.addClass('drag-and-resize');
  $container = $element.parent('.item-container');
  $container.addClass('resize');

  interact($element[0])
  .draggable({
    onmove: window.dragMoveListener
  })
  .resizable({
    preserveAspectRatio: true,
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

  interact($container[0])
    .resizable({
      edges: { left: false, right: false, bottom: true, top: false }
    })
    .on('resizemove', function (event) {
      var target = event.target;
      target.style.height  = event.rect.height + 'px';
    });
}

function disableInteract() {
  $('*').removeClass('resize');
  $('*').removeClass('drag-and-resize');
}

$('.item').on('click', function (event) {
  disableInteract();
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

function exportPhoto() {
  var $item = $( '.drag-and-resize' ).first();
  var $itemContainer = $( '.resize' ).first();

  var data = {};
  data['windowWidth'] = $( window ).width();
  data['item'] = {};
  data['item']['id'] = $item.data('id');
  data['item']['pos-x'] = $item.data('x');
  data['item']['pos-y'] = $item.data('y');
  data['item']['width'] = $item.width();
  data['item']['height'] = $item.height();
  data['item']['container'] = $itemContainer.height();
  return JSON.stringify(data);
}

function save() {
  $('#save').addClass("disabled");
  $('#save').html("saving...");
  $.ajax({
      url: './save',
      type: "POST",
      data: exportPhoto(),
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