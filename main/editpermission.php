<?php
/* @var $obj db */
include 'main/session.php';
$fid = $_GET['hakuna'];
$ftable = "permissions";
$where = "id=" . $fid;
$res = $obj->selectextrawhere($ftable, $where);
$row = $obj->fetch_assoc($res);
?>
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">Edit Role</h3>
                <div class="card-tools">
                    <a href="permission" class="px-4 py-2  text-sm  bg-white  rounded-lg border border-gray" data-card-widget="">
                        << Back </a>
                            <button type="button" class="btn btn-tool" data-card-widget="">
                                <i class="fas fa-times"></i>
                            </button>
                </div>
            </div>
            <form id="addpermission" enctype="multipart/form-data">
                <div class="card-body">
                    <h3 class="card-title">Permission Name</h3>
                    <input class="form-control " autocomplete="off" value="<?php echo $row['name']; ?>" name="name" data-bvalidator="required" type="text" placeholder="Permission name">
                    <br />

                    <h3 class="card-title">Description/Symbol</h3>
                    <input class="form-control " value="<?php echo $row['description']; ?>" name="description" data-bvalidator="" type="text" placeholder="Permission Symbol">
                    <br />
                    <div class="form-group"><label>Modules</label>
                        <select class="form-control select2" name="module" id="module" placeholder="Module">
                            <?php
                            $tbname = "modules";
                            $result = $obj->selecttable($tbname);
                            while ($brow = $obj->fetch_assoc($result)) {
                            ?>

                                <option <?php if ($row['module'] == $brow['id']) {
                                            echo "selected='selected'";
                                        }  ?> value="<?php echo $brow['id']; ?>"> <?php echo $brow['name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <br />
                    <!-- <h3 class="card-title">Department</h3> -->
                    <!-- <select type="text" class="form-control" data-bvalidator="" id="deparment" class="form-control select2" name="department">

                        <option value="">Select One</option>
                        <?php

                        // $roles = $obj->selectextrawhereupdate("departments", "id ,name ", " status = 1 ");
                        // $rolesname = mysqli_fetch_all($roles);
                        //foreach ($rolesname as list($id, $name)) { 
                        ?>
                            <option value="<?php echo $id; ?>" <?= ($id == $row["department"]) ? "selected='selected'" : '' ?>> <?php echo $name ?> </option>
                        <?php

                        //}
                        ?>
                    </select> -->

                </div>
            </form>
            <div class="card-footer">
                <button class="px-4 py-2  text-sm  bg-green  rounded-lg " onclick="sendForm('hakuna', '<?php echo $fid; ?>', 'updatepermission', 'resultid', 'addpermission', 0)">Update Permission</button>
                <div class="col-md-12" id="resultid"></div>
            </div>
        </div><!-- div class card body ended -->
    </div>
</div>
<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Update Permission";
$pageheader = "";
$pagemeta = "Some Meta Goes Here";
$pagekeywords = "Some keywords Goes here";
$contentheader = "Edit Permission details";

include "main/admin/templete.php";
?>
<script>
    $(document).ready(function() {
        $("select").select2();
        //Flat red color scheme for iCheck

        $('.dater').datepicker({
            autoclose: true
        });

    });
</script>