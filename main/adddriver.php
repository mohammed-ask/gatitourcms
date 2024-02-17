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
            <span class="text-gray-700 dark:text-gray-400">Whataspp No.</span>
            <input data-bvalidator="required,digit,minlength[10],maxlength[10]" name="whatsappno" class="form-control" placeholder="Driver's Whatsapp No." />
        </label>
    </div>
    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Aadhar No.</span>
            <input data-bvalidator="required" name="adharno" class="form-control" placeholder="Enter Aadhar No." /></label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">License No.</span>
            <input data-bvalidator="required" name="drivinglicense" class="form-control" placeholder="" /></label>
    </div>

    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Password</span>
            <input type="password" data-bvalidator="required" id="password" name="password" class="form-control" placeholder="Enter Password!" />
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