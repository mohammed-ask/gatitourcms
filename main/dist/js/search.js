
function search(tid, rid, target, what) {
    if ($("#overlay").length == 0) {
        addoverlay();
    }



    var url = target;
    var temp;
    var error = 0;
    var did = document.getElementById(tid).value;
//alert(did);
    url += "?hakuna" + "=" + did + "&what=" + what;
//alert(url);
    $.get(url, function (data) {
        removeoverlay();
        document.getElementById(rid).innerHTML = data;
        
        $('.dater').datepicker({
            autoclose: true
        });
        
$(function () {
    $("select.select2-hidden-accessible").select2('destroy');
            $("select").select2();
        });
    });

}

//function Search()
//{
//
//    if (xmlhttp.readyState < 4)
//    {
//        if ($("#overlay").length == 0) {
//
//            addoverlay();
//
//        }
//    }
//    if (xmlhttp.readyState == 4)
//    {
//
//        removeoverlay();
//        document.getElementById(resultid).innerHTML = xmlhttp.responseText;
//
//
//    }
//
//}

