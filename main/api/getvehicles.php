<?php
date_default_timezone_set('Asia/Kolkata');
ini_set('memory_limit', '-1');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
header('Access-Control-Request-Headers: *');

$host = "localhost";

//Local Server
$database_Username = "root";
$database_Password = "";
$database_Name = "gatitour";
$port = 3306;

//Hostinger Server
$database_Username = "u414903392_root";
$database_Password = "0f&||o5EJj|L";
$database_Name = "u414903392_gatitour";
$port = 3306;
date_default_timezone_set('Asia/Kolkata');
/* object for db class in function.php $obj */
$obj = new db($host, $database_Username, $database_Password, $database_Name, $port);
class db
{
    /* main db class for @var $this */

    public $con, $employeeid;

    /* Create class Counstructor in which we create Data Base Connection And default db operation */

    public function __construct($hostname, $username, $password, $dbname, $port)
    {
        $this->employeeid = 0;
        if (isset($_SESSION['userid'])) {
            $this->employeeid = $_SESSION['userid'];
        }
        $this->con = mysqli_connect($hostname, $username, $password, $dbname, $port) or die("not connected" . mysqli_error());
        $this->execute("SET NAMES utf8");
        $this->execute("SET collation_connection = 'utf8_general_ci'");
    }

    /* Default db operation start */

