function checkDate(e) {
    $(e).removeClass("errInput");
    var string = $(e).val();
    var theDate = string.split("/");
    var err = false;
    switch (theDate.length) {

        case 0:
            break;
        case 1:
            if (checkDay(theDate[0]) == false) {
                $(e).addClass("errInput");
                return;
            }
            if (theDate[0].length > 1) {
                $(e).val($(e).val() + "/");
            }
            else {
                $(e).val("0" + $(e).val() + "/");
            }
            break;
        case 2:
            if (theDate[0] == "" || theDate[0].length == 0) {
                $(e).addClass("errInput");
                return;
            }
            if (checkDay(theDate[0]) == false) {
                $(e).addClass("errInput");
                return;
            }
            if (checkMonth(theDate[1]) == false) {
                $(e).addClass("errInput");
                return;
            }
            if (theDate[1].length > 1)
                $(e).val($(e).val() + "/");
            else if (theDate[1].length == 1 && parseInt(theDate[1]) > 3)
                $(e).val(theDate[0] + "/0" + theDate[1] + "/");
            break;
        case 3:
            if (theDate[0] == "" || theDate[0].length == 0) {
                $(e).addClass("errInput");
                return;
            }
            if (theDate[1] == "" || theDate[1].length == 0) {
                $(e).addClass("errInput");
                return;
            }
            if (checkDay(theDate[0]) == false) {
                $(e).addClass("errInput");
                return;
            }
            if (checkMonth(theDate[1]) == false) {
                $(e).addClass("errInput");
                return;
            }
            if (theDate[1].length == 1) {
                $(e).val(theDate[0] + "/0" + theDate[1] + "/" + theDate[2]);
            }
            if (checkYear(theDate[2]) == false) {
                $(e).addClass("errInput");
                return;
            }
            return true;
            break;
        default:
            $(e).addClass("errInput");
            err = true;
            break;
    }
}

function checkDay(d) {
    var MAXDAY = 12;
    if (d.length == 0 || d == "") {
        return false;
    }
    for (var i = 0; i < d.length; i++) {
        if (d.charAt(i) > "9" || d.charAt(i) < "0") {
            return false;
        }
    }
    if (parseInt(d) > MAXDAY || parseInt(d) < 1) {
        return false;
    }
    if (d.length > 2) {
        return false;
    }
    return true;
}

function checkMonth(m) {
    var MAXMONTH = 31;
    if (m.length == 0 || m == "") {
        return false
    }
    for (var i = 0; i < m.length; i++) {
        if (m.charAt(i) > "9" || m.charAt(i) < "0") {
            return false;
        }
    }
    if (parseInt(m) > MAXMONTH || parseInt(m) < 1) {
        return false;
    }
    if (m.length > 2) {
        return false;
    }
    return true;
}

function checkYear(y) {
    if (y.length == 0 || y == "") {
        return false;
    }
    var MAXYEAR = new Date();
    MAXYEAR = MAXYEAR.getFullYear();
    for (var i = 0; i < y.length; i++) {
        if (y.charAt(i) > "9" || y.charAt(i) < "0") {
            return false;
        }
    }
    if (parseInt(y) < 1900 || parseInt(y) > MAXYEAR) {
        return false;
    }
    if (y.length > 4) {
        return false;
    }
    return true;
}

function FormatNumber(obj) {
    var strvalue;

    if (eval(obj))
        strvalue = eval(obj).value;
    else
        strvalue = obj;
    var num;
    num = strvalue.toString().replace(/\$|\./g, '');
    if (isNaN(num))
        num = "";
    sign = (num == (num = Math.abs(num)));

    num = Math.floor(num * 100 + 0.50000000001);
    num = Math.floor(num / 100).toString();
    if (num == 0) {
        num = '';
    }

    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
    //return (((sign)?'':'-') + num);
    eval(obj).value = (((sign) ? '' : '-') + num);
}

$('.dtDatePicker').datetimepicker({
    format:'d/m/Y',
    timepicker:false,
    mask:true,
});
$(".datepicker").datepicker({
    dateFormat: 'dd/mm/yy',
    changeYear: true,
    changeMonth: true,
    showOtherMonths: true,
    selectOtherMonths: true,
    yearRange: '1940:2100',
});
$('.datepicker').mask('00/00/0000');
$(".datepnewpicker").datepicker({dateFormat: 'yy'});

$('.dot').keypress(function(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    if (key.length == 0) return;
    var regex = /^[0-9.,\b]+$/;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
});

$('#formCV').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
});


$('input').keydown( function(e) {
    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    if(key == 13) {
        e.preventDefault();
        var inputs = $(this).closest('form').find(':input:visible');
        inputs.eq( inputs.index(this)+ 1 ).focus();
    }
});

$('select').keydown( function(e) {
    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    if(key == 13) {
        e.preventDefault();
        var inputs = $(this).closest('form').find(':input:visible');
        inputs.eq( inputs.index(this)+ 1 ).focus();
    }
});
$('.chosen').chosen();
