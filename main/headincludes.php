 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title><?php
        if (isset($pagetitle) && (!empty($pagetitle))) {
          echo $pagetitle;
        } else {
          echo $defaultpagetitle;
        }
        ?></title>
 <!-- Shubham Template -->
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <title>Market</title>
 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

 <!-- Google Font: Source Sans Pro -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
 <!-- Font Awesome -->
 <link rel="stylesheet" href="main/plugins/fontawesome-free/css/all.min.css">
 <!-- Ionicons -->
 <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
 <!-- Tempusdominus Bootstrap 4 -->
 <link rel="stylesheet" href="main/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

 <link rel="stylesheet" href="main/dist/css/tailwind.output.css" />
 <!-- iCheck -->
 <link rel="stylesheet" href="main/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
 <!-- JQVMap -->
 <link rel="stylesheet" href="main/plugins/jqvmap/jqvmap.min.css">
 <!-- Theme style -->
 <link rel="stylesheet" href="main/dist/css/adminlte.min.css">
 <!-- overlayScrollbars -->
 <link rel="stylesheet" href="main/dist/css/style.css?ver=<?php echo time(); ?>">
 <link rel="stylesheet" href="main/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
 <!-- Theme style -->
 <link rel="stylesheet" href="main/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
 <link rel="stylesheet" href="main/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
 <link rel="stylesheet" href="main/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
 <link rel="stylesheet" href="main/plugins/jquery-ui/jquery-ui.css">
 <!-- Select2 -->
 <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
 <!-- Default theme -->
 <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
 <link rel="stylesheet" href="main/plugins/select2/css/select2.min.css?ver=<?php echo time(); ?>">
 <link rel="stylesheet" href="main/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
 <link rel="stylesheet" href="main/dist/css/bvalidator.css">
 <link rel="stylesheet" href="main/dist/css/jquery-ui-timepicker-addon.css">
 <!-- summernote -->

 <!-- App favicon -->
 <link rel="shortcut icon" href="main/images/logo/favicon.svg">

 <!-- summernote -->
 <link rel="stylesheet" href="main/plugins/summernote/summernote-bs4.min.css">
 <!-- Google tag (gtag.js) -->
 <script async src="https://www.googletagmanager.com/gtag/js?id=G-P9108ZJ253"></script>
 <script>
   window.dataLayer = window.dataLayer || [];

   function gtag() {
     dataLayer.push(arguments);
   }
   gtag('js', new Date());

   gtag('config', 'G-P9108ZJ253');
 </script>

 <?php
  if (isset($extracss)) {
    echo $extracss;
  } ?>