<?php
include "session.php";
?>
<form style="overflow-x: hidden;" id="adduser" onsubmit="event.preventDefault();sendForm('', '', 'inserthelpline', 'resultid', 'adduser');return 0;">
    <label class="block text-sm" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Helpline No.</span>
        <input name="phone" value="<?= $helpline ?>" data-bvalidator="required,maxlength[10],minlength[10]" class="form-control" placeholder="Helpline No" />
    </label>
    <label class="block text-sm" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Change Password</span>
        <input name="password" value="" data-bvalidator="maxlength[6],minlength[6]" class="form-control" placeholder="Password" />
    </label>
    <div>
        <button type="submit" id="modalsubmit" class="w-full px-3 py-1 mt-6 text-sm font-medium hidden">
            Submit
        </button>
    </div>
    <div id="resultid"></div>
</form>