<?php
session_start();
if (isset($_SESSION['userid'])) {
    $employeeid = $_SESSION['userid'];
    header("location:administrator");
}
include './main/function.php';
include './main/conn.php';
?>
<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Windmill Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../main/dist/css/tailwind.output.css" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="../main/dist/js/init-alpine.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../main/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../main/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../main/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../main/dist/css/bvalidator.css">
    <link rel="stylesheet" href="../main/dist/css/select2.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
</head>

<body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="../main/dist/img/login-office.jpeg" alt="Office" />
                    <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="../main/dist/img/login-office-dark.jpeg" alt="Office" />
                </div>
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <form onsubmit="event.preventDefault();sendForm('', '', 'checkforgetpassword', 'resultid', 'loginform');return 0;" id="loginform">
                        <div class="w-full">
                            <h4 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                                Forgot Password ?
                            </h4>
                            <span>A password reset link will be sent to your registered email address.</span>
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Email</span>
                                <input name="email" data-bvalidator='required' class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="example@gmail.com" />
                            </label>
                            <div id="resultid"></div>
                            <!-- You should use a button here, as the anchor is only used for the example  -->
                            <button type="submit" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Submit
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../main/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../main/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../main/dist/js/adminlte.min.js"></script>
    <script src="../main/dist/js/customfunction.js"></script>
    <script src="../main/dist/js/jquery.bvalidator-yc.js"></script>
    <script src="../main/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
</body>

</html>