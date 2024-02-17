<?php
include "main/session.php";
ob_flush();
ob_start();
?>
<div class="row">
    <div class="col-12">
        <!-- <a href="permissions.php" class="btn btn-blue btn-lg">
            << Back to Permissions</a> -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Role</h3>
                <div class="card-tools">
                    <a href="permission" class="px-4 py-2  text-sm  bg-white  rounded-lg border border-gray" data-card-widget="">
                        << Back </a>
                            <button type="button" class="btn btn-tool" data-card-widget="">
                                <i class="fas fa-times"></i>
                            </button>
                </div>
            </div>
            <form id="addtax" enctype="multipart/form-data">
                <div class="card-body">
                    <h3 class="card-title">Permission Name</h3>
                    <input class="form-control " autocomplete="off" name="name" id="name" type="text" placeholder="Permission name"> <br />
                    <br />
                    <h3 class="card-title">Permission Description/Symbol</h3>
                    <input class="form-control " autocomplete="off" name="description" id="description" type="text" placeholder="Permission Description">
                    <br />
                    <div class="form-group"><label>Module</label>
                        <select class="form-control select2" name="module" id="grades" placeholder="Module">
                            <?php
                            $tbname = "modules";
                            $result = $obj->selecttable($tbname);
                            while ($brow = $obj->fetch_assoc($result)) { ?>
                                <option value="<?php echo $brow['id']; ?>"> <?php echo $brow['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <br />
                    <!-- <h3 class="card-title">Department</h3> -->
                    <!-- <select type="text" class="form-control" data-bvalidator="" id="deparment" class="form-control select2" name="department">
                                    <option value="">Select One</option>
                                    <?php
                                    // $roles = $obj->selectextrawhereupdate("departments", "id,name", "status=1");
                                    // $rolesname = mysqli_fetch_all($roles);
                                    // foreach ($rolesname as list($id, $name)) { 
                                    ?>
                                        <option value="<?php echo $id; ?>"> <?php echo $name ?> </option>
                                    <?php //} 
                                    ?>
                                </select> -->
                </div>
            </form>
            <div class="card-footer">
                <button class="px-4 py-2  text-sm  bg-green  rounded-lg border border-gray" onclick="sendForm('', '', 'insertpermission', 'resultid', 'addtax')">Add Permission</button>
                <div class="col-md-12" id="resultid"></div>

            </div>
        </div>
    </div>
</div>
<?php
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Add New Permission";
$pageheader = "";
$pagemeta = "Some Meta Goes Here";
$pagekeywords = "Some keywords Goes here";
$contentheader = "Add New Permission";
include "templete.php";
?>
<script>
    $(document).ready(function() {
        $("select").select2();
        $('.dater').datepicker({
            autoclose: true
        });
    });
</script>