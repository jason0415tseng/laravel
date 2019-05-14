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

var Count = 0;
var Selected = 0;
var SeatData = new Array;

function seat(_this) {

    var SeatLimit = $('#ticket').attr('value');
    var SelectSeat = _this;
    var Seat = $(SelectSeat).attr('value');

    if (!($(SelectSeat).hasClass('Select'))) {

        if (Selected == SeatLimit) {

            alert("已達可選上限");

        } else {

            $(SelectSeat).addClass('Select');
            Selected++;
            Count++;

            //加至陣列
            SeatData.push(Seat);
        }
    } else {

        $(SelectSeat).removeClass('Select');

        Count = 0;
        Selected--;
        // SeatData.pop($(SelectSeat).attr('value'));
        SeatData = _.without(SeatData, Seat);
    }

    $(".selectseat").text(Selected);

    return SeatData;
    console.log(Count);
    console.log(Selected);
    console.log(Seat);
    console.log(SeatData);
    // console.log(_.without(SeatData,Seat));
    // alert(SeatData);
    // console.log(SeatData);
}

function Order(id) {

    // var hall = $('#hall').attr('value');
    // var date = $('#date').attr('value');
    // var seat = $('#seat').attr('value');
    // var name = $('#name').attr('value');
    // var url = '/movielist/order/' + id;
    // alert(seat);
    // alert(hall);
    // alert(date);
    // return;
    $.ajax({

        type: 'POST',
        url: '/movielist/order/' + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id,
            hall: $('#hall').attr('value'),
            date: $('#date').attr('value'),
            ticket: $('#ticket').attr('value'),
            seat: SeatData,
        },
        dataType: 'json',
        success: function(data) {
            // var errors = data.responseJSON;
            // console.log(errors.message);
            if (data.error) alert(data.messages);
            // opener.window.location.reload();
            // self.close();
            // window.close();
        },
        error: function(data) {
            var errors = data.responseJSON;
            alert(errors.message);
            window.close();
        }
    });

}