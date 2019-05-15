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
    var Type = $(SelectSeat).data('type');

    if (Type == 'Sold') {

        alert("提醒您, 此座位不可選");

    } else {

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

            //移除陣列值
            SeatData = _.without(SeatData, Seat);
        }
    }



    $(".selectseat").text(Selected);

    return SeatData;

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
            if (data.error) {
                alert(data.messages);
            } else {
                alert(data.messages)
                window.location.href = '/movielist';
            }

        },
        error: function(data) {
            var errors = data.responseJSON;
            alert(errors.message);
        }
    });

}


var max = 2; //maximum input boxes allowed
var wrapper = $("#activitylist"); //Fields wrapper
var add_button = $("#acadd"); //Add button ID

var x = 1; //initlal text box count

function activityadd() {
    console.log(x);
    // $(add_button).click(function(e) { //on add input button click
    // e.preventDefault();
    if (x <= max) { //max input box allowed
        x++; //text box increment
        // $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        $(wrapper).append('<div class="col-md-4 col-form-label" style="margin-left: 239px;"><input id="name_en" type="text" class="form-control" name="content[]" value="" placeholder="選項內容" required><a href="#" class="remove_field">移除</a></div>'); //add input box
    } else {
        alert('已達新增上限');
    }
    // });

    $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
        // e.preventDefault();
        $(this).parent('div').remove();
        x--;
    })
}