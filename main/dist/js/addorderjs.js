$(document).ready(function () {

    /*payment checkbox manage*/
    $('.add-payment').click(function () {
        $('.hli').toggleClass('hli');
        $(this).toggleClass('hli');
        var hi = $(this).attr('iditem');
        $("#select_meth").val(hi);
//                alert(hi);
    });

//    change status of pay button
    $('input:radio[name="order_type"]').change(
            function () {
                if ($(this).is(':checked') && $(this).val() == '0') {
                    //$("#place_order").prop('value', 'Save to Draft'); 
                    $("#place_order").text("Save to Draft");
                    $("#next61").show();
                } else
                {
                    $("#place_order").text("Place Order");
                    $("#next61").hide();
                    but_show();

                }
            });

//    Product auto comolete
    $("#product_name").autocomplete({
        source: 'searchp.php',
        change: function (event, ui) {
        },
        minLength: 2,
        select: function (event, ui) {
            $("#coupon_status").val("0");
            $("#coupon_value").val("0");
            $("#cashback_value").val("0");
            $("#coupon_code_hide").val("0");
            $("#coupon_code").val("");
            $("#addinfo_coupen").show();
            $("#result_coupon").hide();
            if (!$('#customer_name').val()) {
                $('#product_name').val('').removeClass('ui-autocomplete-loading');
                alert('Please Select Customer');
                $("#product_name").val("");
                $('#customer_name').focus();
                return false;
            }
            $.ajax({
                url: "get_batch.php?id=" + ui.item.id,
                type: "GET",
                success: function (data)
                {
                    //alert(data);
                    $('#batch_all').html(data);
                    var length_batch = $('#pro_batch > option').length;
                    var batch_idd = '';
                    //alert(length_batch);
                    if (length_batch < 2)
                    {
                        // $("#pro_batch").val($("#pro_batch option:eq(1)").val());
                        $("#pro_batch").val($("#pro_batch option:first").val());
                        batch_idd = $('#pro_batch').find(":selected").val();
                    } else
                    {
                        $('#myModal').modal('show');
                        $('.selectpicker').select2();
                        $("#pro_batch").change(function () {
                            batch_idd = $('#pro_batch').find(":selected").val();
                            $('#myModal').modal('hide');

                            var batch_exist = "#" + batch_idd + "_" + ui.item.id;

                            if ($('#red_' + ui.item.id + "_" + batch_idd).length && $(batch_exist).length) {
                                var quantity_id = "#quantity_" + ui.item.id + "_" + batch_idd;
                                var quan_x = $(quantity_id).val();
                                quan_x = Number(quan_x) + 1;
                                $(quantity_id).val(quan_x);
                                qty(quan_x, ui.item.id, batch_idd);
                                cal();
                            } else {
                                if(!batch_idd){
                                    batch_idd="";
                                }
                                $.post("product_autocmplt.php", {item: ui.item.id, batch_id: batch_idd, cust_id: $('#cust_id').val()}, function (data) {
                                    console.dir(ui);
                                    event.preventDefault();
                                    $("#addorder").bValidator();
                                    if ($('#addorder').data('bValidator').validate()) {
                                        $("#data_entry").append(data);

                                        $("#product_name").val("");
                                        cal();
                                    }
                                });
                            }
                        });
                    }
                    if (batch_idd != "")
                    {
                        if ($('#red_' + ui.item.id + "_" + batch_idd).length) {
                            var quantity_id = "#quantity_" + ui.item.id + "_" + batch_idd;
                            var quan_x = $(quantity_id).val();
                            quan_x = Number(quan_x) + 1;
                            $(quantity_id).val(quan_x);
                            qty(quan_x, ui.item.id, batch_idd);
                            $("#product_name").val("");
                        } else {
                            $.post("product_autocmplt.php", {item: ui.item.id, batch_id: batch_idd, cust_id: $('#cust_id').val()}, function (data) {
                                console.dir(ui);
                                event.preventDefault();
                                $("#addorder").bValidator();
                                if ($('#addorder').data('bValidator').validate()) {
                                    $("#data_entry").append(data);
                                    $("#product_name").val("");
                                    cal();
                                }
                            });
                        }
                    } else
                    {

                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
            return false;
        },
        minLength: 1
    })
            .autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
                .append("<a>" + item.name + " "  + "(" + item.barcode + ")</a>")
                .appendTo(ul);

    };


//                customer autocomplete

    $("#customer_name").autocomplete({
        //              selectFirst: true,
        source: 'customer.php',
        change: function (event, ui) {
            if (!ui.item) {
                this.value = '';
            }
        },
        minLength: 2,
        select: function (event, ui) {
            $("#coupon_value").val("0");
            $("#cashback_value").val("0");
            $("#coupon_code_hide").val("0");
            $("#coupon_code").val("");
            $("#addinfo_coupen").show();
            $("#result_coupon").hide();
            $('#cust_id').val(ui.item.id);
            $('#customer_name').val(ui.item.name);
            var appedTr = '<div class="pull-left m-left"><img src="img/user-name.svg"></div>';
            appedTr += '<div class="pull-left m-left"><span class="margin-top5 font18">' + ui.item.name + '</span><br/>' + ui.item.email + '<br/>Balance: <i class="fa fa-inr"></i>' + ui.item.amount + '</div>';
            if (ui.item.vip == 1) {
                appedTr += '<div class="batch"><img src="img/vip.svg"></div>';
            }
            appedTr += '<div class="edit"><a href="edit-customer.php?cid='+window.btoa(ui.item.id)+'"> <img src="img/edit.svg"></a></div>';
            $("#rel_id").html(appedTr);
            var appedTr1 = '<i class="fa fa-inr"></i>' + ui.item.credit_limit;
            appedTr1 += '<input name="credt_lm" type="hidden" id="credt_lm" value="' + ui.item.credit_limit + '">';
            $("#credit_lmt").html(appedTr1);

            $.post("due.php", {id: ui.item.id}, function (data) {
                if (data.indexOf("Error :") != -1) {
                    //alert('hi');
//                                document.getElementById("result_order").innerHTML = '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a>' + data + '</div>';

                    var appedTrs = '<div class="row red-bg white-text padd15"><div class="col-md-7">Due Amount:</div><div class="col-md-5 " id="due1"><i class="fa fa-inr"></i> 0</div></div><input name="due_tm" type="hidden" id="due_tm" value="0"><div class="margin"></div>';
//                                alert(appedTrs);
                    $("#ifdue").html(appedTrs);
                    cal();

                } else {
                    var mydata = JSON.parse(data);
                    var appedTr2 = '<div class="red-bg white-text padd15"><div class="row"><div class="col-md-7">Due Amount:</div><div class="col-md-5 " id="due1"><i class="fa fa-inr"></i> ' + mydata.price + '</div></div></div><input name="due_tm" type="hidden" id="due_tm" value="' + mydata.price + '"><div class="margin"></div>';
                    $("#ifdue").html(appedTr2);
                    cal();
                }

            });

            return false;
        },
        minLength: 1
    })

            .autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
                .append("<a>" + item.name + "<br>" + item.email + "<br>" + item.mobile + "</a>")
                .appendTo(ul);
    };
});

//get batch nos
function get_batch(id)
{
    var length_batch = '';
    $.ajax({
        url: "get_batch.php?id=" + id,
        type: "GET",
        success: function (data)
        {
            $('#batch_all').html(data);

            length_batch = $('#pro_batch > option').length;
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    return length_batch;
}
// calculate Amount

function cal() {
    var n = $("input[name^='subtotal']").length;
    var array = $("input[name^='subtotal']");
    var coupon = $("#coupon_value").val()
    var due = $("#due_tm").val();
    var discount = $("#discountint").val();
    var rs = '0';
    var rq = '0';
    for (var i = 0; i < n; i++)
    {
        card_value = array[i].value;
        rs = Number(rs) + Number(card_value);

        //        new_value=  quantity[i].value;
        //        rq = Number(rq) + Number(new_value) ;

        //         alert(card_value);
    }
    if (due == null || due == "") {
//                   alert('hello');
    } else {
//                     alert('hello1');
        // rs = Number(rs) + Number(due);
    }
    var appedTr = '<i class="fa fa-inr"></i>' + rs;
    var payments = 0;

    var pn = $("input[name^='method']").length;
    var paymentarray = $("input[name^='method']");
    for (var i = 0; i < pn; i++)
    {
        payment_value = paymentarray[i].value;
        payments = Number(payments) + Number(payment_value);


    }
    var alldiscount = rs - coupon - discount;
    $("#final").html(appedTr);
    $("#main_bal").val(rs);
    var appedTr1 = '<i class="fa fa-inr"></i>' + alldiscount;
    $("#finalt").html(appedTr1);
    var remain = alldiscount - payments;
    var appedTr2 = '<i class="fa fa-inr"></i>' + Math.abs(remain);
    if (remain < 0) {
        $("#changereturn").html("Return");
    } else {
        $("#changereturn").html("Due");
    }
    $("#amualt").html(appedTr2);

    //        $("#amualt").html(rq);

    $("#main_bal_discount").val(alldiscount);
    $("#rem_bal").val(remain);

    $("#addinfo").show();
    but_show();
}
//            remove item
function remove(id, batch_id) {
    $("#red_" + id + "_" + batch_id).remove();
    cal();
}
function remove_return_(id, batch_id)
{

    $("#red_" + id).remove();
    cal();
}

//delete payment

function del_pay(id) {
//                 alert(id);
    var new1 = $("#cash" + id).val();
    var main = $("#rem_bal").val();
    $("#cash-st" + id).remove();
    
    var newcum = Number(main) + Number(new1);
    $("#rem_bal").val(newcum);
    var appedTr = '<i class="fa fa-inr"></i>' + newcum;

    $("#amualt").html(appedTr);
    cal();
}

//            add payment
function add_pay() {


    var pay = $("#add_pay").val();
    var pay_detail = $("#add_pay_detail").val();
    var main = $("#rem_bal").val();
    var def = $("#defau").val();
    var method = $("#select_meth").val();
    var newcum = Number(main) - Number(pay);
    var wallet = 1;
    if (method == "Wallet" || method == "wallet" || method == "WALLET")
    {
        $.ajax({
            type: 'post',
            url: 'check_wallet.php',
            data: {
                amount: pay,
                cust_id: $('#cust_id').val(),
            },
            success: function (response) {
                if (response < 1)
                {
                    var error_res = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Oops!</strong> Insufficient Balance In Wallet</div>';

                    $('#result_deliveryboy').html(error_res);
                    $('html, body').animate({scrollTop: '0px'}, 0);
                    wallet = 11;
                } else
                {
                    wallet = 111;
                    if ((pay == null || pay == "") || (wallet == 11)) {
                        alert('Please fill pay amount');
                        $("#add_pay").val('');
                    } else if (method == null || method == "") {
                        alert('Please select any payment method');
                    } else {
                        var appedTr = '<div id="cash-st' + def + '">';
                        appedTr += '<div class="margin"></div> <div class="col-md-2 cut"><a onclick="del_pay(' + def + ');" class="red-text"> <i class="fa fa-times " aria-hidden="true"></i></a></div>';
                        appedTr += '<input name="method[]" type="hidden" id="cash' + def + '" value="' + pay + '">';
                        appedTr += '<input name="para_meth[]" type="hidden" id="para_meth' + def + '" value="' + method + '">';
                        appedTr += '<input name="pay_detail[]" type="hidden" id="pay_detail' + def + '" value="' + pay_detail + '">';
                        appedTr += '<div class="col-md-7">' + method + '</div>';
                        appedTr += '<div class="col-md-3"><i class="fa fa-inr"></i> ' + pay + '</div>';
                        appedTr += '<div class="clearfix "></div>';
                        appedTr += '</div>';
                        $("#cash_stage").append(appedTr);
                        var count = Number(def) + 1;
                        $("#def").val(count);
                        var appedTr1 = '<i class="fa fa-inr"></i>' + newcum;
                        $("#add_pay").val("");
                        $("#amualt").html(appedTr1);
                        $("#select_meth").val("");
                        $("#rem_bal").val(newcum);
                        var newdef = Number(def) + 1;
                        $("#defau").val(newdef);
                        cal();

                        wallet = 1;

                    }
                }

            }

        });
    } // end wallet check
    else {
        if ((pay == null || pay == "") || (wallet == 11)) {
            alert('Please fill pay amount');
            $("#add_pay").val('');
        } else if (method == null || method == "") {
            alert('Please select any payment method');
        } else {
            var appedTr = '<div id="cash-st' + def + '">';
            appedTr += '<div class="margin"></div> <div class="col-md-2 cut"><a onclick="del_pay(' + def + ');" class="red-text"> <i class="fa fa-times " aria-hidden="true"></i></a></div>';
            appedTr += '<input name="method[]" type="hidden" id="cash' + def + '" value="' + pay + '">';
            appedTr += '<input name="para_meth[]" type="hidden" id="para_meth' + def + '" value="' + method + '">';
             appedTr += '<input name="pay_detail[]" type="hidden" id="pay_detail' + def + '" value="' + pay_detail + '">';
                       
            appedTr += '<div class="col-md-7">' + method + '</div>';
            appedTr += '<div class="col-md-3"><i class="fa fa-inr"></i> ' + pay + '</div>';
            appedTr += '<div class="clearfix "></div>';
            appedTr += '</div>';
            $("#cash_stage").append(appedTr);
            var count = Number(def) + 1;
            $("#def").val(count);
            var appedTr1 = '<i class="fa fa-inr"></i>' + newcum;
            $("#add_pay").val("");
            $("#amualt").html(appedTr1);
            $("#select_meth").val("");
            $("#rem_bal").val(newcum);
            var newdef = Number(def) + 1;
            $("#defau").val(newdef);
            cal();

            wallet = 1;

        }
    }


}


//            check quantity
function qty(val, id, batch_id) {
    $("#coupon_status").val("0");
    $("#coupon_value").val("0");
    $("#cashback_value").val("0");
    $("#coupon_code_hide").val("0");
    $("#coupon_code").val("");
    $("#addinfo_coupen").show();
    $("#result_coupon").hide();
    if (val)
    {
        $.ajax({
            type: 'post',
            url: 'check_quantity.php',
            data: {
                pro_quantity: val,
                pro_batch: batch_id,
                pro_id: id
            },
            success: function (response) {
                if (response != 0)
                {
                    var error_res = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Oops!</strong> ' + response + '</div>';

                    $('#result_deliveryboy').html(error_res);

                    var quantity_change = "#quantity_" + id + "_" + batch_id;
                    $(quantity_change).val(1);

                    val = 1;

                    var n = $("input[name^='method']").length;
                    var array = $("input[name^='method']");
                    var due = $("#due_tm").val();
                    var rs = '0';
                    var rq = '0';
                    for (i = 0; i < n; i++)
                    {
                        card_value = array[i].value;
                        rs = Number(rs) + Number(card_value);

                        //        new_value=  quantity[i].value;
                        //        rq = Number(rq) + Number(new_value) ;

                        //         alert(card_value);
                    }

                    var cost = $("#pof_" + id + batch_id).val();
                    var price = (cost * val).toFixed(2);
                    var price2 = ((cost * val) - rs).toFixed(2);
                    var appedTr = '<i class="fa fa-inr"></i>' + price;



                    $("#subtot_" + id + batch_id).val(price2);
                    $("#qty_" + id + batch_id).val(val);
                    $("#subtotal_" + id + batch_id).html(appedTr);
                    $("#final").html(appedTr);
                    $("#finalt").html(appedTr);

                    cal();

                } else {
                    $('#result_deliveryboy').html("");
                    var n = $("input[name^='method']").length;
                    var array = $("input[name^='method']");
                    var due = $("#due_tm").val();
                    var rs = '0';
                    var rq = '0';
                    for (i = 0; i < n; i++)
                    {
                        card_value = array[i].value;
                        rs = Number(rs) + Number(card_value);

                        //        new_value=  quantity[i].value;
                        //        rq = Number(rq) + Number(new_value) ;

                        //         alert(card_value);
                    }

                    var cost = $("#pof_" + id + batch_id).val();
                    var price = (cost * val).toFixed(2);
                    var price2 = ((cost * val) - rs).toFixed(2);
                    var appedTr = '<i class="fa fa-inr"></i>' + price;




                    $("#subtot_" + id + batch_id).val(price2);
                    $("#qty_" + id + batch_id).val(val);
                    $("#subtotal_" + id + batch_id).html(appedTr);
                    $("#final").html(appedTr);
                    $("#finalt").html(appedTr);
                    cal();
                }




            }
        });
    }



// after ajax


}
//apply coupon
function add_coupon()
{

    var coupon_code = $("#coupon_code").val();
    var coupon_status = $("#coupon_status").val();
    var coupon_amount = $("#main_bal").val();
    var customer_id = $('#cust_id').val();
    var coupon_empty = '';
    if (coupon_code != '' && coupon_status != 1 && customer_id != "" && coupon_amount != 0 && coupon_amount != "")
    {
        $("#coupon_status").val(1);

        $.ajax({
            type: 'post',
            url: 'check_coupen.php',
            data: {
                coupon_code: coupon_code,
                amount: coupon_amount,
                cust_id: $('#cust_id').val(),
            },
            success: function (response) {

                try {
                    var str = jQuery.parseJSON(response);
                    var coupon_val = str.discount_amount;
                    var cashback_cpn = str.cash_amt;
                    var mainBal_coupon = Number($("#main_bal").val());
                    var mainBal_redeem = mainBal_coupon - coupon_val;
                    var mainBal_show = '<i class="fa fa-inr"></i>' + mainBal_redeem;
                    $("#finalt").html(mainBal_show);
                    $("#fianl").html(mainBal_show);
                    $("#amualt").html(mainBal_show);
                    $("#rem_bal").val(mainBal_redeem);
                    $("#main_bal").val(mainBal_redeem);
                    $("#coupon_value").val(coupon_val);
                    $("#coupon_code_hide").val(coupon_code);

                    if (cashback_cpn != 0)
                    {
                        coupon_empty = '<div id="solTitle" class="alert alert-success fade in"><a href="#coupen_close" id="coupon_close" class="close coupon_close" data-dismiss="alert">&times;</a> Congrats!! Coupon <strong> ' + coupon_code + ' </strong> worth amount <strong>' + coupon_val + '</strong> Applied successfully. Got cashback of <strong>' + cashback_cpn + '</strong></div>';

                        $("#cashback_value").val(cashback_cpn);

                    } else
                    {
                        coupon_empty = '<div id="solTitle" class="alert alert-success fade in"><a href="#coupen_close" id="coupon_close" class="close coupon_close" data-dismiss="alert">&times;</a> Congrats!! Coupon <strong> ' + coupon_code + ' </strong> worth amount <strong>' + coupon_val + '</strong> Applied successfully.</div>';
                    }
                    var coupon_empty2 = '<div id="solTitle" class="alert alert-success fade in"><a href="#coupen_close" id="coupon_close" class="close coupon_close" data-dismiss="alert">&times;</a> Coupon <strong> ' + coupon_code + ' </strong> worth amount <strong>' + coupon_val + '</strong><br>Got cashback of <strong>' + cashback_cpn + '</strong></div>';

                    $('#result_deliveryboy').html(coupon_empty);
                    $('#result_coupon').html(coupon_empty2);
                    $('html, body').animate({scrollTop: '0px'}, 0);

                    $("#addinfo_coupen").hide();
                    $("#result_coupon").show();
                    cal();

                } catch (e) {
                    coupon_empty = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Oops!</strong>' + response + '</div>';

                    $('#result_deliveryboy').html(coupon_empty);
                    $('html, body').animate({scrollTop: '0px'}, 0);
                }

            }

        });
    } else if (coupon_code == '')
    {
        coupon_empty = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Oops!</strong> Add coupon First</div>';

        $('#result_coupon').html(coupon_empty);

    } else
    {
        coupon_empty = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Oops!</strong> coupon Already Added</div>';

        $('#result_coupon').html(coupon_empty);

    }

}

function pr(val, id) {
    var dis = $("#pds_" + id).val();
    var qty = $("#qty_" + id).val();
    var price1 = (val - dis);
    var price = (val - dis) * qty;
    var appedTr = '<i class="fa fa-inr"></i>' + price;
    $("#subtot_" + id).val(price);
    $("#psl_" + id).val(val);
    $("#pof_" + id).val(price1);
    $("#subtotal_" + id).html(appedTr);
    cal();
    $("#cash_stage").empty();

}


function disr(val) {
    $("#coupon_status").val("0");
    $("#coupon_value").val("0");
    $("#cashback_value").val("0");
    $("#coupon_code_hide").val("0");
    $("#coupon_code").val("");
    $("#addinfo_coupen").show();
    $("#result_coupon").hide();
//               alert(val);
    var cost = $("#main_bal_discount").val();
    //    var rem = $("#rem_bal").val();
    var newcum = Number(cost) - Number(val);
    var appedTr1 = '<i class="fa fa-inr"></i>' + newcum;
    $("#amualt").html(appedTr1);
    $("#finalt").html(appedTr1);
    $("#rem_bal").val(newcum);
    $("#main_bal").val(newcum);
    $("#discnt").val(val);
    cal();
}
function disp(val) {
//               alert(val);
    var cost = $("#main_bal_discount").val();
    var rem = (cost * val) / 100;
//    alert(rem);
    var newcum = Number(cost) - Number(rem);
    var appedTr1 = '<i class="fa fa-inr"></i>' + newcum;
    $("#amualt").html(appedTr1);
    $("#finalt").html(appedTr1);
    $("#rem_bal").val(newcum);
    $("#main_bal").val(newcum);
    $("#discnt").val(rem);

}
function but_show() {
    var due = $("#due_tm").val();
    var main = $("#rem_bal").val();
    // alert(main);
    var totaldue = due + main;
    var crdit = $("#credt_lm").val();
    //alert(crdit);
    if (parseFloat(totaldue) <= parseFloat(crdit)) {
        $("#next61").show();
    } else {
        $("#next61").hide();
    }
}