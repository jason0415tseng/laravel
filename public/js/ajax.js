function OpenWindow(id) {
    var url = "admin/" + id;
    var screenWidth = $(window).width();
    var screenHeight = $(window).height();

    var Left = (screenWidth - 360) / 4;
    var Top = (screenHeight - 360) / 4;

    window.open(url, 'mywin', "width=560, height=360 , left=" + Left + " , top=" + Top + "");
}






//關閉視窗
function CloseWindow() {
    window.close();
}







function Update() {

    $.ajax({

        type: 'POST',
        url: '/admin/update',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            uid: $('#uid').val(),
            level: $('#level').val(),
            freeze: $("#freeze").val(),
        },
        dataType: 'json',
        success: function(data) {
            opener.window.location.reload();
            self.close();
            window.close();
        },
        error: function(data) {
            var errors = data.responseJSON;
            alert(errors.message);
            window.close();
        }
    });

}