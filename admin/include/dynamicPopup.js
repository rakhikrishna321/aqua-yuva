$(document).on('click', '.dynamicPopup-sm', function(e) {
    e.preventDefault();
    var url = $(this).data('url');
    $('.popupContent-sm').html('<center><p class="my-5">please wait</p></center>');
    $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html'
        })
        .done(function(data) {
            $('.popupContent-sm').html('<center><p class="my-5">please wait</p></center>');
            $('.popupContent-sm').html(data);
        })
        .fail(function() {
            $('.popupContent-sm').html('<div class="modal-body"><h4 class="text-muted text-center">uh-oh<br>Something went wrong!</h4></div><div class="modal-footer p-0"><div class="btn-group p-0 w-100"><button type="button" class="btn btn-block w-50 text-danger m-0 py-2 bg-white" data-dismiss="modal">CLOSE</button><button type="button" onclick="location.reload(true);" class="btn btn-block w-50 text-primary m-0 py-2 border-left bg-white">RELOAD</button></div></div>');
        });
});
$(document).on('click', '.dynamicPopup-md', function(e) {
    e.preventDefault();
    var url = $(this).data('url');
    $('.popupContent-md').html('<center><p class="my-5">please wait</p></center>');
    $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html'
        })
        .done(function(data) {
            $('.popupContent-md').html('<center><p class="my-5">please wait</p></center>');
            $('.popupContent-md').html(data);
        })
        .fail(function() {
            $('.popupContent-md').html('<div class="modal-body"><h4 class="text-muted text-center">uh-oh<br>Something went wrong!</h4></div><div class="modal-footer p-0"><div class="btn-group p-0 w-100"><button type="button" class="btn btn-block w-50 text-danger m-0 py-2 bg-white" data-dismiss="modal">CLOSE</button><button type="button" onclick="location.reload(true);" class="btn btn-block w-50 text-primary m-0 py-2 border-left bg-white">RELOAD</button></div></div>');
        });
});
$(document).on('click', '.dynamicPopup-lg', function(e) {
    e.preventDefault();
    var url = $(this).data('url');
    $('.popupContent-lg').html('<center><p class="my-5">Please wait, your data is decrypting...</p></center>');
    $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html'
        })
        .done(function(data) {
            $('.popupContent-lg').html('<center><p class="my-5">please wait</p></center>');
            $('.popupContent-lg').html(data);
        })
        .fail(function() {
            $('.popupContent-lg').html('<div class="modal-body"><h4 class="text-muted text-center">uh-oh<br>Something went wrong!</h4></div><div class="modal-footer p-0"><div class="btn-group p-0 w-100"><button type="button" class="btn btn-block w-50 text-danger m-0 py-2 bg-white" data-dismiss="modal">CLOSE</button><button type="button" onclick="location.reload(true);" class="btn btn-block w-50 text-primary m-0 py-2 border-left bg-white">RELOAD</button></div></div>');
        });
});
$(document).on('click', '.dynamicPopup-video', function(e) {
    e.preventDefault();
    var url = $(this).data('url');
    $('.popupContent-video').html('<center><p class="my-5">please wait</p></center>');
    $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html'
        })
        .done(function(data) {
            $('.popupContent-video').html('<center><p class="my-5">please wait</p></center>');
            $('.popupContent-video').html(data);
        })
        .fail(function() {
            $('.popupContent-video').html('<div class="modal-body"><h4 class="text-muted text-center">uh-oh<br>Something went wrong!</h4></div><div class="modal-footer p-0"><div class="btn-group p-0 w-100"><button type="button" class="btn btn-block w-50 text-danger m-0 py-2 bg-white" data-dismiss="modal">CLOSE</button><button type="button" onclick="location.reload(true);" class="btn btn-block w-50 text-primary m-0 py-2 border-left bg-white">RELOAD</button></div></div>');
        });
});