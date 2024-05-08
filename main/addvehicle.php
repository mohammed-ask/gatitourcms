<?php
include "session.php";
?>
<form style="overflow-x: hidden;" id="adduser" onsubmit="event.preventDefault();sendForm('', '', 'insertvehicle', 'resultid', 'adduser');return 0;">
    <label class="block text-sm" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Vehicle Name.</span>
        <input name="name" data-bvalidator="required" class="form-control" placeholder="Name" />
    </label>
    <label class="block text-sm" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Vehicle No.</span>
        <input name="vehicleno" data-bvalidator="required" class="form-control" placeholder="Vehicle Number" />
    </label>
    <label class="block text-md">
        <span class="text-gray-700 dark:text-gray-400">Driver</span>
        <select data-bvalidator="required" class="form-control select2" name="userid" id="driver">
            <option value="">Select Driver</option>
            <?php
            $drivers = $obj->selectextrawhereupdate("users", "id,name", "status = 1 and type = 3 order by id desc");
            $driver = mysqli_fetch_all($drivers);
            foreach ($driver as list($id, $name)) { ?>
                <option value="<?php echo $id; ?>"> <?php echo $name; ?></option>
            <?php
            } ?>
        </select>
    </label>
    <label class="block text-md">
        <span class="text-gray-700 dark:text-gray-400">Vehicle</span>
        <select data-bvalidator="required" class="form-control select2" name="vehicleid" id="vehicle">
            <option value="">Select Vehicle</option>
            <?php
            $vehicles = $obj->selectextrawhereupdate("vehiclenames", "id,name", "status = 1 ");
            $vehicle = mysqli_fetch_all($vehicles);
            foreach ($vehicle as list($id, $name)) { ?>
                <option value="<?php echo $id; ?>"> <?php echo $name; ?></option>
            <?php
            } ?>
        </select>
    </label>
    <div id="seat">
        <label class="block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Seater</span>
            <input type="number" name="seater" data-bvalidator="required,digit,maxlength[2]" class="form-control" placeholder="" />
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
    $('select').select2()
</script>