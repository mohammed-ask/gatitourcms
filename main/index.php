<?php
include "main/session.php";
/* @var $obj db */
ob_start();
$totalcutomer = $obj->selectfieldwhere("users", "count(id)", "status=1 and type=2");
$totaldriver = $obj->selectfieldwhere("users", "count(id)", "status=1 and type=3");
$totalvehicle = $obj->selectfieldwhere("vehicles", "count(id)", "status=1 ");
?>
<style>
    #datacards a {
        color: white;
    }
</style>
<div class="container px-6 mx-auto grid mobile-bottom-margin">

</div>
<?php
// }
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagemeta = "";
$pagetitle = "Gati Tour: Admin Dashboard";
$contentheader = "";
$pageheader = "";
include "main/templete.php";
?>