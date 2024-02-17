var current = "";
$(document).ready(function () {
    $(function () {
        var url = window.location;
        // for single sidebar menu
        $('ul.nav-sidebar a').filter(function () {
            return this.href == url;
        }).addClass('active');

        // for sidebar menu and treeview
        $('ul.nav-treeview a').filter(function () {
            return this.href == url;
        }).parentsUntil(".nav-sidebar > .nav-treeview")
            .css({ 'display': 'block' })
            .addClass('menu-open').prev('a')
            .addClass('active');
    });
    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('wheel.disableScroll', function (e) {
            e.preventDefault();
        });
    });
    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('keydown', function (e) {
            if (e.which === 38 || e.which === 40) {
                e.preventDefault();
            }
        });
    });
    $('form').on('blur', 'input[type=number]', function (e) {
        $(this).off('wheel.disableScroll');
    });
    $("input[type=text]").attr('autocomplete', "off");
    $('#selecctall').click(function (event) {  //on click
        if (this.checked) { // check select status
            $('.checkbox1').each(function () { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        } else {
            $('.checkbox1').each(function () { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });
        }
    });
    $(':text').focus(function () {
        current = this;
    });
    $('textarea').focus(function () {
        current = this;
    });
    //setTimeout('$("select").select2()',1000);
    $("select").not('.notselect2').select2();
});
function onready() {
    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('wheel.disableScroll', function (e) {
            e.preventDefault();
        });
    });
    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('keydown', function (e) {
            if (e.which === 38 || e.which === 40) {
                e.preventDefault();
            }
        });
    });
    $('form').on('blur', 'input[type=number]', function (e) {
        $(this).off('wheel.disableScroll');
    });
    $("input[type=text]").attr('autocomplete', "off");
    $('#selecctall').click(function (event) {  //on click
        if (this.checked) { // check select status
            $('.checkbox1').each(function () { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        } else {
            $('.checkbox1').each(function () { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });
        }
    });
    $(':text').focus(function () {
        current = this;
    });
    $('textarea').focus(function () {
        current = this;
    });
    //setTimeout('$("select").select2()',1000);
    $("select").not('.notselect2').select2();
}
function checkposition(qwerty) {
    $(current).html($(current).html() + qwerty);
    $(current).val($(current).val() + qwerty);
}
//check if pressed key is a number or not
function isNumericKeyStroke() {
    var returnValue = false;
    var keyCode = (window.event.which) ? window.event.which : window.event.keyCode;
    if (((keyCode >= 48) && (keyCode <= 57)) || // All numerics
        (keyCode == 8) || // Backspace
        (keyCode == 13))     // Carriage Return
        returnValue = true;
    if (window.event.returnValue)
        window.event.returnValue = returnValue;
    return returnValue;
}
function biddisplay(selIDS, selType) {
    if (selType == "show") {
        jQuery("#more_info_" + selIDS).show('10');
        jQuery("#showAll" + selIDS).hide();
        jQuery("#hideAll" + selIDS).show();
    } else {
        jQuery("#more_info_" + selIDS).hide('10');
        jQuery("#showAll" + selIDS).show();
        jQuery("#hideAll" + selIDS).hide();
    }
}
function showfield(source, target) {
    var chkstatus = $("#" + source).is(':checked');
    if (chkstatus) {
        jQuery("#" + target).show();
    } else {
        jQuery("#" + target).hide();
        jQuery("#" + target).val("");
    }
}
function isEmpty(str) {
    return (!str || 0 === str.length);
}
//set a bassic calender
function setcalender(dateid) {
    if ($("#" + dateid).data("datepicker") !== null) {
        // datepicker initialized
        $("#" + dateid).attr("readonly", true);
        $("#" + dateid).datepicker({
            defaultDate: new Date(),
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            yearRange: "1942:" + Date("yyyy"),
            format: 'dd/mm/yy',
            dateFormat: 'dd/mm/yy',
        });
        $("#" + dateid).datepicker("show");
    }
}
function setcalenderfuturedate(dateid) {
    if ($("#" + dateid).data("datepicker") !== null) {
        // datepicker initialized
        $("#" + dateid).attr("readonly", true);
        $("#" + dateid).datepicker({
            defaultDate: new Date(),
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            dateFormat: 'dd/mm/yy',
            format: 'dd/mm/yy',
        });
        $("#" + dateid).datepicker("show");
    }
}
function setbuttoncalender(dateid) {
    if ($("#" + dateid).data("datepicker") !== null) {
        // datepicker initialized
        $("#" + dateid).datepicker({
            defaultDate: new Date(),
            changeMonth: true,
            showOn: "button",
            buttonImage: "images/calendar.png",
            changeYear: true,
            numberOfMonths: 1,
            buttonText: "Select date",
            dateFormat: 'dd/mm/yy',
            dateFormat: "dd/mm/yy"
        });
        $("#" + dateid).datepicker("show");
    }
}
function setcalendernolimit(dateid) {
    if ($("#" + dateid).data("datepicker") !== null) {
        // datepicker initialized
        $("#" + dateid).attr("readonly", true);
        $("#" + dateid).datepicker({
            defaultDate: new Date(),
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            dateFormat: "dd/mm/yy"
        });
        $("#" + dateid).datepicker("show");
    }
}
function setcalendertimenolimit(dateid) {
    if ($("#" + dateid).data("datepicker") !== null) {
        // datepicker initialized
        $("#" + dateid).attr("readonly", true);
        $("#" + dateid).datetimepicker()({
            defaultDate: new Date(),
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            dateFormat: "dd/mm/yy",
            timeFormat: "HH:mm:ss"
        });
        $("#" + dateid).datepicker("show");
    }
}
function setcalenderlimit(dateid, start, end) {
    if ($("#" + dateid).data("datepicker") !== null) {
        // datepicker initialized
        $("#" + dateid).attr("readonly", true);
        $("#" + dateid).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            yearRange: "1942:" + Date("yyyy"),
            dateFormat: "dd/mm/yy",
            minDate: start,
            maxDate: end
        });
        $("#" + dateid).datepicker("show");
    }
}
function setcalendermin(dateid, start) {
    if ($("#" + dateid).data("datepicker") !== null) {
        // datepicker initialized
        $("#" + dateid).attr("readonly", true);
        $("#" + dateid).datepicker({
            defaultDate: "+0d",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            dateFormat: "dd/mm/yy",
            minDate: start,
        });
        $("#" + dateid).datepicker("show");
    }
}
function setcalendermax(dateid, end) {
    if ($("#" + dateid).data("datepicker") !== null) {
        // datepicker initialized
        $("#" + dateid).attr("readonly", true);
        $("#" + dateid).datepicker({
            defaultDate: "+0d",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            dateFormat: "dd/mm/yy",
            maxDate: end,
        });
        $("#" + dateid).datepicker("show");
    }
}
function daterange(from, to, mindate) {
    $("#" + from).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy",
        minDate: mindate,
        onClose: function (selectedDate) {
            $("#" + to).datepicker("option", "minDate", selectedDate);
        }
    });
    $("#" + to).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy",
        defaultDate: new Date(),
        minDate: mindate,
        onClose: function (selectedDate) {
            $("#" + from).datepicker("option", "maxDate", selectedDate);
        }
    });
    $("#" + from).datepicker("show");
}
function daterangemaxlimit(from, to, maxdate) {
    $("#" + from).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy",
        maxDate: maxdate,
        showSecond: true,
        timeFormat: 'HH:mm:ss',
        controlType: 'select',
        onClose: function (selectedDate) {
            $("#" + to).datepicker("option", "minDate", selectedDate);
        }
    });
    $("#" + to).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy",
        showSecond: true,
        timeFormat: 'HH:mm:ss',
        controlType: 'select',
        onClose: function (selectedDate) {
            var arr = selectedDate.split("/");
            if (maxdate > new Date(arr[2], arr[1], arr[0])) {
                $("#" + from).datepicker("option", "maxDate", selectedDate);
            } else {
                $("#" + from).datepicker("option", "maxDate", maxdate);
            }
        }
    });
    $("#" + from).datepicker("show");
}
function daterangelimit(from, to, mindate, maxdate) {
    $("#" + from).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy",
        minDate: mindate,
        maxDate: maxdate,
        onSelect: function (selectedDate) {
            $("#" + to).datepicker("option", "minDate", selectedDate);
        }
    });
    $("#" + to).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy",
        minDate: mindate,
        maxDate: maxdate,
        onSelect: function (selectedDate) {
            $("#" + from).datepicker("option", "maxDate", selectedDate);
        }
    });
    $("#" + from).datepicker("show");
}
function parseDate(input, format) {
    format = format || 'yyyy-mm-dd'; // default format
    var parts = input.match(/(\d+)/g),
        i = 0, fmt = {};
    // extract date-part indexes from the format
    format.replace(/(yyyy|dd|mm)/g, function (part) {
        fmt[part] = i++;
    });
    return new Date(parts[fmt['yyyy']], parts[fmt['mm']] - 1, parts[fmt['dd']]);
}
function daterangenolimit(from, to) {
    $("#" + from).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy",
        yearRange: "1942:" + Date("yyyy"),
        onClose: function (selectedDate) {
            $("#" + to).datepicker("option", "minDate", selectedDate);
            $("#" + to).datepicker('show');
        }
    });
    var myDate = new Date();
    myDate.setFullYear(myDate.getFullYear() + 5);
    $("#" + to).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy",
        changeYear: true,
        yearRange: "1942:" + (myDate.getFullYear()),
        onClose: function (selectedDate) {
            $("#" + from).datepicker("option", "maxDate", selectedDate);
        },
        onSelect: function (selectedDate, inst) {
            var input = $("#" + from).val();
            var parts = input.match(/(\d+)/g);
            var d1 = parseDate(input, 'dd/mm/yyyy')
            // get date from other text field
            var d2 = new Date(parseDate(selectedDate, 'dd/mm/yyyy'));
            // d2 -d1 gives result in milliseconds
            // calculate number of days by Math.abs((d2-d1)/86400000, as 24*3600*1000 = 86400000
            // and populate it to some text field #textfield
            var daydifferece = (Math.abs((d2 - d1) / 86400000)) + 1;
            if (daydifferece >= 7) {
                $("#errordatediv").html("You Have Selected " + daydifferece + " Days.");
            }
        }
    });
    $("#" + from).datepicker('show');
}
function timepicker(id) {
    $('#' + id).timepicker({
        showSecond: true,
        timeFormat: 'HH:mm:ss',
        controlType: 'select'
    });
    $('#' + id).timepicker('show');
}
function datetimepicker(id) {
    $('#' + id).datetimepicker({
        showSecond: true,
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd/mm/yy",
        timeFormat: 'HH:mm:ss',
        controlType: 'select'
    });
    $('#' + id).timepicker('show');
}
function datetimepickermaxlimit(id, maxdate) {
    $('#' + id).datetimepicker({
        dateFormat: "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        defaultDate: new Date(),
        maxDate: maxdate,
        showSecond: true,
        timeFormat: 'HH:mm:ss',
        controlType: 'select'
    });
    $('#' + id).timepicker('show');
}
function datepickermaxlimit(id, maxdate) {
    $('#' + id).datepicker({
        dateFormat: "dd/mm/yy",
        maxDate: maxdate,
    });
    $('#' + id).timepicker('show');
}
function datetimepickerrange(from, to) {
    $("#" + from).datetimepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy",
        showSecond: true,
        timeFormat: 'HH:mm:ss',
        controlType: 'select',
        onClose: function (selectedDate) {
            $("#" + to).datepicker("option", "minDate", selectedDate);
            $("#" + to).datepicker('show');
        }
    });
    $("#" + to).datetimepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy",
        showSecond: true,
        timeFormat: 'HH:mm:ss',
        controlType: 'select',
        onClose: function (selectedDate) {
            $("#" + from).datepicker("option", "maxDate", selectedDate);
        },
        onSelect: function (selectedDate, inst) {
            //            var input = $("#" + from).val();
            //            var parts = input.match(/(\d+)/g);
            //            var d1 = parseDate(input, 'dd/mm/yyyy')
            //
            //            // get date from other text field
            //            var d2 = new Date(parseDate(selectedDate, 'dd/mm/yyyy'));
            // d2 -d1 gives result in milliseconds
            // calculate number of days by Math.abs((d2-d1)/86400000, as 24*3600*1000 = 86400000
            // and populate it to some text field #textfield
            //            var daydifferece = (Math.abs((d2 - d1) / 86400000)) + 1;
            //            if (daydifferece >= 7) {
            //                $("#errordatediv").html("You Have Selected " + daydifferece + " Days.");
            //            }
        }
    });
    $("#" + from).datepicker('show');
}
function datetimepickerrangemaxfixed(from, to, maxdate) {
    $("#" + from).datetimepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        maxDate: maxdate,
        dateFormat: "dd/mm/yy",
        showSecond: true,
        timeFormat: 'HH:mm:ss',
        controlType: 'select',
        onClose: function (selectedDate) {
            $("#" + to).datepicker("option", "minDate", selectedDate);
            $("#" + to).datepicker('show');
        }
    });
    $("#" + to).datetimepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy",
        showSecond: true,
        timeFormat: 'HH:mm:ss',
        controlType: 'select',
        onSelect: function (selectedDate, inst) {
            //            var input = $("#" + from).val();
            //            var parts = input.match(/(\d+)/g);
            //            var d1 = parseDate(input, 'dd/mm/yyyy')
            // get date from other text field
            var d2 = new Date(parseDate(selectedDate, 'dd/mm/yyyy'));
            // d2 -d1 gives result in milliseconds
            // calculate number of days by Math.abs((d2-d1)/86400000, as 24*3600*1000 = 86400000
            // and populate it to some text field #textfield
            //            var daydifferece = (Math.abs((d2 - d1) / 86400000)) + 1;
            //            if (daydifferece >= 7) {
            //                $("#errordatediv").html("You Have Selected " + daydifferece + " Days.");
            //            }
        }
    });
    $("#" + from).datepicker('show');
}
function addoverlay() {
    var overlay = jQuery('<div id="overlay"> </div>');
    overlay.appendTo(document.body);
}
function removeoverlay() {
    $("#overlay").remove();
}
function sendForm(custom, value, target, rid, formid, tiny) {
    console.log('hii')
    let submitcheck;
    // if (tiny === 'Login') {
    $('#customConfirmModal').modal('show');
    // } else {
    //     submitcheck = confirm("Are You Sure You Want To Proceed?");
    // }
    window.handleCustomConfirm = function (proceed) {
        if (proceed) {
            //     console.log('proccedd')
            //     // User clicked "Proceed," perform your actions here
            //     addoverlay();
            //     var optionsWarning = {
            //         // ... (your existing code)
            //     };
            // }

            // Close the modal
            // $('#customConfirmModal').modal('hide');
            console.log('fff')
            // if (submitcheck) {
            addoverlay();
            var optionsWarning = {
                validateTillInvalid: true,
                template: '<div class="help-block">{message}</div>', // template for messages
                formGroupInvalidClass: 'has-error',
                formGroupValidClass: '', // has-success
                showMessages: true, // you can set this to false for inline forms

                // Selector for element with 'form-group' class.
                // If selector is not #id, search with .closest() is used.
                formGroup: '.form-group',

                // Selector for element to append validation message.
                // If selector is not #id, search with .closest() is used.
                // If not found 'form-group' element is used.
                msgParent: '.bvalidator-bs3form-msg',

                dataOptionNamespace: 'bvalidatorTheme', // data-bvalidator-theme- attributes
                presenter: 'Bs3FormPresenter'

            }
            $('#' + formid).bValidator(optionsWarning);
            //        var overlay = jQuery('<div id="overlay"> </div>');
            //        overlay.appendTo(document.body);
            if ($('#' + formid).data('bValidator').validate()) {
                var str = formid;
                var nau = str.search("for");
                if (tiny > 0) {
                    tinymce.triggerSave();
                }
                var oOutput = document.getElementById(rid);
                oData = new FormData(document.forms.namedItem(formid));
                oData.append(custom, value);
                //alert(oData.entries());
                var resultid = rid;
                var oReq = new XMLHttpRequest();
                oReq.open("POST", target, true);
                oReq.onload = function (oEvent) {
                    oOutput.style.display = "block";
                    if (oReq.status == 200) {
                        removeoverlay();
                        var ns = oReq.responseText.indexOf("FillSelect");
                        if (n >= 0) {
                            var rs = oReq.responseText.replace('FillSelect :', 'Success :');
                            var res = rs.split('sdata')
                            var url = res[1];
                            alertify.alert('Result', res[0], function () {
                                oOutput.innerHTML = res[1];

                            });
                        }
                        var n = oReq.responseText.indexOf("Reload");
                        if (n >= 0) {
                            oOutput.innerHTML = "Successful";

                            var rs = oReq.responseText.replace('Reload :');
                            $(':text').focus(function () {
                                current = this;
                            });
                            $('textarea').focus(function () {
                                current = this;
                            });
                            alertify.alert('Result', rs, function () {

                                setTimeout(location.reload(), 3000);
                            });
                        } else if (oReq.responseText.indexOf("Redirect :") != -1) {
                            var rs = oReq.responseText.replace('Redirect :', 'Success :');
                            const urlStartIndex = rs.indexOf("URL") + 3; // Add 3 to exclude "URL" itself
                            const url2 = rs.substring(urlStartIndex);
                            var res = rs.split('URL')
                            var url = res[1];

                            oOutput.innerHTML = '<div  class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">' + res[0] + '</div>';
                            //                        alert(res[0]);
                            $(':text').focus(function () {
                                current = this;
                            });
                            $('textarea').focus(function () {
                                current = this;
                            });
                            alertify.alert('Result', res[0], function () {

                                window.location.href = url2;
                            });

                        } else if (oReq.responseText.indexOf("CALLBACK :") != -1) {
                            var rs = oReq.responseText.replace('CALLBACK :', 'Success :');
                            var res = rs.split('NEWJS')
                            var url = res[1];

                            oOutput.innerHTML = '<div  class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">' + res[0] + '</div>';
                            eval(url)();
                        } else if (oReq.responseText.indexOf("Error :") != -1) {
                            oOutput.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">' + oReq.responseText + '</div>';
                        } else {
                            if (rid == "reviewtext") {
                                $("textarea#reviewtext").val(oReq.responseText);
                            } else {
                                oOutput.innerHTML = oReq.responseText;
                                removeoverlay();
                            }
                        }
                        $(':text').focus(function () {
                            current = this;
                        });
                        $('textarea').focus(function () {
                            current = this;
                        });
                        $("select").select2();
                    } else {
                        oOutput.innerHTML = "Error " + oReq.status + " occurred uploading your file.<br \/>";
                        removeoverlay();
                    }
                };
                oReq.send(oData);
            } else {
                removeoverlay();
                alertify.alert('Validation', "Check For Validation", function () {

                    alertify.success('Check For Validation');
                });

            }
        }
        $('#customConfirmModal').modal('hide');
    }
}
//checkcalibratuion point is in range or not
function calibcheck(source, minvaue, maxvalue) {
    var val = parseFloat(source.value);
    var max = maxvalue;
    var min = minvaue;
    if ((val < min) || ((val > max))) {
        alertify.confirm("This is out of acceptable limit, Do you want to continue \n You Entered " + val + "\n minimum acceptable value is" + min + "\n maximum acceptable value is" + max,
            function () {
                alertify.success('Ok');
            },
            function () {
                document.getElementById(source.id).value = "";
            });
    }
}
$(function () {
    $('body').on('click', '.input_date', function () {
        $(this).datepicker('destroy').datepicker({ showOn: 'focus' }).focus();
    });
});
function changeprice() {
    var basic = $("#salaryoffered").val();
    var hra = $("#hra").val();
    var ta = $("#ta").val();
    var fa = $("#fa").val();
    var oa = $("#oa").val();
    var gross = parseFloat(basic) + parseFloat(hra) + parseFloat(ta) + parseFloat(fa) + parseFloat(oa);
    $('#gross').val(gross);
}
function calculatesalary() {
    var totalworkingdays = parseFloat($('#totalworkingdays').val());
    var presentday = parseFloat($('#presentdays').val());
    var el = parseFloat($('#el').val());
    var cl = parseFloat($('#cl').val());
    var presentdays = parseFloat(presentday) + parseFloat(el) + parseFloat(cl);
    var defaultbasicda = parseFloat($('#defaultbasicda').val());
    var defaulthra = $('#defaulthra').val();
    var defaultta = $('#defaultta').val();
    var defaultfa = $('#defaultfa').val();
    var defaultoa = $('#defaultoa').val();
    var defaultgross = $('#defaultgross').val();
    var onedaysalary = parseFloat(defaultbasicda) / totalworkingdays;
    var bonus = Math.round(onedaysalary * presentdays * 8.33 / 100);
    var od = $('#od').val();
    var basicda = Math.round((parseFloat(defaultbasicda) / parseFloat(totalworkingdays)) * parseFloat(presentdays));
    var hra = Math.round((parseFloat(defaulthra) / totalworkingdays) * presentdays);
    var ta = Math.round((parseFloat(defaultta) / totalworkingdays) * presentdays);
    var fa = Math.round((parseFloat(defaultfa) / totalworkingdays) * presentdays);
    var oa = Math.round((parseFloat(defaultoa) / totalworkingdays) * presentdays);
    var ot = 0;
    // alert(parseFloat(defaultbasicda)+"<"+parseFloat(basicda)+"="+(parseFloat(defaultbasicda)<parseFloat(basicda)));
    if (Math.round(parseFloat(defaultbasicda)) < Math.round(parseFloat(basicda))) {
        ot = parseFloat(basicda) - parseFloat(defaultbasicda);
        basicda = defaultbasicda;
    }
    if (Math.round(parseFloat(defaulthra)) < Math.round(parseFloat(hra))) {
        ot = parseFloat(ot) + (Math.round(parseFloat(hra)) - Math.roundparse(Float(defaulthra)));
        hra = defaulthra;
    }
    if (Math.round(parseFloat(defaultta)) < Math.round(parseFloat(ta))) {
        ot = parseFloat(ot) + (parseFloat(ta) - parseFloat(defaultta));
        ta = defaultta;
    }
    if (Math.round(parseFloat(defaultfa)) < Math.round(parseFloat(fa))) {
        ot = parseFloat(ot) + (parseFloat(fa) - parseFloat(defaultfa));
        fa = defaultfa;
    }
    if (Math.round(parseFloat(defaultoa)) < Math.round(parseFloat(oa))) {
        ot = parseFloat(ot) + (parseFloat(oa) - parseFloat(defaultoa));
        oa = defaultoa;
    }
    $('#ot').val(ot);
    $('#basicda').val(basicda);
    $('#hra').val(hra);
    $('#ta').val(ta);
    $('#fa').val(fa);
    $('#oa').val(oa);
    var gross = Math.round(Math.round(parseFloat(basicda)) + Math.round(parseFloat(hra)) + Math.round(parseFloat(ta)) + Math.round(parseFloat(fa)) + Math.round(parseFloat(oa)) + Math.round(parseFloat(ot)));
    var elamount = Math.round((presentday / 20) * gross / totalworkingdays);
    //    alert(presentday+" -- "+gross);
    var pf = 0;
    if (defaultgross < 50000) {
        if ((basicda + elamount) > 15000) {
            pf = Math.round(parseFloat(1800));
        } else {
            pf = Math.round((parseFloat(basicda) + parseFloat(elamount)) * 12 / 100);
        }
    }
    $('#pf').val(pf);
    var pt = 0;
    var month = $("#month").val();
    if (defaultgross >= 15000) {
        if (month == 3) {
            pt = Math.round(parseFloat(212));
        } else {
            pt = Math.round(parseFloat(208));
        }
    }
    $('#pt').val(pt);
    var esic = 0;
    if (defaultgross <= 21000) {
        esic = Math.round((parseFloat(gross) + parseFloat(elamount) + parseFloat(bonus)) * 1.75 / 100);
    }
    $('#esic').val(esic);
    var tds = $('#tds').val();
    var personaladvance = parseFloat($('#personaladvance').val());
    var mobileallowence = $("#mobileallowence").val();
    var totalamount = Math.round(Math.round(elamount) + Math.round(bonus) + Math.round(parseFloat(gross)) - Math.round(parseFloat(pf)) - Math.round(parseFloat(pt)) - Math.round(parseFloat(esic)) - Math.round(parseFloat(personaladvance)) - Math.round(parseFloat(tds)) - Math.round(parseFloat(od)) - Math.round(parseFloat(mobileallowence)));
    $('#totalamount').val(totalamount);
    $('#bonus').val(bonus);
    $('#elamount').val(elamount);
}
function select2selectall(id) {
    $("select#" + id).select2('destroy');
    $("select#" + id + " option").prop('selected', 'selected').end();
    $("select#" + id).select2();
}
function select2deselectall(id) {
    $("select#" + id).select2('destroy');
    $("select#" + id + " option").prop('selected', false).end();
    $("select#" + id).select2();
}
// Closure
(function () {
    /**
     * Decimal adjustment of a number.
     *
     * @param {String}  type  The type of adjustment.
     * @param {Number}  value The number.
     * @param {Integer} exp   The exponent (the 10 logarithm of the adjustment base).
     * @returns {Number} The adjusted value.
     */
    function decimalAdjust(type, value, exp) {
        // If the exp is undefined or zero...
        if (typeof exp === 'undefined' || +exp === 0) {
            return Math[type](value);
        }
        value = +value;
        exp = +exp;
        // If the value is not a number or the exp is not an integer...
        if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
            return NaN;
        }
        // Shift
        value = value.toString().split('e');
        value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
        // Shift back
        value = value.toString().split('e');
        return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
    }
    // Decimal round
    if (!Math.round10) {
        Math.round10 = function (value, exp) {
            return decimalAdjust('round', value, exp);
        };
    }
    // Decimal floor
    if (!Math.floor10) {
        Math.floor10 = function (value, exp) {
            return decimalAdjust('floor', value, exp);
        };
    }
    // Decimal ceil
    if (!Math.ceil10) {
        Math.ceil10 = function (value, exp) {
            return decimalAdjust('ceil', value, exp);
        };
    }
})();
function electricaltophysical(x1, x2, y1, y2, lc, id, value) {
    var z2 = (((Number(x2) - Number(x1)) / (Number(y2) - Number(y1))) * (Number(value) - Number(y1))) + Number(x1);
    var tempre = Number(roundof(z2, lc)).toFixed(lc);
    $("#" + id).val(tempre);
}
function physicaltoelectrical(x1, x2, y1, y2, lc, id, value) {
    var z2 = (((parseFloat(y2) - parseFloat(y1)) / (parseFloat(x2) - parseFloat(x1))) * (parseFloat(value) - parseFloat(x1))) + parseFloat(y1);
    var tempre = Number(roundof(z2, lc)).toFixed(lc);
    $("#" + id).val(tempre);
}
function roundof(value, decimals) {
    //alert(value);
    // var newnumber = Math.round(value * Math.pow(10, decimals)) / Math.pow(10, decimals);
    //return parseFloat(newnumber);
    //return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
    if (decimals === undefined) {
        decimals = 0;
    }
    var multiplicator = Math.pow(10, decimals);
    value = parseFloat((value * multiplicator).toFixed(11));
    var test = (Math.round(value) / multiplicator);
    return +(test.toFixed(decimals));
}
function dynamicmodal(tid, target, what, heading) {
    var overlay = jQuery('<div id="overlay"> </div>');
    overlay.appendTo(document.body);
    $("#modalheading").html(heading);
    $.get(target, { hakuna: tid, what: what }, function (data) {
        $("#overlay").remove();
        $("#modaldata").html(data);
        $('#myModal').modal({ show: true, backdrop: 'static' });
    });
}
function abssubstractminus(from, to, resultid, lc) {
    var from1 = Number($("#" + from).val());
    var to1 = Number($("#" + to).val());
    var SIGDIG = 100000000;
    var reult = Math.floor((from1 - to1) * SIGDIG) / SIGDIG;
    if (lc == "NA") {
        var tempval = $("#" + from).val();
        var ndI = tempval.indexOf(".");
        if (ndI < 0) {
            var lc = 0;
        } else {
            var lc = tempval.length - ndI - 1;
        }
        var mlc = 0;
        var tempmval = $("#" + to).val();
        var mdI = tempmval.indexOf(".");
        if (mdI < 0) {
            mlc = 0;
        } else {
            mlc = tempmval.length - mdI - 1;
        }
        console.log("mlc=" + mlc);
        console.log("lc=" + lc);
        if (mlc > lc) {
            lc = mlc;
        }
        console.log("finallc" + lc);
    }
    if (lc != "NA") {
        reult = Number((reult)).toFixed(lc);
    }
    reult = Math.abs(reult);
    $("#" + resultid).val(reult);
    $("#" + resultid).focusout();
}
function substractminus(from, to, resultid, lc) {
    console.log(to);
    var from1 = Number($("#" + from).val());
    var to1 = Number($("#" + to).val());
    var SIGDIG = 100000000;
    var reult = Math.floor((from1 - to1) * SIGDIG) / SIGDIG;
    console.log(from1 + "-" + to1 + "=" + reult);
    if (lc == "NA") {
        var tempval = $("#" + from).val();
        var ndI = tempval.indexOf(".");
        if (ndI < 0) {
            lc = 0;
        } else {
            lc = tempval.length - ndI - 1;
        }
        var mlc = 0;
        var tempmval = $("#" + to).val();
        var mdI = tempmval.indexOf(".");
        if (mdI < 0) {
            mlc = 0;
        } else {
            mlc = tempmval.length - mdI - 1;
        }
        console.log("mlc=" + mlc);
        console.log("lc=" + lc);
        if (mlc > lc) {
            lc = mlc;
        }
        console.log("finallc" + lc);
    }
    if (lc != "NA") {
        reult = Number((reult)).toFixed(lc);
    }
    $("#" + resultid).val(reult);
    $("#" + resultid).focusout();
}
function substractminusnibp(from, to, resultid, lc) {
    console.log(to);
    var from1 = $("#" + from).val();
    var to1 = $("#" + to).val();
    var fe2 = from1.split("/");
    var f1 = fe2[0];
    var f2 = fe2[1];
    f1 = Number(f1);
    f2 = Number(f2);
    var te2 = to1.split("/");
    var t1 = te2[0];
    var t2 = te2[1];
    t1 = Number(t1);
    t2 = Number(t2);
    var reult1 = (f1 - t1);
    var reult2 = (f2 - t2);
    $("#" + resultid).val(reult1 + "/" + reult2);
    $("#" + resultid).focusout();
}
function percenterror(valueid, refpointid, resultid, lc) {
    var refpoint = $("#" + refpointid).val();
    var value = $("#" + valueid).val();
    var result = (value / refpoint) * 100;
    if (lc != "NA") {
        result = result.toFixed(lc);
    }
    $("#" + resultid).val(result);
    $("#" + resultid).focusout();
}
function converthardness(value, masterid, masterunit, resultid, lc) {
    var mastervalue = $("#" + masterid).val();
    var masterunitparameter = 10;
    if (masterunit == 96) {
        var masterunitparameter = 10;
    } else if (masterunit == 97) {
        var masterunitparameter = 30;
    } else if (masterunit == 131) {
        var masterunitparameter = 5;
    } else if (masterunit == 132) {
        var masterunitparameter = 20;
    } else if (masterunit == 133) {
        var masterunitparameter = 50;
    }
    var result = 1.854 * masterunitparameter / (value * value);
    if (lc != "NA") {
        result = result.toFixed(lc);
    }
    $("#" + resultid).val(result);
    $("#" + resultid).focusout();
}
function convertBrinellhardness(refvalue, diaofball, value, resultid) {
    refvalue = parseFloat(refvalue);
    diaofball = parseFloat(diaofball);
    value = parseFloat(value);
    var result = refvalue / ((1.571 * diaofball) * (diaofball - (Math.sqrt((diaofball * diaofball) - (value * value)))));
    result = result.toFixed(1);
    $("#" + resultid).val(result);
    $("#" + resultid).focusout();
}
function repeatability(field, refpointid, resultid, lc) {
    var refpoint = $("#" + refpointid).val();
    var fields = field.split(",");
    var total = 0;
    var value = new Array();
    for (var i = 0; i < fields.length; i++) {
        var from1 = Number($("#" + fields[i]).val());
        console.log("#" + fields[i] + " = " + from1);
        if (lc != "NA") {
            from1 = from1.toFixed(lc);
        }
        from1 = Number(from1);
        value[i] = parseFloat(from1);
        total = total + from1;
        total = Number(total);
        if (lc != "NA") {
            total = total.toFixed(Number(lc));
        }
        total = Number(total);
    }
    console.log("values=" + value);
    var max = Math.max.apply(Math, value);
    console.log("max=" + max);
    var min = Math.min.apply(Math, value);
    console.log("min=" + min);
    var repeatability = ((max - min) / refpoint) * 100;
    if (repeatability == "NaN") {
        repeatability = "-";
    }
    if (lc != "NA") {
        repeatability = repeatability.toFixed(Number(lc));
    }
    if (repeatability == "NaN") {
        repeatability = "-";
    }
    $("#" + resultid).val(repeatability);
    $("#" + resultid).focusout();
}
function substractminuscustom(from, to, resultid, lc) {
    var from1 = Number($("#" + from).val());
    var to1 = Number($("#" + to).val());
    var SIGDIG = 100000000;
    var reult = Math.floor((from1 - to1) * SIGDIG) / SIGDIG;
    if (lc == "NA") {
        var tempval = $("#" + from).val();
        var ndI = tempval.indexOf(".");
        lc1 = 0;
        if (ndI < 0) {
            var lc1 = 0;
        } else {
            var lc1 = tempval.length - ndI - 1;
        }
        var tempval1 = $("#" + to).val();
        var ddI = tempval1.indexOf(".");
        lc2 = 0;
        if (ddI < 0) {
            var lc2 = 0;
        } else {
            var lc2 = tempval1.length - ddI - 1;
        }
        lc = lc1 + lc2;
    }
    if (lc != "NA") {
        reult = Number((reult)).toFixed(lc);
    }
    $("#" + resultid).val(reult);
    $("#" + resultid).focusout();
}
function substractminusdirect(from, to, resultid, lc) {
    var from1 = from;
    var to1 = to;
    var SIGDIG = 100000000;
    var reult = Math.floor((from1 - to1) * SIGDIG) / SIGDIG;
    if (lc == "NA") {
        var tempval = $("#" + from).val();
        var ndI = tempval.indexOf(".");
        if (ndI < 0) {
            var lc = 0;
        } else {
            var lc = tempval.length - ndI - 1;
        }
    }
    if (lc != "NA") {
        reult = Number((reult)).toFixed(lc);
    }
    $("#" + resultid).val(reult);
    $("#" + resultid).focusout();
}
function multiply(field, resultid, lc) {
    var fields = field.split(",");
    var total = 1;
    for (var i = 0; i < fields.length; i++) {
        var from1 = Number($("#" + fields[i]).val());
        from1 = Number(from1);
        console.log("from1: " + from1);
        total = from1 * total;
    }
    if (lc == "NA") {
        var tempval = $("#" + fields[0]).val();
        var ndI = tempval.indexOf(".");
        if (ndI < 0) {
            lc = 0;
        } else {
            var lc = tempval.length - ndI - 1;
        }
    }
    console.log("from1: " + total);
    if (lc != "NA") {
        total = Number((total)).toFixed(lc);
    }
    $("#" + resultid).val(total);
    $("#" + resultid).change();
    $("#" + resultid).focusout();
}
function averageavg(field, resultid, lc) {
    var fields = field.split(",");
    var total = 0;
    for (var i = 0; i < fields.length; i++) {
        var from1 = Number($("#" + fields[i]).val());
        console.log("#" + fields[i] + " = " + from1);
        if (lc != "NA") {
            from1 = from1.toFixed(lc);
        }
        from1 = Number(from1);
        total = total + from1;
        total = Number(total);
        if (lc != "NA") {
            total = total.toFixed(Number(lc));
        }
        total = Number(total);
    }
    if (lc == "NA") {
        var tempval = $("#" + fields[0]).val();
        var ndI = tempval.indexOf(".");
        if (ndI < 0) {
            lc = 0;
        } else {
            var lc = tempval.length - ndI - 1;
        }
    }
    var reult = Number(total) / Number(fields.length);
    if (lc != "NA") {
        lc = Number(lc);
        //            reult=reult.toFixed(lc);
        reult = Number(roundof(reult, lc)).toFixed(lc);
    }
    $("#" + resultid).val(reult);
    $("#" + resultid).change();
    $("#" + resultid).focusout();
}
function averageavgnibp(field, resultid, lc) {
    var fields = field.split(",");
    var total1 = 0;
    var total2 = 0;
    for (var i = 0; i < fields.length; i++) {
        var te1 = $("#" + fields[i]).val();
        var te2 = te1.split("/");
        var f1 = te2[0];
        var f2 = te2[1];
        f1 = Number(f1);
        f2 = Number(f2);
        total1 = total1 + f1;
        total1 = Number(total1);
        total2 = total2 + f2;
        total2 = Number(total2);
    }
    var reult1 = Number(total1) / Number(fields.length);
    var reult2 = Number(total2) / Number(fields.length);
    reult1 = Number(roundof(reult1, 0));
    reult2 = Number(roundof(reult2, 0));
    $("#" + resultid).val(reult1 + "/" + reult2);
    $("#" + resultid).change();
    $("#" + resultid).focusout();
}
function inleastcount(n, d) {
    if (d == "NA") {
        return true;
    }
    //    alert(typeof(d));
    d = d.toString();
    //   alert(typeof(n));
    var ndI = n.indexOf("."); //Index of the Number's Dot
    var ddI = d.indexOf("."); // Index of the Divisors Dot
    //    alert(ndI+"===="+ddI+"====="+n+"====="+d);
    if (ndI > 0 && ddI > 0) { // IF its a float
        var len = n.length - ndI;
        var le = (d + ' ').replace('.', '').length;
        //        alert(parseFloat(d.lenght)+"ghjksk"+parseFloat(ddI));
        var len1 = parseFloat(le) - parseFloat(ddI);
        //         alert(len+"===="+len1+"====="+n+"====="+d);
        if (len == len1) {
            return true;
        } else {
            return false;
        }
        //        return !~((len % len1)); //Substract one of the modulo result, apply a bitwise NOT and cast a boolean.
    } else if (ndI > 0 || ddI > 0) {
        return false;
    } else {
        return true;
    }
}
function plusadd(from, to, resultid, lc) {
    var from1 = Number($("#" + from).val());
    var to1 = Number($("#" + to).val());
    var reult = from1 + to1;
    console.log("from=" + from1);
    console.log("to=" + to1);
    console.log("reult=" + reult);
    if (lc != "NA") {
        reult = Number(roundof(reult, lc)).toFixed(lc);
    }
    $("#" + resultid).val(reult);
    $("#" + resultid).focusout();
}
function divisiblebyid(n, did) {
    var d = $("#" + did).val();
    if (d == "NA") {
        return true;
    }
    var ndI = 1 + "".indexOf.call(n, "."); //Index of the Number's Dot
    var ddI = 1 + "".indexOf.call(d, "."); // Index of the Divisors Dot
    if (ndI || ddI) { // IF its a float
        //                    alert(ndI+" - - "+ddI);
        var l = Math.max(("" + n).length - ndI, ("" + d).length - ddI); //Longest Decimal Part
        var tmpN = (n * Math.pow(10, l)).toFixed(ndI * 3); //Get an Integer
        var tmpD = (d * Math.pow(10, l)).toFixed(ddI * 3);
        return !~((tmpN % tmpD) - 1); //Substract one of the modulo result, apply a bitwise NOT and cast a boolean.
    }
    return !~((n % d) - 1); // If it isnt a decimal
}
function divisibleby(n, d) {
    if (d == "NA") {
        return true;
    }
    var ndI = 1 + "".indexOf.call(n, "."); //Index of the Number's Dot
    var ddI = 1 + "".indexOf.call(d, "."); // Index of the Divisors Dot
    console.log(n + "--" + d);
    if (ndI || ddI) { // IF its a float
        var l = Math.max(("" + n).length - ndI, ("" + d).length - ddI); //Longest Decimal Part
        var tmpN = Math.round(n * Math.pow(10, l)); //Get an Integer
        var tmpD = Math.round(d * Math.pow(10, l));
        return ((tmpN % tmpD) == 0); //Substract one of the modulo result, apply a bitwise NOT and cast a boolean.
    }
    return !~((n % d) - 1); // If it isnt a decimal
}
function customfrequency(n) {
    if (n == "NA") {
        return true;
    } else if (n == "1 Month") {
        return true;
    } else if (n == "1 Year") {
        return true;
    } else if (n == "1 Day") {
        return true;
    } else if (n == "1 month") {
        return true;
    } else if (n == "1 year") {
        return true;
    } else if (n == "1 day") {
        return true;
    } else if (n.match("([2-9]|[1-5][0-9]) Months")) {
        return true;
    } else if (n.match("([2-9]|[1-5][0-9]) Years")) {
        return true;
    } else if (n.match("([2-9]|[1-5][0-9]) Days")) {
        return true;
    } else if (n.match("([2-9]|[1-5][0-9]) months")) {
        return true;
    } else if (n.match("([2-9]|[1-5][0-9]) years")) {
        return true;
    } else if (n.match("([2-9]|[1-5][0-9]) days")) {
        return true;
    } else {
        return false;
    }
}
function gap18year(n, did) {
    var d = $("#" + did).val();
    console.log("d=" + d);
    console.log("n=" + n);
    var date1 = parseDate(d, "dd/mm/yyyy");
    var date2 = parseDate(n, "dd/mm/yyyy");
    const diffInyear = Math.abs(date2 - date1);
    var diff = diffInyear / (1000 * 60 * 60 * 24 * 365);
    console.log(diff);
    if (diff < 18) {
        return false;
    }
    return true;
}
function checknumberorna(n) {
    if (n == "NA") {
        return true;
    } else if (isNaN(n)) {
        return false;
    } else {
        return true;
    }
}
function checkgst(g) {
    let regTest = /\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}/.test(g)
    if (regTest) {
        return true;
    }
    return false;
}
function checkpan(g) {
    let regTest = /[A-Z]{5}\d{4}[A-Z]{1}/.test(g)
    if (regTest) {
        return true;
    }
    return false;
}

