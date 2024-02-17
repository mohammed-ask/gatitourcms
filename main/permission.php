<?php
include "main/session.php";
ob_flush();
ob_start();
$responsive = 'true';
if (isset($_GET["hakuna"])) {
    $responsive = $_GET["hakuna"];
}
?>
<!-- <div class="row"> -->
<!-- <div class="col-sm-12"> -->
<div class="container px-6 mx-auto grid mobile-bottom-margin">
    <form action="">
        <?php
        if ($responsive == "true") { ?>
            <input type="" hidden name="hakuna" value="<?= ($responsive == "true") ? "false" : "true" ?>" id="">
            <!-- <button class="btn"><i class="fa fa-toggle-on" style="color:green"></i> Responsive On</button> -->
        <?php } else { ?>
            <input type="" hidden name="hakuna" value="<?= ($responsive == "false") ? "true" : "false" ?>" id="">
            <button class="btn"><i class="fa fa-toggle-off" style="color:red"></i> Responsive Off</button>
        <?php } ?>
    </form>
    <div class="card-header with-border">
        <h3 class="card-title with-border">Permission List</h3>
        <div class="card-tools pull-right">
            <?php if (in_array(82, $permissions)) { ?>
                <a href="addpermission" class="px-4 py-2 text-sm bg-purple rounded-lg">+ Add New Permission
                </a>
            <?php } ?>
            <!-- <a href="administrator" class="px-4 py-2 ml-2 text-sm font-medium leading-5 text-black text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                << Back </a> -->
            <!-- <button type="button" class="btn btn-tool" data-card-widget="">
                        <i class="fas fa-times"></i>
                    </button> -->
        </div>
    </div>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">

        <div class="w-full ">

            <table id="example1" class="table w-full whitespace-no-wrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <!-- <th>Description</th> -->
                        <th>Module</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <!-- <th>Description</th> -->
                        <th>Module</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>
<!-- </div> -->
<!-- </div> -->
<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Manage Permissions";
$pageheader = "";
$pagemeta = "Some Meta Goes Here";
$pagekeywords = "Some keywords Goes here";
$contentheader = "Manage Permissions";
include "templete.php";
?>
<script>
    $(document).ready(function() {
        $('#example1 tfoot th').each(function() {
            var title = $(this).text();
            if (title != "S No") {
                if (title == "Date of receipt of complaint") {
                    $(this).html('<input type="text" style="width:100px;" id="searchdate" onfocus="setcalender(\'searchdate\')" placeholder="Search ' + title + '" />');
                } else if (title == "Rca Done on") {
                    $(this).html('<input type="text" style="width:100px;" id="searchdate1" onfocus="setcalender(\'searchdate1\')" placeholder="Search ' + title + '" />');
                } else {
                    $(this).html('<input type="text" style="width:100px;" placeholder="Search ' + title + '" />');
                }
            }
        });
        table = $("#example1").DataTable({
            "responsive": <?= $responsive ?>,
            "ajax": "../main/admin/permissionsdata.php",
            "processing": true,
            "serverSide": true,
            "pageLength": 15,
            "bJQueryUI": true,
            "order": [
                [0, "desc"]
            ],
            "sPaginationType": "full_numbers",
            "sDom": '<""f>t<"F"lp>'
        });
        // Apply the search
        table.columns().every(function() {
            var that = this;
            console.log(this.value);
            $('input', this.footer()).on('keyup change', function() {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });
        $('table.data-table tfoot').each(function() {
            $(this).insertAfter($(this).siblings('thead'));
        });
    });
</script>