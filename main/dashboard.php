<?php
include "main/session.php";
/* @var $obj db */
ob_start();
$totalcutomer = $obj->selectfieldwhere("users", "count(id)", "status=1 and type=2");
$totaldriver = $obj->selectfieldwhere("users", "count(id)", "status=1 and type=3");
$totalvehicle = $obj->selectfieldwhere("vehicles", "count(id)", "status=1 ");
?>
<style>
    #datacards a {
        color: white;
    }
</style>
<?php if (in_array(18, $permissions)) { ?>
    <div class="container px-6 mx-auto grid mobile-bottom-margin">

        <h2 class="my-6 font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h2>

        <!-- Cards -->
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2  font-medium text-gray-600 dark:text-gray-400">
                        Total Customers
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        <?= $totalcutomer ?>
                    </p>
                </div>
            </div>

            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2  font-medium text-gray-600 dark:text-gray-400">
                        Total Drivers
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        <?= $totaldriver ?>
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <i class="fa-solid fa-car w-5 h-5" fill="currentColor" viewBox="0 0 20 20"></i>
                </div>
                <div>
                    <p class="mb-2  font-medium text-gray-600 dark:text-gray-400">
                        Total Vehicles
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        <?= $totalvehicle ?>
                    </p>
                </div>
            </div>
            <!-- Card -->
            <!-- <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                <i class="fa-solid fa-handshake-angle w-5 h-5" fill="currentColor" viewBox="0 0 20 20"></i>
            </div>
            <div>
                <p class="mb-2  font-medium text-gray-600 dark:text-gray-400">

                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    0
                </p>
            </div>
        </div> -->
        </div>


    </div>
<?php } ?>
<!-- right col -->
</section>
<?php
// }
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagemeta = "";
$pagetitle = "Gati Tour: Admin Dashboard";
$contentheader = "";
$pageheader = "";
include "main/templete.php";
?>