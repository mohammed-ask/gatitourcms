<?php
include "function.php";
include "conn.php";
$rowvehicles = $obj->selectextrawhere("vehiclenames", "status = 1 and id!=9")
?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>GatiTour | Travel Agency Landing Page UI</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <!-- <link rel="apple-touch-icon" sizes="180x180" href="main/dist/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="main/dist/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="main/dist/assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="main/dist/assets/img/favicons/favicon.ico">
    <link rel="manifest" href="main/dist/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="main/dist/assets/img/favicons/mstile-150x150.png"> -->
    <meta name="theme-color" content="#ffffff">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="main/dist/assets/css/theme.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="main/plugins/jquery-ui/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="main/dist/css/jquery-ui-timepicker-addon.css">

</head>
<!-- <title>Donation Form</title> -->
<style>
    html,
    body {
        min-height: 100%;
    }

    body,
    div,
    form,
    input,
    select,
    textarea,
    label {
        padding: 0;
        margin: 0;
        outline: none;
        font-family: Roboto, Arial, sans-serif;
        font-size: 14px;
        color: #666;
        line-height: 22px;
    }

    legend {
        padding: 10px;
        font-family: Roboto, Arial, sans-serif;
        font-size: 18px;
        color: #fff;
        background-color: #1c87c9;
    }

    textarea {
        width: calc(100% - 12px);
        padding: 5px;
    }

    .testbox {
        display: flex;
        justify-content: center;
        align-items: center;
        height: inherit;
        padding: 20px;
    }

    form {
        width: 100%;
        padding: 20px;
        border-radius: 6px;
        background: #fff;
        box-shadow: 0 0 8px #006622;
    }

    input,
    select,
    textarea {
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    input {
        width: calc(100% - 10px);
        padding: 5px;
    }


    .item:hover p,
    .item:hover i,
    .question:hover p,
    .question label:hover,
    input:hover::placeholder {
        color: #006622;
    }

    .item input:hover,
    .item select:hover,
    .item textarea:hover {
        border: 1px solid transparent;
        box-shadow: 0 0 3px 0 #006622;
        color: #006622;
    }

    .item {
        position: relative;
        margin: 10px 0;
    }

    .item span {
        color: red;
    }


    .colums {
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .colums .item {
        width: 48%;
    }


    label.radio {
        position: relative;
        display: inline-block;
        margin: 5px 20px 15px 0;
        cursor: pointer;
    }


    label.radio:before {
        content: "";
        position: absolute;
        left: 0;
        width: 17px;
        height: 17px;
        border-radius: 50%;
        border: 2px solid #ccc;
    }

    input[type=radio]:checked+label:before,
    label.radio:hover:before {
        border: 2px solid #006622;
    }


    input[type=radio]:checked+label:after {
        opacity: 1;
    }

    button:hover {
        background: #0692e8;
    }
</style>
<style>
    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 900px;
            margin: 1.75rem auto;
        }
    }

    .d-inline-block {
        display: inline-block !important;
        width: 100px !important;
    }
</style>

