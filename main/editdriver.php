<?php
include "session.php";
$id = $_GET['hakuna'];
$rowuser = $obj->selectextrawhere("users", "id=" . $id . "")->fetch_assoc()
?>
<form style="overflow-x: hidden;" id="adduser" onsubmit="event.preventDefault();sendForm('id', '<?= $id ?>', 'updatedriver', 'resultid', 'adduser');return 0;">
    <label class="block text-sm" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Name</span>
        <input name="name" value="<?= $rowuser['name'] ?>" data-bvalidator="required" class="form-control" placeholder="Driver's Name" />
    </label>
    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Mob No.</span>
            <input data-bvalidator="required,digit,minlength[10],maxlength[10]" name="mobile" value="<?= $rowuser['mobile'] ?>" class="form-control" placeholder="Driver's Mobile No." />
        </label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Whataspp No.</span>
            <input data-bvalidator="required,digit,minlength[10],maxlength[10]" name="whatsappno" value="<?= $rowuser['whatsappno'] ?>" class="form-control" placeholder="Driver's Whatsapp No." />
        </label>
    </div>
    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Aadhar No.</span>
            <input data-bvalidator="required" value="<?= $rowuser['adharno'] ?>" name="adharno" class="form-control" placeholder="Enter Aadhar No." /></label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">License No.</span>
            <input data-bvalidator="required" value="<?= $rowuser['drivinglicense'] ?>" name="drivinglicense" class="form-control" placeholder="" /></label>
    </div>
    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">License Expiry Date</span>
            <input data-bvalidator="required" value="<?= changedateformatespecito($rowuser['licenseexpiry'], "Y-m-d", "d/m/Y") ?>" onfocus="setcalendernolimit(this.id,'')" name="licenseexpiry" class="form-control" placeholder="" id="date" /></label>
    </div>
    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;position:relative">
            <span class="text-gray-700 dark:text-gray-400">Password</span>
            <input type="password" value="<?= $rowuser['password'] ?>" data-bvalidator="required,maxlength[8],minlength[4]" id="password" name="password" class="form-control" placeholder="Enter Password!" />
            <i id="eye" class="fa fa-eye" style="position: absolute;top:34px;right:18px;z-index:50" aria-hidden="true"></i>
        </label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">City</span>
            <input type="text" value="<?= $rowuser['city'] ?>" data-bvalidator="required" id="city" name="city" class="form-control" placeholder="Enter City!" />
            <i id="eye" class="fa fa-eye" style="position: absolute;top:34px;right:18px;z-index:50" aria-hidden="true"></i>
        </label>
    </div>

    <div class="row mt-3">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Driver Photo</span>
            <input style="padding: 3px; border-color: #00aaaa; font-size: 14px; background-color: #efffff;" xdata-bvalidator="required" class="form-control" type="file" name="avatar">
        </label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">License Photo</span>
            <input style="padding: 3px; border-color: #00aaaa; font-size: 14px; background-color: #efffff;" xdata-bvalidator="required" class="form-control" type="file" name="license">
        </label>
    </div>

    <div class="row mt-3">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Vehicle Available</span>
            <select data-bvalidator="required" class="form-control select2" name="vehicleavailable" id="vehicle">
                <option <?= "Yes" == $rowuser['vehicleavailable'] ? "selected" : "" ?> value="Yes">Yes</option>
                <option <?= "No" == $rowuser['vehicleavailable'] ? "selected" : "" ?> value="No">No</option>
            </select>
        </label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Vehicle Preference</span>
            <select data-bvalidator="required" class="form-control select2" name="vehicletype" id="vehicletype">
                <option <?= "Both" == $rowuser['vehicletype'] ? "selected" : "" ?> value="Both">Both</option>
                <option <?= "Automatic" == $rowuser['vehicletype'] ? "selected" : "" ?> value="Automatic">Automatic</option>
                <option <?= "Semiautomatic" == $rowuser['vehicletype'] ? "selected" : "" ?> value="Semiautomatic">Semiautomatic</option>
            </select>
        </label>
    </div>
    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Latitude</span>
            <input type="text" value="<?= $rowuser['lat'] ?>" id="lat" name="lat" class="form-control" />

        </label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Longitude</span>
            <input type="text" value="<?= $rowuser['long'] ?>" id="long" name="long" class="form-control" />

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