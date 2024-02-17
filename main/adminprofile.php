<?php
include "main/session.php";
$rowemployee = $obj->selectextrawhere("users", "id=" . $employeeid . "")->fetch_assoc();
?>
<form id="adduser" onsubmit="event.preventDefault();sendForm('', '', 'updateprofile', 'resultid', 'adduser');return 0;">
    <!-- <label class="block text-sm  mb-3" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Name</span>
        <input disabled name="name" disabled data-bvalidator="required" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="<?= $rowemployee['name'] ?>" placeholder="Employee's Name" />
    </label>
    <label class="block text-sm  mb-3" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Mob No.</span>
        <input type="number" name="phone" data-bvalidator="minlength[10],maxlength[10]" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="<?= $rowemployee['mobile'] ?>" placeholder="Employee Mobile No." />
    </label> -->
    <label class="block text-sm mb-3" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Email</span>
        <input name="email" data-bvalidator="required,email" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="<?= $rowemployee['email'] ?>" placeholder="Employee's Email ID" />

    </label>
    <label class="block text-sm  mb-3" style="margin-bottom: 5px;position:relative">
        <span class="text-gray-700 dark:text-gray-400">Password</span>
        <input type="password" data-bvalidator="required,minlength[6]" id="password" name="password" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="<?= $rowemployee['password'] ?>" placeholder="Please Give Strong Password!" />
        <i id="eye" class="fa fa-eye" style="position: absolute;top:33px;right:10px" aria-hidden="true"></i>
    </label>
    <div>
        <span class="text-sm">To modify your password, enter your new password and Click on <b>"Submit"</b></span>
        <button type="submit" id="modalsubmit" class="w-full px-3 py-1 mt-6 text-sm font-medium hidden">
            Submit
        </button>
    </div>

    <div id="resultid"></div>
</form>
<script>
    $("#eye").click(() => {
        iconname = $("#eye").attr("class");
        if (iconname === 'fa fa-eye') {
            $('#password').attr('type', 'text')
            $("#eye").attr('class', 'fa fa-eye-slash')

        } else {
            $('#password').attr('type', 'password')
            $("#eye").attr('class', 'fa fa-eye')
        }
    })
    $('select').select2()
    <?php if (!in_array(35, $permissions)) { ?>
        $("#modalfooterbtn").css('display', 'none')
    <?php } ?>
</script>