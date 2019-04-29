function OpenWindow(id) {
    var url = "admin/" + id;
    var screenWidth = $(window).width();
    var screenHeight = $(window).height();
    // var scrolltop = $(document).scrollTop();//獲取當前視窗距離頁面頂部高度
    var Left = (screenWidth - 360) / 4;
    var Top = (screenHeight - 360) / 4;

    window.open(url, 'mywin', "width=360, height=360 , left=" + Left + " , top=" + Top + "");
}






//關閉視窗
function CloseWindow() {
    //   <span style="color: #FF3300">opener</span>.document.form1.msg.value =
    //          document.form2.msg.value;
    //   <span style="color: #FF9900">window.close();</span>
    window.close();
}







function Update() {
    // var uid = id;
    // console.log(id);
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });
    $.ajax({
        // var uid : 'id'
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
            // alert(data);
            // console.log(data);
            // $('#frmAddTask').trigger("reset");
            // $("#frmAddTask .close").click();
            opener.window.location.reload();
            self.close();
            window.close();
        },
        error: function(data) {
            var errors = $.parseJSON(data.responseText);
            alrert(errors);
            // $('#add-task-errors').html('');
            // $.each(errors.messages, function(key, value) {
            //     $('#add-task-errors').append('<li>' + value + '</li>');
            // });
            // $("#add-error-bag").show();
        }
    });
    // window.close();
    // window.location.reload();
}

function deleteuser() {
    // alert("確定要刪除?");
    if (confirm("確定要刪除?")) {
        alert("你按下確定");
    } else {
        alert("你按下取消");
    }
}