<body>
    <form id="tbook">
        <div class="">
            <!-- <h1>Donation Form</h1> -->
            <img style="object-fit:cover;width:100%;height:300px" src='main/uploads/vehicle/bustravel.jpg' />
        </div>
        <br />
        <fieldset>
            <legend>Your Details</legend>
            <label for="fname">Select Tour Vehicle<span style="color:red">*</span></label>
            <div style="display:flex;flex-wrap:wrap;justify-content:space-between">
                <?php
                while ($rvehicle = $obj->fetch_assoc($rowvehicles)) { ?>
                    <div class="vtype" style="align-items: center;justify-content:center;text-align:center;cursor:pointer">
                        <input class="vcar" hidden type="text" value="<?= $rvehicle['id'] ?>">
                        <img src="<?= $rvehicle['path2'] ?>" style="width: 100px;height:100px;object-fit:contain" />
                        <h6 class="carhead"><?= $rvehicle['name'] ?></h6>
                    </div>
                <?php } ?>
            </div>
            <input type="text" data-bvalidator="required" id="vehicleid" value="" name="vehicleid" hidden />
            <div class="colums">

                <div class="item">
                    <label for="fname">First Name<span>*</span></label>
                    <input data-bvalidator="required" id="fname" type="text" name="fname" />
                </div>
                <div class="item">
                    <label for="lname"> Last Name<span>*</span></label>
                    <input data-bvalidator="required" id="lname" type="text" name="lname" />
                </div>
                <div class="item">
                    <label for="address">Email Address<span>*</span></label>
                    <input id="address" type="text" name="email" />
                </div>
                <div class="item">
                    <label for="mobileno">Phone Number</label>
                    <input data-bvalidator="required" id="mobileno" type="tel" name="mobileno" />
                </div>
                <div class="item">
                    <label for="tt" style="width: 100%;">Travel type</label>
                    <div class="form-check d-inline-block">
                        <input class="form-check-input" checked value="One way" type="radio" name="traveltype" id="exch1">
                        <label class="form-check-label" for="exch1">
                            One Way
                        </label>
                    </div>
                    <div class="form-check mb-2 d-inline-block ">
                        <input class="form-check-input" value="Round trip" type="radio" name="traveltype" id="exch2">
                        <label class="form-check-label" for="exch2">
                            Round Trip
                        </label>
                    </div>
                    <div class="form-check mb-2 d-inline-block">
                        <input class="form-check-input" value="Multi City" type="radio" name="traveltype" id="exch3">
                        <label class="form-check-label" for="exch2">
                            Multi Trip
                        </label>
                    </div>
                </div>

        </fieldset>
        <br />
        <fieldset>
            <legend>Travel Details</legend>
            <div class="colums">
                <div class="item">
                    <label for="from">Travel From<span>*</span></label>
                    <input data-bvalidator="required" data-bvalidator="required" id="from" type="text" name="from" />
                </div>
                <div class="item">
                    <label for="to">Travel To<span>*</span></label>
                    <input data-bvalidator="required" data-bvalidator="required" id="to" type="text" name="to" />
                </div>
                <div class="item">
                    <label for="pickupat">Pickup Date<span>*</span></label>
                    <input data-bvalidator="required" id="pickupat" onfocus="datetimepicker(this.id)" type="datetime" name="pickupat" />
                </div>
                <div class="item">
                    <label for="departureat">Departure Date</label>
                    <input data-bvalidator="required" data-bvalidator="required" onfocus="datetimepicker(this.id)" id="departureat" type="datetime" name="departureat" />
                </div>
            </div>

        </fieldset>

        <div id="resultid"></div>
    </form>
    </div>
    </div>
    <div class="modal-footer modal-footer-browser">
        <button type="button" onclick="window.location.href='index'" id="" class="btn btn-secondary browser-btn browser-btn-secondary cancal">Cancel</button>
        <button type="button" class="btn btn-primary browser-btn browser-btn-primary" onclick="event.preventDefault();sendForm('', '', 'insertticketbooking', 'resultid', 'tbook')">Proceed</button>
    </div>
    <div class="modal fade" id="customConfirmModal" tabindex="-1" role="dialog" aria-labelledby="customConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-broswer" role="document">
            <div class="modal-content browser-model-content">
                <div class="modal-body">
                    Are you sure you want to proceed?
                </div>
                <div class="modal-footer modal-footer-browser">
                    <button type="button" id="cancal" class="btn btn-secondary browser-btn browser-btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary browser-btn browser-btn-primary" onclick="handleCustomConfirm(true)">Proceed</button>
                </div>
            </div>
        </div>
    </div>
    <script src="main/plugins/jquery/jquery.min.js"></script>
    <script src="main/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="main/dist/js/customfunction.js"></script>
    <script src="main/dist/js/jquery.bvalidator-yc.js"></script>

    <!-- <script src="main/plugins/moment/moment.min.js"></script>
  <script src="main/plugins/daterangepicker/daterangepicker.js"></script>
  <script src="main/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->
    <script src="main/dist/js/jquery-ui-timepicker-addon.js"></script>

    <script src="main/dist/vendors/@popperjs/popper.min.js"></script>
    <script src="main/dist/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="main/dist/vendors/is/is.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="main/dist/vendors/fontawesome/all.min.js"></script>
    <script src="main/dist/assets/js/theme.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Volkhov:wght@700&amp;display=swap" rel="stylesheet">

</body>

</html>
<script>
    $(document).ready(function() {
        $('#showModalBtn').click(function() {
            $('#driverForm').modal('show');
        });
        $('#showModalBtn2').click(function() {
            $('#ticketBookingForm').modal('show');
        });
        $(".cancal").click(function() {
            $('#driverForm').modal('hide');
            $('#ticketBookingForm').modal('hide');
        })

        $(".vtype").click(function() {
            var a = $(this).find("input").val()
            // var t = $("#vehicleid").val()
            var t = $("#vehicleid").val(a)
            $(".vtype").css("background-color", "transparent")
            $(this).css({
                "background-color": "#1c87c9",
                "color": "white",
                "font-size": "16px",
                "border-radius": "10px"
            })
            $(".carhead").css("color", "black")
            $(this).find(".carhead").css("color", "white")
            // alert(t);
        });
    });
</script>