    function execute($sql, $print = 0)
    {
        $employeeid = $this->employeeid;

        $sql11 = $sql;
        $sql . "<br><br><br>";
        $da = date("Ymd");
        mysqli_query($this->con, "CREATE TABLE IF NOT EXISTS `zquerylogs$da`  (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `query` text  NULL,
  `url` text  NULL,
  `added_by` int(255)  NULL,
  `added_on` datetime  NULL,
  `updated_by` int(255)  NULL,
  `updated_on` datetime  NULL,
  `status` int(11)  NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
        $sql1 = $this->escape($sql);
        $url = $_SERVER['REQUEST_URI'];
        $datetimenow = date("Y-m-d H:i:s");
        $sql2 = "insert into `zquerylogs$da`(query,url,added_by,added_on,updated_by,updated_on,status) values('$sql1','$url','$employeeid','$datetimenow','$employeeid','$datetimenow',1)";

        // mysqli_query($this->con, $sql2) or die($sql2 . mysqli_error($this->con));

        if ($print) {
            echo $sql;
        }
        $result = mysqli_query($this->con, $sql) or die($sql . mysqli_error($this->con));
        return $result;
    }

    function escape($data)
    {
        return mysqli_real_escape_string($this->con, $data);
    }


    function selectextrawhereupdate($tb_name, $field, $where, $print = 0)
    {
        $sql = " select $field from $tb_name where $where ";
        $result = $this->execute($sql, $print);
        return $result;
    }
    function fetch_assoc($result)
    {
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
    function updatewhere($tb_name, $tb_col_name, $sid, $print = 0)
    {
        $update = array();
        foreach ($tb_col_name as $col_name => $form_field) {
            $update[] = '`' . $col_name . '` = \'' . $this->escape($form_field) . '\'';
        }
        $sql = "update $tb_name set " . implode(',', $update) . " where $sid";

        $result = $this->execute($sql, $print);
        if ($result) {
            return 1;
        } else {
            //            echo "error";
        }
    }

    function selectextrawhere($tb_name, $where, $print = 0)
    {
        /**
         * (PHP 4, PHP 5, PHP 7)<br/>
         * Alias of <b>selectextrawhere</b>
         * @link http://abaxsoft.com/manual/en/function.php
         * @param $tb_name
         * @param $where
         */
        $sql = " select * from $tb_name where $where";
        $result = $this->execute($sql, $print);
        return $result;
    }

    function total_rows($result)
    {
        $num = mysqli_num_rows($result);
        return $num;
    }

    function insertid()
    {
        return mysqli_insert_id($this->con);
    }

    function insertnew($tb_name, $postdata, $print = 0)
    {
        foreach ($postdata as $key => $value) {
            $tbl[$key] = $key;
            $postdata[$key] = $this->escape($value);
        }
        $tbl_coloumn_name = array(implode('`, `', $tbl));
        $tbl_data = array(implode("', '", $postdata));
        $tb_col_name1 = "`" . implode("`, `", $tbl_coloumn_name) . "`";
        $form_field1 = implode("', '", $tbl_data);
        $sql = "insert into $tb_name ($tb_col_name1) values ('$form_field1')";
        if ($this->execute($sql, $print)) {
            $insertid = $this->insertid($this->con);
            if ($insertid) {
                return $insertid;
            } else {
                return FALSE;
            }
        } else {
            return false;
        }
    }

    function update($tb_name, $tb_col_name, $sid, $print = 0)
    {
        $update = array();
        foreach ($tb_col_name as $col_name => $form_field) {
            $form_field = trim($form_field);
            $update[] = '`' . $col_name . '` = \'' . $this->escape($form_field) . '\'';
        }
        $sql = "update $tb_name set " . implode(',', $update) . " where id='$sid'";
        //echo $sql;
        $result = $this->execute($sql, $print);
        //echo $result;
        if ($result) {
            return 1;
        } else {
            //echo "error";
        }
    }

    function selectfield($tb_name, $field, $col_name, $sid, $print = 0)
    {
        $sql = "select $field as `value` from $tb_name where $col_name = '$sid'";
        $result = $this->execute($sql, $print);
        $numrow = $this->total_rows($result);
        if ($numrow > 0) {
            $row = $this->fetch_assoc($result);
            $return = $row['value'];
        } else {
            $return = "Not Applicable";
        }
        return $return;
    }

    function selectfieldwhere($tb_name, $field, $where, $print = 0)
    {
        $sql = "select $field as `value` from $tb_name where $where";
        $result = $this->execute($sql, $print);
        $numrow = $this->total_rows($result);
        if ($numrow > 0) {
            $row = $this->fetch_assoc($result);
            $return = $row['value'];
        } else {
            $return = "";
        }
        return $return;
    }

    function fetchattachment($aid)
    {
        $ptname = "uploadfile";
        if ($aid != "" && $aid > 0) {
            $pwhere = "id=" . $aid;
            $presult = $this->selectextrawhere($ptname, $pwhere);
            $num = $this->total_rows($presult);
            $prow = $this->fetch_assoc($presult);
            if ($num) {
                return $prow['path'];
            } else {
                return;
            }
        } else {
            return;
        }
    }

    function checktoken()
    {
        $authHeader = getAuthorizationHeader();
        $chk =  $this->selectfieldwhere('users', "count(id)", "apptoken='" . $authHeader . "'");
        if (!empty($chk)) {
            return true;
        } else {
            return false;
        }
    }
}

function getAuthorizationHeader()
{
    $headers = getallheaders();
    return isset($headers['Authorization']) ? $headers['Authorization'] : null;
}


if ($obj->checktoken()) {

    // Query the database
    $dev = $obj->selectextrawhereupdate("vehiclenames", "id,name,path", "status = 1");
    $vdetail = [];
    while ($rowv = $obj->fetch_assoc($dev)) {
        $max;
        $min;
        if ($rowv['id'] == 1) {
            $max = 4;
            $min = 4;
        } else if ($rowv['id'] == 2) {
            $min = 5;
            $max = 8;
        } else if ($rowv['id'] == 3) {
            $min = 11;
            $max = 15;
        } else if ($rowv['id'] == 4) {
            $min = 11;
            $max = 11;
        } else if ($rowv['id'] == 5) {
            $min = 12;
            $max = 26;
        } else if ($rowv['id'] == 6) {
            $max = 48;
            $min = 48;
        } else if ($rowv['id'] == 7) {
            $max = 4;
            $min = 4;
        };
        $vdetail[$rowv['name']] = [
            "path" => $rowv['path'],
            "id" => $rowv['id'],
            "maxSeats" => $max,
            "minSeats" => $min,
        ];
    };
    // uksort($vdetail, function ($a, $b) {
    //     if ($a == 'Tempo Traveller') {
    //         return 1;
    //     } elseif ($b == 'Tempo Traveller') {
    //         return -1;
    //     } else {
    //         return strcasecmp($a, $b);
    //     }
    // });
    $vdetail = array_merge(array_diff_key($vdetail, ['Tempo Traveller' => 0]), ['Tempo Traveller' => $vdetail['Tempo Traveller']]);
    $data['vehicleDetail'] = $vdetail;
    $data['isMapValid'] = $obj->selectfieldwhere('personal_detail', 'mapvalid', 'status=11');
    $data['helpline'] = $obj->selectfieldwhere("personal_detail", "phone", "status = 11");
    // Check if data is found
    if (true) {
        // Return the data as JSON
        header('Content-Type: application/json');
        $data['status'] = "200";

        echo json_encode($data);
    } else {
        // If no data found
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Somthing went wrong']);
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Token is invalid']);
}
// run SQL statement

// die if SQL statement failed
