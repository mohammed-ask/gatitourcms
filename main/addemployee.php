<form style="overflow-x: hidden;" id="adduser" onsubmit="event.preventDefault();sendForm('', '', 'insertdriver', 'resultid', 'adduser');return 0;">
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
            <span class="text-gray-700 dark:text-gray-400">Password</span>
            <input type="password" data-bvalidator="required,maxlength[8],minlength[4]" id="password" name="password" class="form-control" placeholder="Enter Password!" />
            <i id="eye" class="fa fa-eye" style="position: absolute;top:34px;right:18px;z-index:50" aria-hidden="true"></i>
        </label>
    </div>
    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Employee Role</span>
            <select data-bvalidator="required" class="form-control select2" name="role" id="role">
                <option value="">Select Role</option>
                <?php
                $role = $obj->selectextrawhereupdate("roles", "id,name", "status = 1 and id != 1");
                $emprole = mysqli_fetch_all($role);
                foreach ($emprole as list($id, $name)) { ?>
                    <option value="<?php echo $id; ?>"> <?php echo $name; ?></option>
                <?php
                } ?>
            </select>
        </label>

    </div>

    <div>
        <button type="submit" id="modalsubmit" class="w-full px-3 py-1 mt-6 text-sm font-medium hidden">
            Submit
        </button>
    </div>
    <div id="resultid"></div>
</form>
<script>
    $("select").select2({
        minimumResultsForSearch: -1
    })
</script>