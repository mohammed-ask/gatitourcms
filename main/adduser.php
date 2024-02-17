<form style="overflow-x: hidden;" id="adduser" onsubmit="event.preventDefault();sendForm('', '', 'insertuserdirect', 'resultid', 'adduser');return 0;">
    <label class="block text-sm" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Name</span>
        <input name="username" data-bvalidator="required" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Client's Name" />
    </label>
    <label class="block text-sm" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Email</span>
        <input name="email" data-bvalidator="required,email" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Client's Email ID" />
    </label>
    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Mob No.</span>
            <input data-bvalidator="required,digit,minlength[10],maxlength[10]" name="mobileno" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Client's Mobile No." />
        </label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">DOB</span>
            <input id="date" data-bvalidator="required,gap18year" onfocus="setcalenderlimit(this.id,'')" data-bvalidator-msg-gap18year="Customer Should be minimum 18 year Old" name="dob" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Date of Birth" /></label>
    </div>
    <label class="block text-sm" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Address</span>
        <input data-bvalidator="required" name="address" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Client's Address" />
    </label>

    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Aadhar No.</span>
            <input data-bvalidator="required" name="adharno" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Enter Aadhar No." /></label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">PAN No.</span>
            <input data-bvalidator="required" name="panno" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Client's Pan No." /></label>
    </div>
    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Bank Namee</span>
            <input data-bvalidator="required" name="bankname" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="eg. BOI, State bank of India, Kotak etc..." /></label>

        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Account No.</span>
            <input data-bvalidator="required" name="accountno" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Client's A/c No." /></label>
    </div>

    <div class="row">

        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">IFSC</span>
            <input data-bvalidator="required" name="ifsc" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="IFSC Code of Bank" /></label>

        <!-- <label class="block text-sm" style="margin-bottom: 5px;">
        <span class="text-gray-700 dark:text-gray-400">Investment Amt.</span>
        <input name="investmentamount" value="0" data-bvalidator="required,digit" step="any" onfocus="this.select()" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Client's Investment" /></label> -->

        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Limit</span>
            <input type="number" name="limit" data-bvalidator="required" step="any" onfocus="this.select()" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="1" placeholder="Client's Limit on Investment" /></label>
    </div>

    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Stop Withdrawal- <span style="margin-left: 5px !important;">From</span></span>
            <input name="starttime" id="starttime" onfocus="datetimepicker(this.id)" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Select Start Time" />
        </label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">To</span>
            <input name="endtime" id="endtime" onfocus="datetimepicker(this.id)" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Select End Time" />
        </label>
    </div>

    <div>
        <label class="block text-sm" style="margin-bottom: 5px;">
            <div class="row my-1"> <span class="col-6 text-gray-700 dark:text-gray-400"> Withdrawal Message</span>
                <span id="switchtype" class="col-6 text-right text-gray-700 dark:text-gray-400" style="color:green">Custom Message</span>
            </div>
            <div id="stype">
                <select data-bvalidator="required" name="message" class="select2 block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">


                    <option value="Withdrawal temporarily unavailable due to a technical problem. Our team is working to resolve it promptly. Thank you for your patience.">Withdrawal temporarily unavailable due to a technical problem. Our team is working to resolve it promptly. Thank you for your patience.</option>

                    <option value="Withdrawal Restriction: You are currently unable to make a withdrawal for the next 24 hours. Please try again after the specified time has elapsed. Apologies for any inconvenience caused.">Withdrawal Restriction: You are currently unable to make a withdrawal for the next 24 hours. Please try again after the specified time has elapsed. Apologies for any inconvenience caused.</option>
                    <option value="Withdrawal temporarily unavailable due to suspicious activity. Please re-verify your account to ensure security. To re-verify send your document(PAN, Aadhar & Bank Details) on mail. It will take 7 working days for verification.">Withdrawal temporarily unavailable due to suspicious activity. Please re-verify your account to ensure security. To re-verify send your document(PAN, Aadhar & Bank Details) on mail. It will take 7 working days for verification.</option>
                    <option value="Withdrawal Limit: You can only withdraw once every 7 days. Please wait until the specified time period has passed to initiate a withdrawal.">Withdrawal Limit: You can only withdraw once every 7 days. Please wait until the specified time period has passed to initiate a withdrawal.</option>
                </select>
            </div>
    </div>

    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Password</span>
            <input type="password" data-bvalidator="required" id="password" name="password" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Enter Password!" />
        </label>
        <!-- <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Confirm Password</span>
            <input type="password" id="confirmpassword" data-bvalidator="required,matchconfirmpassword[password]" data-bvalidator-msg-matchconfirmpassword="Confirm Password Not Matched" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Confirm Password" />
        </label> -->
    </div>
    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Carry Forward</span>
            <select data-bvalidator="required" name="carryforward" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                <option value="No">No</option>
                <option value="Yes">Yes</option>
            </select>
        </label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Long Holding</span>
            <select data-bvalidator="required" name="longholding" class="select2 block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                <option value="No">No</option>
                <option value="Yes">Yes</option>
            </select>
        </label>
    </div>

    <label class="block text-sm" style="margin-bottom: 15px;">
        <span class="text-gray-700 dark:text-gray-400">Employee ID</span>
        <input xdata-bvalidator="required" name="employeeref" class="select2 block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Employee ID For Furthur Reference" /></label>

    <strong>Documents</strong>

    <div class="row mt-3">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Aadhar Front Side</span>
            <input hidden value="Aadhar Card Front" name="name[]">
            <input style="padding: 3px; border-color: #00aaaa; font-size: 14px; background-color: #efffff;" xdata-bvalidator="required" class="form-control" type="file" name="path[]">
        </label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <input hidden value="Aadhar Card Back" name="name[]">
            <span class="text-gray-700 dark:text-gray-400">Aadhar Back Side</span>
            <input style="padding: 3px; border-color: #00aaaa; font-size: 14px; background-color: #efffff;" xdata-bvalidator="required" class="form-control" type="file" name="path[]">
        </label>
    </div>

    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Pan Card</span>
            <input hidden value="PAN card" name="name[]">

            <input style="padding: 3px; border-color: #00aaaa; font-size: 14px; background-color: #efffff;" xdata-bvalidator="required" class="form-control" type="file" name="path[]">
        </label>
        <label class="col-6 block text-sm" sty le="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Signature</span>
            <input hidden value="Signature" name="name[]">
            <input style="padding: 3px; border-color: #00aaaa; font-size: 14px; background-color: #efffff;" xdata-bvalidator="required" class="form-control" type="file" name="path[]">
        </label>
    </div>

    <div class="row">
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Passport Size Photo</span>
            <input hidden value="Passport Size Photo" name="name[]">
            <input style="padding: 3px; border-color: #00aaaa; font-size: 14px; background-color: #efffff;" xdata-bvalidator="required" class="form-control" type="file" name="path[]">
        </label>
        <label class="col-6 block text-sm" style="margin-bottom: 5px;">
            <span class="text-gray-700 dark:text-gray-400">Passbook</span>
            <input hidden value="Passbook" name="name[]">
            <input style="padding: 3px; border-color: #00aaaa; font-size: 14px; background-color: #efffff;" xdata-bvalidator="required" class="form-control" type="file" name="path[]">
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