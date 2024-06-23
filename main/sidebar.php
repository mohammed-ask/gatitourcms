<!-- Desktop sidebar -->
<aside style="font-size: 14px;" class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
  <div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="https://gatitour.in/dashboard">
      <img src="main/images/Gatitour.png" style="margin-left: 25px; margin-top: -30px; margin-bottom: 35px; width:175px" alt="logo">
    </a>

    <ul>
      <li class="relative px-6 py-2">
        <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="dashboard">

          <i style="color: #057c7c;" class="fa-solid fa-house w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"></i>

          <span class="ml-3">Dashboard</span>
        </a>
      </li>
    </ul>

    <?php if (in_array(8, $permissions)) { ?>
      <ul>
        <li class="relative px-6 py-2">
          <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="viewrole">

            <i style="color: #057c7c;" class="fa-solid fa-house w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"></i>

            <span class="ml-3">Role Management</span>
          </a>
        </li>
      </ul>
    <?php } ?>

    <?php //if (in_array(15, $permissions)) { 
    ?>
    <ul>
      <li class="relative px-6 py-2">
        <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="customers">
          <i style="color: #057c7c;" class="fa-solid fa-user-clock"></i>
          <span class="ml-3">Customer List</span>
        </a>
      </li>
    </ul>
    <?php //} 
    ?>
    <ul>
      <li class="relative px-6 py-2">
        <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="useractivity">
          <i style="color: #057c7c;" class="fa-solid fa-user-clock"></i>
          <span class="ml-3">Customer Activity</span>
        </a>
      </li>
    </ul>
    <ul>
      <li class="relative px-6 py-2">
        <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="ticketbooking">
          <i style="color: #057c7c;" class="fa-solid fa-user-clock"></i>
          <span class="ml-3">Vehicle Booking</span>
        </a>
      </li>
    </ul>
    <?php //if (in_array(25, $permissions)) { 
    ?>
    <ul>
      <li class="relative px-6 py-2">
        <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="drivers">
          <i style="color: #057c7c;" class="fa-solid fa-indian-rupee-sign"></i>
          <span class="ml-4">Drivers</span>
        </a>
      </li>
    </ul>
    <?php //} 
    ?>

    <?php //if (in_array(29, $permissions)) { 
    ?>
    <ul>
      <li class="relative px-6 py-2">
        <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="vehicles">
          <i style="color: #057c7c;" class="fa-solid fa-money-bill-transfer"></i>
          <span class="ml-3">Vehicles</span>
        </a>
      </li>
    </ul>
    <?php //} 
    ?>
    <?php if (in_array(8, $permissions)) { ?>
      <ul>
        <li class="relative px-6 py-2">
          <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="employeelist">

            <i style="color: #057c7c;" class="fa-solid fa-house w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"></i>

            <span class="ml-3">Employee list</span>
          </a>
        </li>
      </ul>
    <?php } ?>
    </ul>
    <?php if (in_array(999, $permissions)) { ?>
      <div class="px-6 my-6">
        <button class="flex items-center justify-between w-full px-4 py-2  font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" onclick='window.location.href="settings"'>
          Settings
          <span class="ml-2" aria-hidden="true"> <i class="fa fa-cog "></i></span>
        </button>
      </div>
    <?php } ?>

  </div>
</aside>
<!-- Mobile sidebar -->
<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
<aside style="font-size: 13px;" class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu" @keydown.escape="closeSideMenu">
  <div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="https://gatitour.com/dashboard">
      <img src="../main/images/logo/Gati Tour logo with black text svg.svg" style="margin-left: 25px; margin-top: -30px; margin-bottom: 40px; width:175px" alt="logo">
    </a>

    <ul>
      <li class="relative px-6 py-2">
        <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="index">

          <i style="color: #057c7c;" class="fa-solid fa-house w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"></i>

          <span class="ml-3">Dashboard</span>
        </a>
      </li>
    </ul>
    <?php if (in_array(31, $permissions)) { ?>
      <!-- <ul>
        <li class="relative px-6 py-2">
          <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="requestwithdrawal">
            <i class="fas fa-rupee-sign"></i>
            <span class="ml-3">Request Withdrawal</span>
          </a>
        </li>
      </ul> -->
    <?php } ?>
    <?php if (in_array(8, $permissions)) { ?>
      <ul>
        <li class="relative px-6 py-2">
          <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="viewrole">

            <i style="color: #057c7c;" class="fa-solid fa-house w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"></i>

            <span class="ml-3">Role Management</span>
          </a>
        </li>
      </ul>
    <?php } ?>


    <?php //if (in_array(15, $permissions)) { 
    ?>
    <ul>
      <li class="relative px-6 py-2">
        <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="customers">
          <i style="color: #057c7c;" class="fa-solid fa-user-clock"></i>
          <span class="ml-3">Customers</span>
        </a>
      </li>
    </ul>
    <?php //} 
    ?>
    <?php //if (in_array(25, $permissions)) { 
    ?>
    <ul>
      <li class="relative px-6 py-2">
        <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="drivers">
          <i style="color: #057c7c;" class="fa-solid fa-indian-rupee-sign"></i>
          <span class="ml-4">Drivers</span>
        </a>
      </li>
    </ul>
    <?php //} 
    ?>

    <?php //if (in_array(29, $permissions)) { 
    ?>
    <ul>
      <li class="relative px-6 py-2">
        <a class="inline-flex items-center w-full  font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="vehicles">
          <i style="color: #057c7c;" class="fa-solid fa-money-bill-transfer"></i>
          <span class="ml-3">Vehicles</span>
        </a>
      </li>
    </ul>
    <?php //} 
    ?>

    <?php if (in_array(999, $permissions)) { ?>
      <div class="px-6 my-6">
        <button class="flex items-center justify-between w-full px-4 py-2  font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" onclick='window.location.href="settings"'>
          Settings
          <span class="ml-2" aria-hidden="true"> <i class="fa fa-cog "></i></span>
        </button>
      </div>
    <?php } ?>

  </div>
</aside>