<?php
include "session.php";
$vid = $_GET['hakuna'];
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
<label class="block text-md">
    <span class="text-gray-700 dark:text-gray-400">No. of seats</span>
    <select data-bvalidator="required" class="form-control select2" name="seater" id="seat">
        <option value="">Select Seats</option>
        <?php
        foreach ($seatarray as $seat) { ?>
            <option value="<?php echo $seat; ?>"> <?php echo $seat; ?></option>
        <?php
        } ?>
    </select>
</label>