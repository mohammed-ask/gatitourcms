var xmlhttp;
var resultid = '';
var what1;
function view(did, rid, target, what) {
    addoverlay();
    var url = "?hakuna" + "=" + did + "&what=" + what;
    $.get(target + url, function (data) {

        if (data.indexOf("Redirect :") != -1) {

            var rs = data.replace('Redirect :', 'Success :');
            var res = rs.split('URL')
            var url = res[1];
            rid.innerHTML = '<div class="alert alert-success">' + res[0] + '</div>';
            window.location.href = url;
        }
        else if (data.indexOf("Reload :") != -1) {

            rid.innerHTML = "Successful";
            var rs = data.replace('Reload :');


            setTimeout(location.reload(), 3000);

        }
        else {

            $("#" + rid).html(data);
            $("#" + rid).show();
            $(':text').focus(function () {
                current = this;
            });
            $('textarea').focus(function () {
                current = this;
            });

        }
        $("select").select2();
        removeoverlay();

        dataTableInitiate();

    });
}
function view2(did, rid, target, what,batch) {
    addoverlay();
    var url = "?hakuna" + "=" + did + "&what=" + what+"&batch="+batch;
    $.get(target + url, function (data) {

        if (data.indexOf("Redirect :") != -1) {

            var rs = data.replace('Redirect :', 'Success :');
            var res = rs.split('URL')
            var url = res[1];
            rid.innerHTML = '<div class="alert alert-success">' + res[0] + '</div>';
            window.location.href = url;
        }
        else if (data.indexOf("Reload :") != -1) {

            rid.innerHTML = "Successful";
            var rs = data.replace('Reload :');


            setTimeout(location.reload(), 3000);

        }
        else {

            $("#" + rid).html(data);
            $("#" + rid).show();
            $(':text').focus(function () {
                current = this;
            });
            $('textarea').focus(function () {
                current = this;
            });

        }
        $("select").select2();
        removeoverlay();

        dataTableInitiate();

    });
}