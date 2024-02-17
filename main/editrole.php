<?php
include "main/session.php";
/* @var $obj db */
ob_start();
$role_id = $_GET['hakuna'];
$result = $obj->selectextrawhere("roles", "id=$role_id");
$row = $obj->fetch_assoc($result);
$perm = explode(",", $row['permissions']);
?>
<div class="row">
    <div class="col-12 mobile-bottom-margin">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Edit Role</h3>
                <div class="card-tools">
                    <a href="viewrole" class="px-4 py-2  text-sm  bg-white  rounded-lg border border-gray" data-card-widget="">
                        << Back </a>
                           
                </div>
            </div>
            <form id="addrole" onsubmit="event.preventDefault();sendForm('id', '<?php echo $role_id; ?>', 'updaterole', 'resultid', 'addrole');return 0;">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" value="<?php echo $row['name']; ?>" id="name" placeholder="" name="name">
                    </div>
                    <div class="row">
                        <?php
                        $resultmodule = $obj->selectextrawhere("modules", "status=1 order by department");
                        while ($rowmodule = $obj->fetch_assoc($resultmodule)) {
                        ?>
                            <div class="col-md-6">
                                <div class="card card-widget">
                                    <div class="card-header">

                                        <div class=" d-inline ">
                                            <input type="checkbox" id="" title="checkall" onclick="$('.module<?php echo $rowmodule['id']; ?>').prop('checked', $(this).prop('checked'));" class="">
                                            <label for="<?php echo str_replace(" ", "_", $rowmodule['name']); ?>"><?php echo $rowmodule['name']; ?></label>
                                        </div>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php
                                            $resultpermission = $obj->selectextrawhere("permissions", "status=1 and module='" . $rowmodule['id'] . "'");
                                            while ($rowpermission = $obj->fetch_assoc($resultpermission)) {
                                            ?>
                                                <div class="col-sm-6 mb-2">
                                                    <div class=" d-inline">
                                                        <input type="checkbox" <?php echo (in_array($rowpermission['id'], $perm)) ? 'checked="true"' : ''; ?> class="module<?php echo $rowmodule['id']; ?> dept<?php echo $rowdepartment['id']; ?>" id="" name="permissions[]" value="<?php echo $rowpermission['id']; ?>">
                                                        <label for="<?php echo str_replace(" ", "_", $rowpermission['name']); ?>">
                                                            <?php echo $rowpermission['name']; ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="px-4 py-2  text-sm  bg-blue  rounded-lg">Save</button>
                    <div id="resultid" class="form-result"></div>
                </div>
            </form>
        </div>
    </div>
    <!-- /.col -->
</div>
<?php
$pagemaincontent = ob_get_clean();
ob_clean();
$extracss = "";
$extrajs = '
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
';
$pagemeta = "";
$pagetitle = "Edit Role::.Manage Roles-Admin";
$pageheader = "Manage Roles";
$breadcrumb = '<ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>';
include "templete.php";
?>