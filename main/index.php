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

  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main" id="top">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top pl-2 pt-4 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
      <div class="container"><a class="navbar-brand" href="index.html"><img src="main/dist/assets/img/Gatitour(Dark).png" height="50" alt="logo" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"> </span></button>
        <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base align-items-lg-center align-items-start">

            <li class="nav-item px-3 px-xl-4"><a class="nav-link fw-medium" aria-current="page" href="#downloadapp">Download App</a></li>

            <li class="nav-item px-3 px-xl-4"><a class="btn btn-outline-dark order-1 order-lg-0 fw-medium" href="login">Admin Login</a></li>

          </ul>
        </div>
      </div>
    </nav>
    <section style="padding-top: 7rem;">
      <div class="bg-holder" style="background-image:url(main/dist/assets/img/hero/hero-bg.svg);">
      </div>
      <!--/.bg-holder-->

      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-5 col-lg-6 order-0 order-md-1 text-end"><img class="pt-7 pt-md-0 hero-img" src="main/dist/assets/img/hero/hero-img.png" alt="hero-header" /></div>
          <div class="col-md-7 col-lg-6 text-md-start text-center py-6">
            <h4 class="fw-bold text-danger mb-3">Best Destinations around the India</h4>
            <h1 class="hero-title">Travel, enjoy and live a new and full life</h1>
            <p class="mb-4 fw-medium">At Gatitour, we're dedicated to transforming your travel experiences into unforgettable adventures.<br class="d-none d-xl-block" /> Explore the world with confidence and convenience with Gatitour by your side.</p>
            <div class="text-center text-md-start">
              <a class="btn btn-primary btn-lg " href="main\dist\download-app\gatitour.apk" download="GatiTour" role="button">Download App</a>
              <a class="btn btn-info btn-lg " href="#" role="button" id="showModalBtn">Driver Registration</a>
              <a class="btn btn-danger btn-lg " href="#" role="button" id="showModalBtn2">Book Ticket</a>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="pt-5 pt-md-9" id="service">

      <div class="container">
        <div class="position-absolute z-index--1 end-0 d-none d-lg-block"><img src="main/dist/assets/img/category/shape.svg" style="max-width: 200px" alt="service" /></div>
        <div class="mb-7 text-center">
          <h5 class="text-secondary">CATEGORY </h5>
          <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">Why Choose Gatitour? </h3>
        </div>
        <div class="row">
          <div class="col-lg-6 col-sm-12 mb-6">
            <div class="card service-card shadow-hover rounded-3 text-center align-items-center">
              <div class="card-body p-xxl-5 p-4"> <img src="main/dist/assets/img/category/icon1.png" width="150" alt="Service" />
                <h4 class="mb-3">Extensive Vehicle Fleet</h4>
                <p class="mb-0 fw-medium">Choose from our selection of: Hatchback Cars,
                  Sedan Cars,
                  SUV Cars,
                  Tata Wingers,
                  Maxx Toofans
                  Tempo Travellers,
                  Buses,</p>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-sm-12 mb-6">
            <div class="card service-card shadow-hover rounded-3 text-center align-items-center">
              <div class="card-body p-xxl-5 p-4"> <img src="main/dist/assets/img/category/icon2.png" width="75" alt="Service" />
                <h4 class="mb-3">Convenient Booking</h4>
                <p class="mb-0 fw-medium">Download our user-friendly app to:
                  Vehicle options,
                  Make bookings on the go,
                  instant confirmation,
                  24/7 customer support</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div><!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="pt-5" id="destination">

      <div class="container">
        <div class="position-absolute start-100 bottom-0 translate-middle-x d-none d-xl-block ms-xl-n4"><img src="main/dist/assets/img/dest/shape.svg" alt="destination" /></div>
        <div class="mb-7 text-center">

          <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">Top Destinations</h3>
        </div>
        <div class="row">
          <div class="col-md-4 mb-4">
            <div class="card overflow-hidden shadow"> <img class="card-img-top" src="main/dist/assets/img/dest/dest1.jpg" alt="Rome, Italty" />

            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card overflow-hidden shadow"> <img class="card-img-top" src="main/dist/assets/img/dest/dest2.jpg" alt="London, UK" />
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card overflow-hidden shadow"> <img class="card-img-top" src="main/dist/assets/img/dest/dest3.jpg" alt="Full Europe" />

            </div>
          </div>
        </div>
      </div><!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section id="booking">

      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="mb-4 text-start">
              <h5 class="text-secondary">Easy and Fast </h5>
              <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">Book your next trip in 3 easy steps</h3>
            </div>
            <div class="d-flex align-items-start mb-5">
              <div class="bg-primary me-sm-4 me-3 p-3" style="border-radius: 13px"> <img src="main/dist/assets/img/steps/selection.svg" width="22" alt="steps" /></div>
              <div class="flex-1">
                <h5 class="text-secondary fw-bold fs-0">Download GatiTour App</h5>
                <p>Download our GatiTour App, <br class="d-none d-sm-block"> and explore the App</p>
              </div>
            </div>
            <div class="d-flex align-items-start mb-5">
              <div class="bg-danger me-sm-4 me-3 p-3" style="border-radius: 13px"> <img src="main/dist/assets/img/steps/water-sport.svg" width="22" alt="steps" /></div>
              <div class="flex-1">
                <h5 class="text-secondary fw-bold fs-0">Choose Destination</h5>
                <p>Choose your favourite place. No matter <br class="d-none d-sm-block"> where you travel inside in India.</p>
              </div>
            </div>
            <div class="d-flex align-items-start mb-5">
              <div class="bg-info me-sm-4 me-3 p-3" style="border-radius: 13px"> <img src="main/dist/assets/img/steps/taxi.svg" width="22" alt="steps" /></div>
              <div class="flex-1">
                <h5 class="text-secondary fw-bold fs-0">Get Confirm Booking</h5>
                <p>Lastly, you will get confirm booking <br class="d-none d-sm-block"> and enjoy the vacation.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-6 d-flex justify-content-center align-items-start">
            <div class="card position-relative shadow" style="max-width: 370px;">
              <div class="position-absolute z-index--1 me-10 me-xxl-0" style="right:-160px;top:-210px;"> <img src="main/dist/assets/img/steps/bg.png" style="max-width:550px;" alt="shape" /></div>
              <div class="card-body p-3"> <img class="mb-0 mt-0 rounded-2 w-100" src="main/dist/assets/img/steps/booking-img.jpg" alt="booking" />
                <div>

                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      </div><!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->





    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section id="downloadapp" class="pt-6">

      <div class="container">
        <div class="py-8 px-5 position-relative text-center" style="background-color: rgba(223, 215, 249, 0.199);border-radius: 129px 20px 20px 20px;">
          <div class="position-absolute start-100 top-0 translate-middle ms-md-n3 ms-n4 mt-3"> <img src="main/dist/assets/img/cta/send.png" style="max-width:70px;" alt="send icon" /></div>
          <div class="position-absolute end-0 top-0 z-index--1"> <img src="main/dist/assets/img/cta/shape-bg2.png" width="264" alt="cta shape" /></div>
          <div class="position-absolute start-0 bottom-0 ms-3 z-index--1 d-none d-sm-block"> <img src="main/dist/assets/img/cta/shape-bg1.png" style="max-width: 340px;" alt="cta shape" /></div>
          <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
              <h2 class="text-secondary lh-1-7 mb-7">Download Gati Tour App</h2>

              <div class="col-sm-auto">
                <button class="btn btn-danger orange-gradient-btn fs--1"><a href="main\dist\download-app\gatitour.apk" download="GatiTour">Click to Download App</a></button>
              </div>

            </div>
          </div>
        </div>
      </div><!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->





    <div class="py-5 text-center">
      <p class="mb-0 text-secondary fs--1 fw-medium">All rights reserved@gatitour.in </p>
    </div>
    <div class="modal fade" id="driverForm" tabindex="-1" role="dialog" aria-labelledby="driverFormLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-broswer" role="document">
        <div class="modal-content browser-model-content">
          <div class="modal-body">
            <form style="overflow-x: hidden;" id="adduser">
              <label class="block text-sm" style="margin-bottom: 5px;">
                <span class="text-gray-700 dark:text-gray-400">Name</span>
                <input name="name" data-bvalidator="required" class="form-control" placeholder="Driver's Name" />
              </label>
              <!-- <label class="block text-sm" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Email</span>
        <input name="email" data-bvalidator="required,email" class="form-control" placeholder="Driver's Email ID" />
    </label> -->
              <div class="row">
                <label class="col-6 block text-sm" style="margin-bottom: 5px;">
                  <span class="text-gray-700 dark:text-gray-400">Mob No.</span>
                  <input data-bvalidator="required,digit,minlength[10],maxlength[10]" name="mobile" class="form-control" placeholder="Driver's Mobile No." />
                </label>
                <label class="col-6 block text-sm" style="margin-bottom: 5px;">
                  <span class="text-gray-700 dark:text-gray-400">Whataspp No.</span>
                  <input data-bvalidator="required,digit,minlength[10],maxlength[10]" name="whatsappno" class="form-control" placeholder="Driver's Whatsapp No." />
                </label>
              </div>
              <div class="row">
                <label class="col-6 block text-sm" style="margin-bottom: 5px;">
                  <span class="text-gray-700 dark:text-gray-400">Aadhar No.</span>
                  <input data-bvalidator="required" name="adharno" class="form-control" placeholder="Enter Aadhar No." /></label>
                <label class="col-6 block text-sm" style="margin-bottom: 5px;">
                  <span class="text-gray-700 dark:text-gray-400">License No.</span>
                  <input data-bvalidator="required" name="drivinglicense" class="form-control" placeholder="" /></label>
              </div>
              <div class="row">
                <label class="col-6 block text-sm" style="margin-bottom: 5px;">
                  <span class="text-gray-700 dark:text-gray-400">License Expiry Date</span>
                  <input data-bvalidator="required" onfocus="setcalendernolimit(this.id,'')" name="licenseexpiry" class="form-control" placeholder="" id="date" /></label>
              </div>
              <div class="row">
                <!-- <label class="col-6 block text-sm" style="margin-bottom: 5px;">
                  <span class="text-gray-700 dark:text-gray-400">Password</span>
                  <input type="password" data-bvalidator="required,maxlength[8],minlength[4]" id="password" name="password" class="form-control" placeholder="Enter Password!" />
                  <i id="eye" class="fa fa-eye" style="position: absolute;top:34px;right:18px;z-index:50" aria-hidden="true"></i>
                </label> -->
                <label class="col-6 block text-sm" style="margin-bottom: 5px;">
                  <span class="text-gray-700 dark:text-gray-400">City</span>
                  <input type="text" data-bvalidator="required" id="city" name="city" class="form-control" placeholder="Enter City!" />
                  <i id="eye" class="fa fa-eye" style="position: absolute;top:34px;right:18px;z-index:50" aria-hidden="true"></i>
                </label>

              </div>

              <div class="row mt-3">
                <label class="col-6 block text-sm" style="margin-bottom: 5px;">
                  <span class="text-gray-700 dark:text-gray-400">Driver Photo</span>
                  <input style="padding: 3px; border-color: #00aaaa; font-size: 14px; background-color: #efffff;" xdata-bvalidator="required" class="form-control" type="file" name="avatar">
                </label>
                <label class="col-6 block text-sm" style="margin-bottom: 5px;">
                  <span class="text-gray-700 dark:text-gray-400">License Photo</span>
                  <input style="padding: 3px; border-color: #00aaaa; font-size: 14px; background-color: #efffff;" xdata-bvalidator="required" class="form-control" type="file" name="license">
                </label>
              </div>

              <div>
                <!-- <button type="submit" id="modalsubmit" class="w-full px-3 py-1 mt-6 text-sm font-medium hidden">
                  Submit
                </button> -->
              </div>
              <div id="resultid"></div>
            </form>
          </div>
          <div class="modal-footer modal-footer-browser">
            <button type="button" id="" class="btn btn-secondary browser-btn browser-btn-secondary cancal" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary browser-btn browser-btn-primary" onclick="event.preventDefault();sendForm('', '', 'insertdriver', 'resultid', 'adduser')">Proceed</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="ticketBookingForm" tabindex="-1" role="dialog" aria-labelledby="ticketBookingFormLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-broswer modal2" role="document">
        <div class="modal-content browser-model-content">
          <div class="modal-body">

            <div class="testbox">
              <form id="tbook">
                <div class="">
                  <!-- <h1>Donation Form</h1> -->
                  <img style="object-fit:cover;width:790px;height:300px" src='main/uploads/vehicle/bustravel.jpg' />
                </div>
                <br />
                <fieldset>
                  <legend>Your Details</legend>
                  <label for="fname">Select Travel From<span style="color:red">*</span></label>
                  <div style="display:flex;justify-content:space-between">
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
            <button type="button" id="" class="btn btn-secondary browser-btn browser-btn-secondary cancal" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary browser-btn browser-btn-primary" onclick="event.preventDefault();sendForm('', '', 'insertticketbooking', 'resultid', 'tbook')">Proceed</button>
          </div>
        </div>
      </div>
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
  </main>
  <!-- ===============================================-->
  <!--    End of Main Content-->
  <!-- ===============================================-->




  <!-- ===============================================-->
  <!--    JavaScripts-->
  <!-- ===============================================-->
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