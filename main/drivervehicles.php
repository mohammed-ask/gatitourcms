<?php
include "session.php";
$id = $_GET['hakuna'];
$vehicle  = $obj->selectextrawhere("vehicles", "userid=" . $id . " and status = 1");
?>
<table class="table table-bordered">
    <thead>
        <th>Name</th>
        <th>Vehicle No</th>
        <th>Type</th>
        <th>Seater</th>
    </thead>
    <tbody>
        <?php while ($rowvehicle = $obj->fetch_assoc($vehicle)) { ?>
            <tr>
                <td><?= $rowvehicle['name'] ?></td>
                <td><?= $rowvehicle['vehicleno'] ?></td>
                <td><?= $obj->selectfieldwhere("vehiclenames", "name", "id=" . $rowvehicle['vehicleid'] . "") ?></td>
                <td><?= $rowvehicle['seater'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $('#modalfooterbtn').css("display", "none")
</script>