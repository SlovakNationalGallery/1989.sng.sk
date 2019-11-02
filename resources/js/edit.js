document.addEventListener("DOMContentLoaded", function() {

  interact('.drag-and-resize',  {})
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


  interact('.resize')
    .resizable({
      edges: { left: false, right: false, bottom: true, top: false }
    })
    .on('resizemove', function (event) {
      var target = event.target;
      target.style.height  = event.rect.height + 'px';
    });


  // this is used later in the resizing and gesture demos
});

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
    var $photo = $( '.drag-and-resize' ).first();
    var $photoContainer = $( '.resize' ).first();

    var data = {};
    data['windowWidth'] = $( window ).width();
    data['photo'] = {};
    data['photo']['id'] = $photo.data('id');
    data['photo']['pos-x'] = $photo.data('x');
    data['photo']['pos-y'] = $photo.data('y');
    data['photo']['width'] = $photo.width();
    data['photo']['height'] = $photo.height();
    data['photo']['container'] = $photoContainer.height();
    return JSON.stringify(data);
  }

  function save() {
    $.ajax({
        url: '/save',
        type: "POST",
        data: exportPhoto(),
        contentType: "application/json",
        // complete: callback
        success: function(data){
          $("#result").html('<div class="alert alert-success  offset4 span4"><button type="button" class="close">×</button>'+data.response+'</div>');
          window.setTimeout(function () {
               $(".alert").fadeTo(500, 0).slideUp(500, function () {
                   $(this).remove();
               });
           }, 5000);

        },
        failure: function(errMsg) {
          alert(errMsg);
        }
    });
  }

  window.dragMoveListener = dragMoveListener;


  // $(function () {
  //     $.ajaxSetup({
  //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  //     });
  // });