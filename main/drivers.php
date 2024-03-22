<?php
include "main/session.php";
/* @var $obj db */
ob_start();
// if (!in_array(4, $permissions)) {
//     header("location:index");
// }
?>
<div class="container px-6 mx-auto grid mobile-bottom-margin">

    <div class="flex" style="align-items: center;justify-content:space-between">
        <h3 class="my-6 font-semibold text-gray-700 dark:text-gray-200">Drivers List</h3>
        <?php //if (in_array(1, $permissions)) { 
        ?>
        <button @click="openModal" onclick='dynamicmodal("none", "adddriver", "", "Add New Driver")' class="my-6 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            + Add Driver
        </button>
        <?php //} 
        ?>

    </div>


    <div class="w-full overflow-hidden rounded-lg shadow-xs">

        <div class="w-full ">

            <table id="example2" class="table w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-sm font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-3 py-2">S.No.</th>
                        <th class="px-3 py-2">User Name</th>
                        <th class="px-3 py-2">Profile</th>
                        <th class="px-3 py-2">Mobile No.</th>
                        <th class="px-3 py-2">Whatsapp No.</th>
                        <th class="px-3 py-2">License No.</th>
                        <th class="px-3 py-2">License Expire</th>
                        <th class="px-3 py-2">License Photo</th>
                        <th class="px-3 py-2">Adhar</th>
                        <th class="px-3 py-2">Tracking Enabled</th>
                        <th class="px-3 py-2">Vehicles</th>
                        <th class="px-3 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                </tbody>
            </table>

        </div>
    </div>

</div>
<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagemeta = "";
$pagetitle = "Gati Tour: Drivers List";
$contentheader = "";
$pageheader = "";
include "templete.php";
?>
<script>
    $(function() {
        $('#example2').DataTable({
            "ajax": "main/driverdata.php",
            "processing": true,
            "serverSide": true,
            "pageLength": 1000,
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "order": [
                [0, "desc"]
            ]
        });
    });
    $(document).on('click', '#eye', () => {
        iconname = $("#eye").attr("class");
        if (iconname === 'fa fa-eye') {
            $('#password').attr('type', 'text')
            $("#eye").attr('class', 'fa fa-eye-slash')

        } else {
            $('#password').attr('type', 'password')
            $("#eye").attr('class', 'fa fa-eye')
        }
    })
</script>