function chkacceptqty(n, total, reject) {
    var t = parseInt($("#" + total).val());
    var a = parseInt($("#" + reject).val());
    n = parseInt(n);
    remain = t - a;
    total2 = n + a;
    if (n > remain) {
        return false;
    }
    if (n > t) {
        return false;
    }
    return true;
}

function chkrejectqty(n, total, accept) {
    var t = parseInt($("#" + total).val());
    var a = $("#" + accept).val();
    remain = parseInt(t) - parseInt(a);
    total2 = parseInt(n) + parseInt(a);
    if (n > remain) {
        return false;
    }
    if (n > t) {
        return false;
    }
    if (total2 != t) {
        return false;
    }
    return true;
}
$num = 1;
function myValidationAction($num) {
    if ($num > 0) {
        console.log($num);
        return true;
    }
    else {
        return false;
    }
}
function checknumber(n) {
    result = true;
    data = n.split(',');
    // console.log(data);
    for (let i in data) {
        if (data[i].length != 10 || isNaN(data[i])) {
            result = false;
        }
    }
    return result;
}


function gap18year(n) {
    // console.log("n=" + n);

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    d = dd + '/' + mm + '/' + yyyy;
    var date1 = parseDate(d, "dd/mm/yyyy");
    var date2 = parseDate(n, "dd/mm/yyyy");
    const diffInyear = Math.abs(date2 - date1);
    var diff = diffInyear / (1000 * 60 * 60 * 24 * 365);
    console.log(diff);
    if (diff < 18) {
        return false;
    }
    return true;
}

function matchconfirmpassword(n, cp) {
    did = $('#' + cp).val()
    return n === did ? true : false
}

function redir(data, secdata, thirddata, name1, name2, name3, page, target) {
    console.log(target, data, secdata, thirddata, name1, name2, name3, page, 'dadasdasd')
    document.getElementById('redirect').innerHTML = '<form  target=' + target + ' style="display:none;" position="absolute" method="post" action=' + page + '><input id="redirbtn" type="submit" name=' + name1 + ' value=' + data + '><input id="redirbtn"  name=' + name2 + ' value=' + secdata + '><input id="redirbtn"  name=' + name3 + ' value=' + thirddata + '></form>';
    document.getElementById('redirbtn').click();
}