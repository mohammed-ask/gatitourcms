var xmlhttp;
var resultid = '';
var newtarget = '';
var what = '';
var globalerror = 0;
function del(did, target, resulti, wha, process = "delete") {


    what = wha;
    resultid = resulti;
    xmlhttp = GetXmlHttpObject();
    if (xmlhttp == null) {
        alertify.message("Browser does not support HTTP Request");

        return;
    }
    var isit = confirm("Are you sure you want to " + process + "?");
    if (isit) {
        if (globalerror < 1) {

            var url = target;
            var temp;
            var error = 0;


            url += "?hakuna" + "=" + did + "&what=" + what;
            //alert(url);
            if (error == 0) {
                xmlhttp.onreadystatechange = Del;
                xmlhttp.open("GET", url, true);
                xmlhttp.send(null);
                Del();
            }




        }
    }
}
function fun1(did, target, resulti, wha, process = "process") {


    what = wha;
    resultid = resulti;
    xmlhttp = GetXmlHttpObject();
    if (xmlhttp == null) {
        alertify.message("Browser does not support HTTP Request");

        return;
    }
    var isit = confirm("Are you sure you want to " + process + "?");
    if (isit) {

        var overlay = jQuery('<div id="overlay"> </div>');
        overlay.appendTo(document.body);
        if (globalerror < 1) {

            var url = target;
            var temp;
            var error = 0;


            url += "?hakuna" + "=" + did + "&what=" + what;
            //alert(url);
            if (error == 0) {
                xmlhttp.onreadystatechange = Del;
                xmlhttp.open("GET", url, true);
                xmlhttp.send(null);
                Del();
            }




        }
    }
}

function Del() {

    if (xmlhttp.readyState < 4) {
        $("#overlay").show();
        // document.getElementById('overlay').innerHTML = "Processing Your Request..<br/><img src='images/jar-loading.gif' alt=''  />";

    }
    if (xmlhttp.readyState == 4) {
        var resultdata = xmlhttp.responseText;

        $('#' + resultid).html(resultdata).fadeIn(400);
        //dataTableInitiate();
        location.reload(true);
        $("#overlay").remove();
        $("#overlay").hide().delay(8000);
    }

}

function GetXmlHttpObject() {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        return new XMLHttpRequest();
    }
    if (window.ActiveXObject) {
        // code for IE6, IE5
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
