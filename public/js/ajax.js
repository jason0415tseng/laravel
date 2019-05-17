//開啟視窗
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

//更新
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
var SeatData = [];
var SeatText = [];

function seat(_this) {
    var SeatLimit = $('#ticket').attr('value');
    var SelectSeat = _this;
    var Seat = $(SelectSeat).attr('value');
    var Type = $(SelectSeat).data('type');
    var Row = $(SelectSeat).data('row');
    var Col = $(SelectSeat).data('col');

    if (Type == 'Sold') {
        alert("提醒您, 此座位不可選");
    } else {
        if (!($(SelectSeat).hasClass('P'))) {
            if (Selected == SeatLimit) {
                alert("已達可選上限");
            } else {
                $(SelectSeat).addClass('P');
                Selected++;
                Count++;

                //加至陣列
                SeatText.push(Row + '排' + Col + '號');
                SeatData.push(Seat);
            }
        } else {
            $(SelectSeat).removeClass('P');
            Count = 0;
            Selected--;

            //移除陣列值
            SeatData = _.without(SeatData, Seat);
            SeatText = _.without(SeatText, Row + '排' + Col + '號');
        }
    }

    $(".selectseat").text(SeatText);
    $(".selectnumber").text(Selected);

    return SeatData, Selected;
}

function Order(id) {
    var ticket = $('#ticket').attr('value');
    if (Selected == 0) {
        alert("尚未選擇任何座位");
        return false;
    } else if (Selected != ticket) {
        alert("請選擇剩餘座位");
        return false;
    }
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
            ticket: ticket,
            seat: SeatData,
        },
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                if (data.status == 1) {
                    alert(data.messages);
                    window.location.reload();
                } else if (data.status == 2) {
                    alert(data.messages);
                    window.location.href = data.url;
                } else {
                    alert(data.messages);
                }
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
    if (x <= max) { //max input box allowed
        x++; //text box increment
        $(wrapper).append('<div class="col-md-4 col-form-label" style="margin-left: 239px;"><input id="name_en" type="text" class="form-control" name="content[]" value="" placeholder="選項內容" required><a href="#" class="remove_field">移除</a></div>'); //add input box
    } else {
        alert('已達新增上限');
    }

    $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
        $(this).parent('div').remove();
        x--;
    })
}