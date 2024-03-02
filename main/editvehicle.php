<?php
include "session.php";
$id = $_GET['hakuna'];
$rowvehicle =  $obj->selectextrawhere("vehicles", "id=" . $id . "")->fetch_assoc();
$vid = $rowvehicle['vehicleid'];
if ($vid == 1) {
    $seatarray = [4];
} else if ($vid == 2) {
    $seatarray = range(5, 8);
} else if ($vid == 3) {
    $seatarray = range(11, 15);
} else if ($vid == 4) {
    $seatarray = [11];
} else if ($vid == 5) {
    $seatarray = range(12, 26);
} else if ($vid == 6) {
    $seatarray = [48];
} else if ($vid == 7) {
    $seatarray = [4];
}
?>
<form style="overflow-x: hidden;" id="adduser" onsubmit="event.preventDefault();sendForm('id', '<?= $id ?>', 'updatevehicle', 'resultid', 'adduser');return 0;">
    <label class="block text-sm" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Vehicle Name.</span>
        <input name="name" value="<?= $rowvehicle['name'] ?>" data-bvalidator="required" class="form-control" placeholder="Name" />
    </label>
    <label class="block text-sm" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Vehicle No.</span>
        <input name="vehicleno" value="<?= $rowvehicle['vehicleno'] ?>" data-bvalidator="required" class="form-control" placeholder="Vehicle Number" />
    </label>
    <label class="block text-md">
        <span class="text-gray-700 dark:text-gray-400">Driver</span>
        <select data-bvalidator="required" class="form-control select2" name="userid" id="driver">
            <option value="">Select Driver</option>
            <?php
            $drivers = $obj->selectextrawhereupdate("users", "id,name", "status = 1 and type = 3 ");
            $driver = mysqli_fetch_all($drivers);
            foreach ($driver as list($id, $name)) { ?>
                <option value="<?php echo $id; ?>" <?= $id == $rowvehicle['userid'] ? "selected" : "" ?>> <?php echo $name; ?></option>
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
                <option value="<?php echo $id; ?>" <?= $id == $rowvehicle['vehicleid'] ? "selected" : "" ?>> <?php echo $name; ?></option>
            <?php
            } ?>
        </select>
    </label>
    <div id="seat">
        <div id="seat">
            <label class="block text-sm" style="margin-bottom: 5px;">
                <span class="text-gray-700 dark:text-gray-400">Seater</span>
                <input type="number" name="seater" data-bvalidator="required,digit,maxlength[2]" value="<?= $rowvehicle['seater'] ?>" class="form-control" placeholder="" />
            </label>
        </div>
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