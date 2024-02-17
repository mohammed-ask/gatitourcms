<?php
include "main/session.php";
/* @var $obj db */
ob_start();
?>
<div class="container px-6 mx-auto grid">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="my-0 text-1xl font-semibold text-gray-700 dark:text-gray-200">Roles</h3>
            <div class="card-tools">
                <?php if (in_array(25, $permissions)) { ?>
                    <a href="addrole" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        <b> + Add Role</b>
                    </a>
                <?php } ?>

                <!-- <a href="administrator" class="px-4 py-2 ml-2 text-sm font-medium leading-5 text-black text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                        << Back </a>
                            <button type="button" class="btn btn-tool" data-card-widget="">
                                <i class="fas fa-times"></i> -->
                </button>
            </div>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <!-- /.card-header -->
            <div class="w-full">
                <table id="example2" class="table w-full whitespace-no-wrap">
                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <!-- <th>Description/Symbol</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot></tfoot>
                    <!--<-->
                </table>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->

        </div>
    </div>
    <!-- /.card -->
    <!-- /.col -->
</div>
<?php
$pagemaincontent = ob_get_clean();
ob_clean();
$extracss = "";
$extrajs = '';
$pagemeta = "";
$pagetitle = "View Role::.Manage Roles-Admin";
$pageheader = "Manage Roles";
$breadcrumb = '<ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Role Management</li>
            </ol>';
include "templete.php";
?>
<script>
    $(function() {
        $('#example2').DataTable({
            "ajax": "../main/admin/rolesdata.php",
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
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
</script>