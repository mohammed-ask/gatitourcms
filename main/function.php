<?php

$leagalpoint = '<div style="font-size:9px;font-weight: bold;">
    <br><br><br>
Disclaimer
<br>
This message contains legally privileged and/or confidential information. If you are not the intended recipient(s), or employee or agent responsible for delivery of this message to the intended recipient(s), you are hereby notified that any dissemination, distribution or copying of this e-mail message is strictly prohibited. If you have received this message in error, please immediately notify the sender and delete this e-mail message from your computer.
<br>WARNING: Computer viruses can be transmitted via email. The recipient should check this email and any attachments for the presence of viruses. The company accepts no liability for any damage caused by any virus transmitted by this email.
</div>';

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
        //         $sql . "<br><br><br>";
        //         $da = date("Ymd");
        //         mysqli_query($this->con, "CREATE TABLE IF NOT EXISTS `zquerylogs$da`  (
        //   `id` int(255) NOT NULL AUTO_INCREMENT,
        //   `query` text  NULL,
        //   `url` text  NULL,
        //   `added_by` int(255)  NULL,
        //   `added_on` datetime  NULL,
        //   `updated_by` int(255)  NULL,
        //   `updated_on` datetime  NULL,
        //   `status` int(11)  NULL,
        //   PRIMARY KEY (`id`)
        // ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        // ");
        // $sql1 = $this->escape($sql);
        // $url = $_SERVER['REQUEST_URI'];
        // $datetimenow = date("Y-m-d H:i:s");
        // $sql2 = "insert into `zquerylogs$da`(query,url,added_by,added_on,updated_by,updated_on,status) values('$sql1','$url','$employeeid','$datetimenow','$employeeid','$datetimenow',1)";

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

    function fetch_assoc($result)
    {
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function fetchattachment($aid)
    {
        $ptname = "uploadfile";
        if ($aid != "" && $aid > 0) {
            $pwhere = "id='" . $aid . "'";
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

    function select($tb_name, $sid, $print = 0)
    {
        $sql = "select * from $tb_name where id like '$sid'";
        if ($print) {
            echo $sql;
        }
        $result = $this->execute($sql);
        return $result;
    }

    function selecttable($tb_name, $print = 0)
    {
        $sql = "select * from `$tb_name` where `status`='1' order by id desc";
        $result = $this->execute($sql, $print);
        return $result;
    }

    function selecttableasc($tb_name, $print = 0)
    {
        $sql = "select * from `$tb_name` where `status`='1' order by id asc";
        $result = $this->execute($sql, $print);
        return $result;
    }

    function selectptable($tb_name, $print = 0)
    {
        $sql = "select * from `$tb_name` where `status`='0' order by id desc";
        $result = $this->execute($sql, $print);
        return $result;
    }

    function selectdtable($tb_name, $print = 0)
    {
        $sql = "select * from `$tb_name` where `status`='99' order by id desc";
        $result = $this->execute($sql, $print);
        return $result;
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

    function selectin($tb_name, $col_name, $values, $print = 0)
    {
        if (!empty($values)) {
            $sql = "select * from $tb_name where `$col_name` in ($values)";
            $result = $this->execute($sql, $print);
            return $result;
        } else {
            return "NA";
        }
    }

    function selectorder($tb_name, $sid, $order, $print = 0)
    {
        $result = $this->selectextrawhere($tb_name, "id like '$sid' $order", $print);
        return $result;
    }

    function fixedselect($tb_name, $tb_col_name, $sid, $print = 0)
    {
        $sql = "select * from $tb_name where `$tb_col_name` like '$sid'";
        $result = $this->execute($sql, $print);
        return $result;
    }

    function fixedselectorder($tb_name, $tb_col_name, $sid, $order, $print = 0)
    {
        $sql = "select * from $tb_name where `$tb_col_name` like '$sid' $order";
        $result = $this->execute($sql, $print);
        return $result;
    }

    function selectextrawhereorder($tb_name, $where, $order)
    {
        $result = $this->selectextrawhere($tb_name, $where . " " . $order);
        return $result;
    }

    /* function for @selectextrawhere */
    /* return array */

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

    function selectextrawhereupdate($tb_name, $field, $where, $print = 0)
    {
        $sql = " select $field from $tb_name where $where ";
        $result = $this->execute($sql, $print);
        return $result;
    }

    /* select function End */

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

    function fixedupdate($tb_name, $tb_col_name, $column, $sid)
    {
        $update = array();
        foreach ($tb_col_name as $col_name => $form_field) {
            $update[] = '`' . $col_name . '` = \'' . $this->escape($form_field) . '\'';
        }
        $sql = "update $tb_name set" . implode(',', $update) . "where `$column`='$sid'";
        $result = $this->execute($sql);
        if ($result) {
            return 1;
        } else {
            //echo "error";
        }
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

    function updatein($tb_name, $tb_col_name, $sid)
    {
        $update = array();
        foreach ($tb_col_name as $col_name => $form_field) {
            $update[] = '`' . $col_name . '` = \'' . $this->escape($form_field) . '\'';
        }
        $sql = "update $tb_name set" . implode(',', $update) . "where id in ($sid)";
        $result = $this->execute($sql);
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }

    function delete($tb_name, $id)
    {
        //          $sql = "delete from `$tb_name` where `id`='$id' ";
        $sql = "update`$tb_name` set status=99, updated_on = Now(), updated_by = " . $this->employeeid . " where `id`='$id' ";
        if ($this->execute($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    function deleteFinal($tb_name, $id)
    {
        //          $sql = "delete from `$tb_name` where `id`='$id' ";
        $sql = "delete from `$tb_name` where `id`='$id' ";
        if ($this->execute($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    function deleteFinalWhere($tb_name, $where)
    {
        //          $sql = "delete from `$tb_name` where `id`='$id' ";
        $sql = "delete from `$tb_name` where $where ";
        if ($this->execute($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    function insertid()
    {
        return mysqli_insert_id($this->con);
    }

    function total_rows($result)
    {
        $num = mysqli_num_rows($result);
        return $num;
    }

    function saveactivity($activity, $reason, $activityid, $supportid, $department, $category, $how = "By Software")
    {
        /* activity Log */
        $log['activity'] = $activity;
        $log['remark'] = $reason;
        $log['how'] = $how;
        $log['activityid'] = $activityid;
        $log['supportid'] = $supportid;
        $log['department'] = $department;
        $log['category'] = $category;
        $log['ip'] = $_SERVER['REMOTE_ADDR'];
        $log['city'] = "";
        $log['added_by'] = $this->employeeid;
        $log['added_on'] = date("Y-m-d H:i:s");
        $log['updated_by'] = $this->employeeid;
        $log['updated_on'] = date("Y-m-d H:i:s");
        $log['status'] = "1";
        $this->insertnew("activitylog", $log);
    }

    function insert($tb_name, $tb_col_name, $form_field, $print = 0)
    {
        $tb_col_name1 = "`" . implode("`, `", $tb_col_name) . "`";
        $form_field1 = implode("', '", $form_field);
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

    /* cashfree */

    function generatecftoken()
    {

        $generatetoken = CFURL . "/cac/v1/authorize";
        $data = array('X-Client-Id:' . CLIENTID, 'X-Client-Secret:' . SECRETID);
        try {
            $ch = curl_init($generatetoken);

            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $data);
            curl_setopt($ch, CURLOPT_TIMEOUT, 28000);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 28000);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            $output = curl_exec($ch);
            $res = json_decode($output);
            $atoken = $res->subCode;
            if ($atoken == 200) {
                $pdate = array();
                $pdate['token'] = $res->data->token;
                $pdate['refresh_token'] = $res->data->expiry;
                $pdate['status'] = 1;
                $pdate['added_on'] = date('Y-m-d H:i:s');
                $pdate['added_by'] = $this->employeeid;
                $pdate['updated_by'] = $this->employeeid;
                $pdate['updated_on'] = date('Y-m-d H:i:s');
                $pradin = $this->updatewhere("cftoken", ['status' => 0], "status=1");
                if ($pradin) {
                    $pra = $this->insertnew("cftoken", $pdate);
                    return $pdate['token'];
                }
            }
            // print_r($atoken);

            if (FALSE === $output) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        } catch (Exception $e) {

            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }
    }

    function getcftoken()
    {

        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        $verifyurl = CFURL . "/cac/v1/verifyToken";

        $tokentime = $this->selectextrawhereupdate("cftoken", "token,added_on", "status=1");
        $numtoken = $this->total_rows($tokentime);
        if ($numtoken) {
            $time = $this->fetch_assoc($tokentime);
            $verify = array();

            $date = date('Y-m-d H:i:s');
            $da = strtotime($date);

            try {
                $ch = curl_init($verifyurl);

                if (FALSE === $ch)
                    throw new Exception('failed to initialize');

                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer ' . $time['token']));
                curl_setopt($ch, CURLOPT_TIMEOUT, 28000);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 28000);

                $output = curl_exec($ch);

                $res = json_decode($output);
                $atoken = $res->status;
                if ($atoken == 200) {
                    return $time['token'];
                } else {
                    return $this->generatecftoken();
                }
                // print_r($atoken);


                if (FALSE === $output) {
                    throw new Exception(curl_error($ch), curl_errno($ch));
                }
            } catch (Exception $e) {

                trigger_error(
                    sprintf(
                        'Curl failed with error #%d: %s',
                        $e->getCode(),
                        $e->getMessage()
                    ),
                    E_USER_ERROR
                );
            }
        } else {
            return $this->generatecftoken();
        }
    }

    function createvpa($accountid, $name, $phone, $email, $remitteraccount, $remitterifsc, $allotmentid)
    {
        $generatetoken = CFURL . "/cac/v1/createVA";
        $datapost = array(
            "virtualVpaId" => $accountid,
            "name" => $name,
            "phone" => $phone,
            "email" => $email,
            "remitterAccount" => $remitteraccount,
            "remitterIfsc" => $remitterifsc
        );

        $token = $this->getcftoken();

        try {
            $ch = curl_init($generatetoken);
            $data_string = json_encode($datapost);
            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            $data = array("Authorization :" . "Bearer " . $token . "", "Content-Type:" . "application/json");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $data);
            curl_setopt($ch, CURLOPT_TIMEOUT, 28000);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 28000);

            $output = curl_exec($ch);
            $res = json_decode($output);
            $atoken = $res->subCode;
            if ($atoken != 200) {
                if ($atoken == 409) {
                    $this->getvpadetail($accountid, $allotmentid);
                } else {
                    print_r($res);
                }
            }
            if ($atoken == 200) {
                $virtual = $this->selectfieldwhere("virtualaccount", "count(id)", "allotmentid=$allotmentid and status = 1");
                $pdate = array();
                $pdate['allotmentid'] = $allotmentid;
                $pdate['allotmentno'] = $accountid;
                $pdate['accountNumber'] = $res->data->vpa; //$res->data->accountNumben;
                // $pdata['ifsc'] = ""; //$res->data->ifsc;
                $pdate['status'] = 1;
                $pdate['updated_by'] = $this->employeeid;
                $pdate['updated_on'] = date('Y-m-d H:i:s');
                if ($virtual > 0) {
                    $this->updatewhere("virtualaccount", $pdate, "allotmentid = $allotmentid");
                } else {
                    $pdate['added_on'] = date('Y-m-d H:i:s');
                    $pdate['added_by'] = $this->employeeid;
                    $vid = $this->insertnew("virtualaccount", $pdate);
                }
                $this->creatqrcode($vid);
                return $vid; //$pdate['token'];

            }
            // print_r($atoken);

            if (FALSE === $output) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        } catch (Exception $e) {

            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }
    }
    function creatqrcode($id)
    {
        $vupiid = $this->selectfieldwhere("virtualaccount", "accountnumber", "id='$id'");
        $generatetoken = CFURL . "/cac/v1/createQRCode?virtualVPA=$vupiid";
        $token = $this->getcftoken();

        try {
            $ch = curl_init($generatetoken);
            // $data_string = json_encode($datapost);
            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            $data = array("Authorization:" . "Bearer " . $token . "", "Content-Type:application/json");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $data);
            curl_setopt($ch, CURLOPT_TIMEOUT, 28000);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 28000);

            $output = curl_exec($ch);
            $res = json_decode($output);
            $atoken = $res->subCode;
            if ($atoken == 200) {
                $pdate = array();
                $pdate['qrimage'] = $res->qrCode;
                $update = $this->update("virtualaccount", $pdate, "$id");
                return $update; //$pdate['token'];

            }
            // print_r($atoken);

            if (FALSE === $output) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        } catch (Exception $e) {

            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }
    }

    function getvpadetail($accountid, $allotmentid)
    {
        $generatetoken = CFURL . "/cac/v1/Va/$accountid";
        // $datapost = array(
        //     "virtualVpaId" => $accountid,
        //     "name" => $name,
        //     "phone" => $phone,
        //     "email" => $email,
        //     "remitterAccount" => $remitteraccount,
        //     "remitterIfsc" => $remitterifsc
        // );

        $token = $this->getcftoken();

        try {
            $ch = curl_init($generatetoken);
            // $data_string = json_encode($datapost);
            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            $data = array("Authorization :" . "Bearer " . $token . "", "Content-Type:" . "application/json");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $data);
            curl_setopt($ch, CURLOPT_TIMEOUT, 28000);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 28000);

            $output = curl_exec($ch);
            $res = json_decode($output);
            $atoken = $res->subCode;
            if ($atoken != 200) {
            }
            print_r($res);

            if ($atoken == 200) {
                $virtual = $this->selectfieldwhere("virtualaccount", "id", "allotmentid=$allotmentid and status = 1");
                $vid = 0;
                $pdate = array();
                $pdate['allotmentid'] = $allotmentid;
                $pdate['allotmentno'] = $accountid;
                $pdate['accountNumber'] = $res->data->virtualVPA; //$res->data->accountNumben;
                // $pdata['ifsc'] = ""; //$res->data->ifsc;
                $pdate['status'] = 1;
                $pdate['updated_by'] = $this->employeeid;
                $pdate['updated_on'] = date('Y-m-d H:i:s');
                if ($virtual > 0) {
                    $this->updatewhere("virtualaccount", $pdate, "allotmentid = $allotmentid", 1);
                    $vid = $virtual;
                } else {
                    $pdate['added_on'] = date('Y-m-d H:i:s');
                    $pdate['added_by'] = $this->employeeid;
                    $vid = $this->insertnew("virtualaccount", $pdate, 1);
                }
                $this->creatqrcode($vid);
                return $vid; //$pdate['token'];

            }
            // print_r($atoken);

            if (FALSE === $output) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        } catch (Exception $e) {

            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }
    }

    function updateasset()
    {

        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        $url = "https://api-aertrak-india.aeris.com/api/fleet/assets";
        $token = $this->gettoken();

        try {
            $ch = curl_init($url);

            if (FALSE === $ch) {
                throw new Exception('failed to initialize');
            } else {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "token:" . $token));
                curl_setopt($ch, CURLOPT_TIMEOUT, 28000);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 28000);

                $output = curl_exec($ch);

                $res = json_decode($output);
                foreach ($res as $key => $value) {

                    $deviid = $value->deviceId;
                    if (substr($deviid, 0, 1) == 0 && strlen($deviid) == 16) {
                        $de = ltrim($deviid, 0);
                    } else {
                        $de = $deviid;
                    }
                    //             print_r($de);

                    $deviceid = $this->updatewhere("vehicles ", ["assetId" => $value->assetId, "assetUid" => $value->assetUid], "vehicles.deviceid in (select id from devices where (devices.deviceid='$de' or devices.deviceid='$deviid') and status=1) and vehicles.status=1");
                }
            }

            return $output;
            if (FALSE === $output) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        } catch (Exception $e) {

            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }
    }

    function updatebattery($vehicleid, $vehiclename, $vin, $licenseplate, $deviceid, $sclid)
    {
        $datapost = array(
            "id" => $vehicleid,
            "name" => $vehiclename,
            "vin" => $vin,
            "licensePlate" => $licenseplate,
            "deviceId" => $deviceid
        );
        // echo "<pre>";
        // print_r($datapost);die;
        $url = "https://api-aertrak-india.aeris.com/api/fleet/assets/$sclid";
        $token = $this->gettoken();
        // print_r($datapost);
        // die;
        try {
            $ch = curl_init($url);
            $data_string = json_encode($datapost);
            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            // $data = array("Authorization :" . "Bearer ".$token."", "Content-Type:" ."application/json");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "token:" . $token));
            curl_setopt($ch, CURLOPT_TIMEOUT, 28000);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 28000);

            $output = curl_exec($ch);
            $res = json_decode($output);
            // print_r($res);
            // if ($res->statusCode == 200 || $res->statusCode == 201) {
            //     $zz["assetUid"] = $res->sclId;
            //     $this->update("vehicles", $zz, $vehicle);
            //     $this->update("battery", $zz, $vehicle);
            // }
            // print_r($atoken);

            if (FALSE === $output) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        } catch (Exception $e) {

            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }
    }

    function checkasset($batteryno)
    {
        $assetmatch = false;
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        $url = "https://api-aertrak-india.aeris.com/api/fleet/assets";
        $token = $this->gettoken();

        try {
            $ch = curl_init($url);

            if (FALSE === $ch) {
                throw new Exception('failed to initialize');
            } else {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "token:" . $token));
                curl_setopt($ch, CURLOPT_TIMEOUT, 28000);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 28000);

                $output = curl_exec($ch);

                $res = json_decode($output);
                // echo "<pre>";
                // print_r($res);
                // echo "</pre>";
                // echo trim($chasis)."<br>";
                foreach ($res as $key => $value) {

                    $assetId = $value->assetId;
                    if (trim($assetId) ==  trim($batteryno)) {
                        $assetmatch = true;
                        $deviceid = $this->updatewhere("vehicles ", ["assetUid" => $value->assetUid], "vehicles.assetId = '$assetId' and vehicles.status=1");
                        $deviceid = $this->updatewhere("battery ", ["assetUid" => $value->assetUid], "battery.assetId = '$assetId' and battery.status=1");
                        // if(!empty($value->deviceId)){
                        // }
                    }
                    // else {
                    //     $de = $deviid;
                    // }
                    //             print_r($de);


                }
                return $assetmatch;
            }
            if (FALSE === $output) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        } catch (Exception $e) {

            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }
    }

    function createasset($vehicleid, $vehiclename, $vin, $licenseplate, $deviceid, $vehicle, $batterypid)
    {
        $datapost = array(
            "id" => $vehicleid,
            "name" => $vehiclename,
            "vin" => $vin,
            "licensePlate" => $licenseplate,
            "deviceId" => $deviceid
        );

        $url = "https://api-aertrak-india.aeris.com/api/fleet/assets";
        $token = $this->gettoken();
        // print_r($datapost);
        // die;
        try {
            $ch = curl_init($url);
            $data_string = json_encode($datapost);
            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            // $data = array("Authorization :" . "Bearer ".$token."", "Content-Type:" ."application/json");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "token:" . $token));
            curl_setopt($ch, CURLOPT_TIMEOUT, 28000);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 28000);

            $output = curl_exec($ch);
            $res = json_decode($output);
            // print_r($res);
            if ($res->statusCode == 200 || $res->statusCode == 201) {
                $zz["assetUid"] = $res->sclId;
                if (!empty($vehicle)) {
                    $this->update("vehicles", $zz, $vehicle);
                }
                $this->update("battery", $zz, $batterypid);
            }
            // print_r($atoken);

            if (FALSE === $output) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        } catch (Exception $e) {

            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }
    }

    function getcurrentlocation()
    {

        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        $url = "https://api-aertrak-india.aeris.com/v1.0/api/things/accounts/latestStatus";
        $token = $this->gettoken();

        try {
            $ch = curl_init($url);

            if (FALSE === $ch) {
                throw new Exception('failed to initialize');
            } else {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "token:" . $token));
                curl_setopt($ch, CURLOPT_TIMEOUT, 28000);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 28000);

                $output = curl_exec($ch);
            }

            return $output;
            if (FALSE === $output) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        } catch (Exception $e) {

            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }
    }
    function getlatestlocation($uid = "")
    {

        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        $url = "https://api-aertrak-india.aeris.com/v1.0/api/things/accounts/vehicle/latest-location";
        $token = $this->gettoken();
        $datapost = array(
            "dataFlag" => "LOCATION",

        );
        if (!empty($uid)) {

            $datapost['vehicleUid'] = $uid;
        }

        $data_string = json_encode($datapost);
        try {
            $ch = curl_init($url);

            if (FALSE === $ch) {
                throw new Exception('failed to initialize');
            } else {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "token:" . $token));
                curl_setopt($ch, CURLOPT_TIMEOUT, 28000);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 28000);

                $output = curl_exec($ch);
            }

            return $output;
            if (FALSE === $output) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        } catch (Exception $e) {

            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }
    }


    function gettoken()
    {

        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        $url = "https://api-aertrak-india.aeris.com/login";

        //data
        $data = array("username" => "aeris.operator+9015029@gmail.com", "password" => "Aeris123##");
        $date = date('Y-m-d H:i:s');
        $da = strtotime($date);
        $tokentime = $this->selectextrawhereupdate("token", "token,added_on", "status=1");
        $time = $this->fetch_assoc($tokentime);
        //        if($time)
        $t = date("Y-m-d H:i:s", strtotime("+28000 sec", strtotime($time['added_on'])));
        $da1 = strtotime($t);

        if ($da > $da1) {

            try {
                $ch = curl_init($url);
                $data_string = json_encode($data);

                if (FALSE === $ch)
                    throw new Exception('failed to initialize');

                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_string)));
                curl_setopt($ch, CURLOPT_TIMEOUT, 28000);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 28000);

                $output = curl_exec($ch);
                $res = json_decode($output);
                $atoken = $res->token;
                // print_r($atoken);

                $pdate['token'] = $atoken;
                $pdate['refresh_token'] = 28000;
                $pdate['status'] = 1;
                $pdate['added_on'] = date('Y-m-d H:i:s');
                $pdate['added_by'] = $this->employeeid;
                $pdate['updated_by'] = $this->employeeid;
                $pdate['updated_on'] = date('Y-m-d H:i:s');
                $pradin = $this->updatewhere("token", ['status' => 0], "status=1");
                if ($pradin) {
                    $pra = $this->insertnew("token", $pdate);
                    return $atoken;
                }
                if (FALSE === $output) {
                    throw new Exception(curl_error($ch), curl_errno($ch));
                }
            } catch (Exception $e) {

                trigger_error(
                    sprintf(
                        'Curl failed with error #%d: %s',
                        $e->getCode(),
                        $e->getMessage()
                    ),
                    E_USER_ERROR
                );
            }
        } else {
            return $time['token'];
        }
    }

    function updatetrip()
    {
        $deviceid = 1;
        $token = $this->gettoken();
        $data_json = json_encode($postData);
        $ch = curl_init();
        $startdate = date("Y-m-d", strtotime("-1 day"));
        $enddate = date("Y-m-d");
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api-aertrak-india.aeris.com/api/things/data/assets/trips?startDate=$startdate&endDate=$enddate",
            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'token: ' . $token),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        //get response
        $output = curl_exec($ch);
        if (curl_errno($ch)) {

            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
        $somearray = (json_decode($output));
        $i = 0;
        foreach ($somearray as $key => $newarray) {
            $x = array();
            $x = (array) $newarray;
            $x['added_on'] = date('Y-m-d H:i:s');
            $x['added_by'] = $this->employeeid;
            $x['updated_on'] = date('Y-m-d H:i:s');
            $x['updated_by'] = $this->employeeid;
            $x['status'] = 1;
            $result = $this->selectextrawhere("singletrip", "_id like '" . $x['_id'] . "'");
            $num = $this->total_rows($result);
            if (!$num) {
                $this->insertnew("singletrip", $x);
                $i++;
            }
        }
    }

    function getalerttypedata()
    {
        $deviceid = 1;
        $token = $this->gettoken();
        // $data_json = json_encode($postData);
        $ch = curl_init();
        $startdate = date("Y-m-d", strtotime("-1 day"));
        $enddate = date("Y-m-d");
        curl_setopt_array($ch, array(
            // CURLOPT_URL => "https://api-aertrak-india.aeris.com/api/things/accounts/alertaggregate?group=severity&startDate=$startdate&endDate=$enddate",
            CURLOPT_URL => "https://api-aertrak-india.aeris.com/api/things/accounts/alerts",

            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'token: ' . $token),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        //get response
        $output = curl_exec($ch);
        if (curl_errno($ch)) {

            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
        $somearray = (json_decode($output));
        $i = 0;
        return $somearray;
        // foreach ($somearray as $key => $newarray) {
        //     $x = array();
        //     $x = (array) $newarray;
        //     $x['added_on'] = date('Y-m-d H:i:s');
        //     $x['added_by'] = $this->employeeid;
        //     $x['updated_on'] = date('Y-m-d H:i:s');
        //     $x['updated_by'] = $this->employeeid;
        //     $x['status'] = 1;
        //     $result = $this->selectextrawhere("singletrip", "_id like '" . $x['_id'] . "'");
        //     $num = $this->total_rows($result);
        //     if (!$num) {
        //         $this->insertnew("singletrip", $x);
        //         $i++;
        //     }
        // }
    }

    function getalertdata($start, $end)
    {
        $deviceid = 1;
        $token = $this->gettoken();
        // $data_json = json_encode($postData);
        $ch = curl_init();
        if (!empty($start) && !empty($end)) {
            $startdate = $start;
            $enddate = $end;
        } else {
            $startdate = strtotime(date("Y-m-d 00:00:00", strtotime("-1 day"))) * 1000;
            $enddate = strtotime(date("Y-m-d 23:59:59")) * 1000;
        }
        curl_setopt_array($ch, array(
            // CURLOPT_URL => "https://api-aertrak-india.aeris.com/api/things/accounts/alertaggregate?group=severity&startDate=$startdate&endDate=$enddate",
            CURLOPT_URL => "https://api-aertrak-india.aeris.com/v1.0/api/things/assets/alerts?count=true&createdAfter=$startdate&createdBefore=$enddate",

            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'token: ' . $token),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        //get response
        $output = curl_exec($ch);
        if (curl_errno($ch)) {

            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
        $somearray = (json_decode($output));
        $i = 0;
        return $somearray;
    }

    function getassetspayload($start, $end, $assetuid)
    {
        $deviceid = 1;
        $token = $this->gettoken();
        // $data_json = json_encode($postData);
        $ch = curl_init();

        curl_setopt_array($ch, array(
            // CURLOPT_URL => "https://api-aertrak-india.aeris.com/api/things/accounts/alertaggregate?group=severity&startDate=$startdate&endDate=$enddate",
            CURLOPT_URL => "https://api-aertrak-india.aeris.com/api/fleet/assets/$assetuid/data?startDate=$start&endDate=$end",

            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'token: ' . $token),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        //get response
        $output = curl_exec($ch);
        if (curl_errno($ch)) {

            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
        $somearray = (json_decode($output));
        $i = 0;
        return $somearray;
    }

    function immobilize($devi)
    {

        $deviceid = $this->selectfieldwhere("devices inner join deviceallotment on deviceallotment.deviceid=devices.id and deviceallotment.vehicleid='" . $devi . "' and deviceallotment.status=1", "devices.deviceid", "1");
        $token = $this->gettoken();
        $postData = array(
            'request' => "SET_IMMOBILIZE",
            'deviceId' =>  $deviceid,
            "smsContentType" => 'english'
        );
        $data_json = json_encode($postData);
        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api-aertrak-india.aeris.com/api/v1/things/command/immobilization",
            //CURLOPT_URL =>"https://api-aertrak-india.aeris.com/api/things/data/assets/trips/daily?startDate=2022-01-01&endDate=2022-05-27",
            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'token: ' . $token),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data_json,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));

        //get response

        $output = curl_exec($ch);

        //Print error if any

        if (curl_errno($ch)) {

            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);
        $somearray = (json_decode($output));

        return $somearray;
    }

    function reimmobilize($devi)
    {

        $deviceid = $this->selectfieldwhere("devices inner join deviceallotment on deviceallotment.deviceid=devices.id and deviceallotment.vehicleid='" . $devi . "' and deviceallotment.status=1", "devices.deviceid", "1");
        $token = $this->gettoken();
        $postData = array(
            'request' => "RESET_IMMOBILIZE",
            'deviceId' =>  $deviceid,
            "smsContentType" => 'english'
        );
        $data_json = json_encode($postData);
        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api-aertrak-india.aeris.com/api/v1/things/command/immobilization",
            //CURLOPT_URL =>"https://api-aertrak-india.aeris.com/api/things/data/assets/trips/daily?startDate=2022-01-01&endDate=2022-05-27",
            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'token: ' . $token),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data_json,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));

        //get response

        $output = curl_exec($ch);

        //Print error if any

        if (curl_errno($ch)) {

            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);
        $somearray = (json_decode($output));

        return $somearray;
    }

    function checkstatus($devi)
    {

        $deviceid = $this->selectfieldwhere("vehicles", "assetUid", "id='" . $devi . "'");
        $token = $this->gettoken();

        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api-aertrak-india.aeris.com/api/fleet/vehicles/" . $deviceid . "/commandData",
            //CURLOPT_URL =>"https://api-aertrak-india.aeris.com/api/things/data/assets/trips/daily?startDate=2022-01-01&endDate=2022-05-27",
            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'token: ' . $token),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));

        //get response

        $output = curl_exec($ch);

        //Print error if any

        if (curl_errno($ch)) {

            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);
        $somearray = (json_decode($output));
        //        if("")

        return $somearray;
        //        return $somearray->data->response;
    }


    function notifysms($mobileno, $templateid, $message)
    {

        $url = "http://sms.mobinama.com/http-tokenkeyapi.php?authentic-key=3537657361766172693130301660801567&senderid=ESAREN&route=1&unicode=2&number=" . $mobileno . "&message=" . urlencode($message) . "&templateid=$templateid";
        // echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //           $ch = curl_init($url."?".$fields);
        echo $output = curl_exec($ch);
        //Print error if any
        curl_close($ch);
        return $output;
    }

    function getexchangerate()
    {
        $from_currency = 'USD';
        $to_currency = 'INR';
        $api_key = AVAPIKEY;
        $exchange_rate_url = 'https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency=' . $from_currency . '&to_currency=' . $to_currency . '&apikey=' . $api_key;

        // Set up cURL for the exchange rate
        $exchange_rate_ch = curl_init();

        // Set the URL and other options for the exchange rate
        curl_setopt($exchange_rate_ch, CURLOPT_URL, $exchange_rate_url);
        curl_setopt($exchange_rate_ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request and get the response for the exchange rate
        $exchange_rate_response = curl_exec($exchange_rate_ch);

        // Close the cURL handle for the exchange rate
        curl_close($exchange_rate_ch);

        // Decode the JSON response for the exchange rate
        $exchange_rate_data = json_decode($exchange_rate_response, true);

        // Extract the exchange rate from the response
        $exchange_rate = $exchange_rate_data['Realtime Currency Exchange Rate']['5. Exchange Rate'];
        return $exchange_rate;
    }

    function searchstockapi($symbol, $exchtype, $expiry, $strike)
    {
        $headArry = array(
            'appName' => APP_NAME,
            'appVer' => APP_VERSION,
            'key' => KEY,
            'osName' => OS_NAME,
            'requestCode' => '5PMF',
            'userId' => USER_ID,
            'password' => PASSWORD,
        );

        $subArray = array(
            ["Exch" => "N", "ExchType" => $exchtype, "Symbol" => "$symbol", "Expiry" => $expiry, "StrikePrice" => $strike, "OptionType" => ""],
            ["Exch" => "B", "ExchType" => $exchtype, "Symbol" => "$symbol", "Expiry" => $expiry, "StrikePrice" => $strike, "OptionType" => ""],
        );

        $bodyArry = array(
            'Count' => 1,
            'MarketFeedData' => $subArray,
            'ClientLoginType' => 0,
            'LastRequestTime' => '/Date(0)/',
            'RefreshRate' => 'H',
        );

        $requestData = array("head" => $headArry, "body" => $bodyArry);

        $data_string = json_encode($requestData);

        $ch = curl_init('https://openapi.5paisa.com/VendorsAPI/Service1.svc/MarketFeed');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
            )
        );

        $result = curl_exec($ch);
        $result = json_decode($result, true);
        curl_close($ch);
        return $result;
    }

    function searchstockapiwithtoken($symbol, $exchtype, $exch)
    {
        try {
            $accesstoken = $this->selectfieldwhere('token', 'accesstoken', 'status=1');
            $url = "https://Openapi.5paisa.com/VendorsAPI/Service1.svc/V1/MarketDepth";
            $authorization = "Bearer $accesstoken";
            $contentType = "application/json";

            $subArray = array(
                ["Exchange" => $exch, "ExchangeType" => $exchtype, "Symbol" => "$symbol"],
            );
            $data = array(
                "head" => array(
                    "key" => KEY
                ),
                "body" => array(
                    "ClientCode" => CLIENT_CODE,
                    "Count" => "1",
                    "Data" => $subArray
                )
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: " . $authorization,
                "Content-Type: " . $contentType
            ));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            $res = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($res, true);
            if (isset($response['body']['Data'])) {
                return $response['body']['Data'];
            } else {
                throw new Exception('Error fetching candle data:');
            }
        } catch (Exception $e) {
            // Log or handle the error as required
            return $e->getMessage();
        }
    }

    function marketstatus()
    {
        try {

            $accesstoken = $this->selectfieldwhere('token', 'accesstoken', 'status=1');
            $url = 'https://Openapi.5paisa.com/VendorsAPI/Service1.svc/MarketStatus';

            $headers = array(
                "Authorization: bearer $accesstoken",
                'Content-Type: application/json'
            );

            $data = array(
                'head' => array(
                    'key' => KEY
                ),
                'body' => array(
                    'ClientCode' => CLIENT_CODE
                )
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $res = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($res, true);
            if (isset($response['body']['Data'])) {
                return $response['body']['Data'];
            } else {
                throw new Exception('Error fetching:');
            }
        } catch (Exception $e) {
            // Log or handle the error as required
            return $e->getMessage();
        }
    }

    function getaccesstoken()
    {

        $url = 'https://Openapi.5paisa.com/VendorsAPI/Service1.svc/V1/GetAccessToken';
        $vendorKey = KEY;
        $requestToken = REQUEST_TOKEN;

        $data = array(
            'head' => array('key' => $vendorKey),
            'body' => array('RequestToken' => $requestToken)
        );

        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string),
                'Cookie: 5paisacookie=fiuy51p0l4ttftse2o1oxt4t; NSC_JOh0em50e1pajl5b5jvyafempnkehc3=ffffffffaf103e0f45525d5f4f58455e445a4a423660'
            )
        );

        $response = curl_exec($ch);
        curl_close($ch);

        $res =  json_decode($response);
        // print_r($res);
        $atoken = $res->body->AccessToken;
        $pdate['accesstoken'] = $atoken;
        $pdate['status'] = 1;
        $pdate['added_on'] = date('Y-m-d H:i:s');
        $pdate['added_by'] = $this->employeeid;
        $pdate['updated_by'] = $this->employeeid;
        $pdate['updated_on'] = date('Y-m-d H:i:s');
        $pdate['userid'] = $this->employeeid;
        $pradin = $this->updatewhere("token", ['status' => 0], "status=1");
        if ($pradin) {
            if (!empty($pdate['accesstoken'])) {
                $pra = $this->insertnew("token", $pdate);
            }
            return $atoken;
        }
    }

    function getfullmarketdepth($symboldata)
    {
        try {
            $accesstoken = $this->selectfieldwhere('token', 'accesstoken', 'status=1');
            $url = "https://Openapi.5paisa.com/VendorsAPI/Service1.svc/V1/MarketDepth";
            $authorization = "Bearer $accesstoken";
            $contentType = "application/json";

            $data = array(
                "head" => array(
                    "key" => KEY
                ),
                "body" => array(
                    "ClientCode" => CLIENT_CODE,
                    "Count" => "1",
                    "Data" => $symboldata
                    // "Data" => array(
                    //     array(
                    //         "Exchange" => "N",
                    //         "ExchangeType" => "C",
                    //         "Symbol" => "RELIANCE"
                    //     ),
                    // )
                )
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: " . $authorization,
                "Content-Type: " . $contentType
            ));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            $res = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($res, true);
            if (isset($response['body']['Data'])) {
                return $response['body']['Data'];
            } else {
                throw new Exception('Error fetching candle data: ' . $response['Message']);
            }
        } catch (Exception $e) {
            // Log or handle the error as required
            return $e->getMessage();
        }
    }

    function getcandledata($scriptcode, $exch, $type, $interval, $startdate, $enddate)
    {
        try {
            $accesstoken = $this->selectfieldwhere('token', 'accesstoken', 'status=1');
            $url = 'https://openapi.5paisa.com/historical/' . $exch . '/' . $type . '/' . $scriptcode . '/' . $interval . '';
            $subscriptionKey = KEY;
            $clientCode = CLIENT_CODE;
            $accessToken = $accesstoken;
            $from = $startdate;
            $end = $enddate;

            $queryString = http_build_query(array('from' => $from, 'end' => $end));
            $url = $url . '?' . $queryString;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Ocp-Apim-Subscription-Key: ' . $subscriptionKey,
                    'x-clientcode: ' . $clientCode,
                    'x-auth-token: ' . $accessToken
                )
            );

            $res = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($res, true);
            if (isset($response['data'])) {
                return $response['data'];
            } else {
                throw new Exception('Error fetching candle data:');
            }
        } catch (Exception $e) {
            // Log or handle the error as required
            return $e->getMessage();
        }
    }

    function fivepaisaapi($userstock)
    {
        try {
            $headArry = array(
                'appName' => APP_NAME2,
                'appVer' => APP_VERSION,
                'key' => KEY2,
                'osName' => OS_NAME,
                'requestCode' => '5PMF',
                'userId' => USER_ID2,
                'password' => PASSWORD2,
            );

            $subArray = $userstock;
            // array(
            //     ["Exch" => "N", "ExchType" => "C", "Symbol" => "BHEL", "Expiry" => "", "StrikePrice" => "0", "OptionType" => ""], ["Exch" => "N", "ExchType" => "C", "Symbol" => "RELIANCE", "Expiry" => "", "StrikePrice" => "0", "OptionType" => ""],
            //     ["Exch" => "N", "ExchType" => "C", "Symbol" => "AXISBANK", "Expiry" => "", "StrikePrice" => "0", "OptionType" => ""]
            // );
            $bodyArry = array(
                'Count' => 1,
                'MarketFeedData' => $subArray,
                'ClientLoginType' => 0,
                'LastRequestTime' => '/Date(0)/',
                'RefreshRate' => 'H',
            );
            $requestData = array("head" => $headArry, "body" => $bodyArry);

            $data_string = json_encode($requestData);

            $ch = curl_init('https://openapi.5paisa.com/VendorsAPI/Service1.svc/MarketFeed');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                )
            );

            $result = curl_exec($ch);
            // echo "testing API";
            // print_r($result);
            $result = json_decode($result, true);
            if (isset($result['body']['Data'])) {
                return $result['body']['Data'];
            } else {
                throw new Exception('Error fetching candle data:');
            }
        } catch (Exception $e) {
            // Log or handle the error as required
            return $e->getMessage();
        }
    }

    function fivepaisaapi3($userstock)
    {
        echo APP_NAME3;
        try {
            $headArry = array(
                'appName' => APP_NAME3,
                'appVer' => APP_VERSION,
                'key' => KEY3,
                'osName' => OS_NAME,
                'requestCode' => '5PMF',
                'userId' => USER_ID3,
                'password' => PASSWORD3,
            );

            $subArray = $userstock;
            // array(
            //     ["Exch" => "N", "ExchType" => "C", "Symbol" => "BHEL", "Expiry" => "", "StrikePrice" => "0", "OptionType" => ""], ["Exch" => "N", "ExchType" => "C", "Symbol" => "RELIANCE", "Expiry" => "", "StrikePrice" => "0", "OptionType" => ""],
            //     ["Exch" => "N", "ExchType" => "C", "Symbol" => "AXISBANK", "Expiry" => "", "StrikePrice" => "0", "OptionType" => ""]
            // );
            $bodyArry = array(
                'Count' => 1,
                'MarketFeedData' => $subArray,
                'ClientLoginType' => 0,
                'LastRequestTime' => '/Date(0)/',
                'RefreshRate' => 'H',
            );
            $requestData = array("head" => $headArry, "body" => $bodyArry);

            $data_string = json_encode($requestData);

            $ch = curl_init('https://openapi.5paisa.com/VendorsAPI/Service1.svc/MarketFeed');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                )
            );

            $result = curl_exec($ch);
            echo "testing API";
            print_r($result);
            $result = json_decode($result, true);
            echo "----";

            var_dump($result);
            if (isset($result['body']['Data'])) {
                return $result['body']['Data'];
            } else {
                throw new Exception('Error fetching candle data:');
            }
        } catch (Exception $e) {
            // Log or handle the error as required
            return $e->getMessage();
        }
    }

    function testapi()
    {
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'http://dummyjson.com/products/1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request and store the response
        $response = curl_exec($ch);
        print_r($response);
        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        // Output the API response
        echo $response;
    }

    function fivepaisaapi2($userstock)
    {
        try {
            $headArry = array(
                'appName' => APP_NAME,
                'appVer' => APP_VERSION,
                'key' => KEY,
                'osName' => OS_NAME,
                'requestCode' => '5PMF',
                'userId' => USER_ID,
                'password' => PASSWORD,
            );

            $subArray = $userstock;
            // array(
            //     ["Exch" => "N", "ExchType" => "C", "Symbol" => "BHEL", "Expiry" => "", "StrikePrice" => "0", "OptionType" => ""], ["Exch" => "N", "ExchType" => "C", "Symbol" => "RELIANCE", "Expiry" => "", "StrikePrice" => "0", "OptionType" => ""],
            //     ["Exch" => "N", "ExchType" => "C", "Symbol" => "AXISBANK", "Expiry" => "", "StrikePrice" => "0", "OptionType" => ""]
            // );
            $bodyArry = array(
                'Count' => 1,
                'MarketFeedData' => $subArray,
                'ClientLoginType' => 0,
                'LastRequestTime' => '/Date(0)/',
                'RefreshRate' => 'H',
            );
            $requestData = array("head" => $headArry, "body" => $bodyArry);

            $data_string = json_encode($requestData);

            $ch = curl_init('https://openapi.5paisa.com/VendorsAPI/Service1.svc/MarketFeed');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                )
            );

            $result = curl_exec($ch);
            // print_r($result);
            $result = json_decode($result, true);
            if (isset($result['body']['Data'])) {
                return $result['body']['Data'];
            } else {
                throw new Exception('Error fetching candle data:');
            }
        } catch (Exception $e) {
            // Log or handle the error as required
            return $e->getMessage();
        }
    }

    function getsmartapitoken()
    {

        $clientId = 'M884428';
        $clientPin = '7471';
        $totpCode = '750063';
        $apiKey = 'e1L5mgQQ';

        $data = json_encode([
            "clientcode" => $clientId,
            "password" => $clientPin,
            "totp" => $totpCode
        ]);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://apiconnect.angelbroking.com/rest/auth/angelbroking/user/v1/loginByPassword');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array(
            'Content-Type: application/json',
            'Accept: application/json',
            'X-UserType: USER',
            'X-SourceID: WEB',
            'X-ClientLocalIP: CLIENT_LOCAL_IP',
            'X-ClientPublicIP: CLIENT_PUBLIC_IP',
            'X-MACAddress: MAC_ADDRESS',
            'X-PrivateKey: ' . $apiKey
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }

        curl_close($ch);

        echo $response;
    }

    function fetchsmartapi()
    {
        $data = json_encode([
            "exchange" => "MCX",
            "tradingsymbol" => "SILVER",
            "symboltoken" => "250741"

        ]);
        $accesstoken = $this->selectfieldwhere('token', 'smartapitoken', 'status=1');
        // echo $accesstoken;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiconnect.angelbroking.com/order-service/rest/secure/angelbroking/order/v1/getLtpData',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $accesstoken",
                'Content-Type: application/json',
                'Accept: application/json',
                'X-UserType: USER',
                'X-SourceID: WEB',
                'X-ClientLocalIP: CLIENT_LOCAL_IP',
                'X-ClientPublicIP: CLIENT_PUBLIC_IP',
                'X-MACAddress: MAC_ADDRESS',
                'X-PrivateKey: e1L5mgQQ'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    function fetchsmartapi2()
    {
        $data = json_encode([
            "mode" => "LTP",
            "exchangeTokens" => [
                "NSE" => [
                    "5097",
                    "3045",
                ],
            ]
        ]);
        $accesstoken = $this->selectfieldwhere('token', 'smartapitoken', 'status=1');
        // echo $accesstoken;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiconnect.angelbroking.com/rest/secure/angelbroking/market/v1/quote/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $accesstoken",
                'Content-Type: application/json',
                'Accept: application/json',
                'X-UserType: USER',
                'X-SourceID: WEB',
                'X-ClientLocalIP: CLIENT_LOCAL_IP',
                'X-ClientPublicIP: CLIENT_PUBLIC_IP',
                'X-MACAddress: MAC_ADDRESS',
                'X-PrivateKey: e1L5mgQQ'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo "<pre>";
            print_r(json_decode($response));
        }
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

    /* Default db operation start */

    function login($tb_name, $email_p, $password_p, $email_name, $password_name)
    {
        session_start();
        $sql = "select * from $tb_name where $email_name='$email_p'";
        $result = $this->execute($sql);
        $row = $this->fetch_assoc($result);
        $data = $this->total_rows($result);
        if ($data > 0) {
            if ($row[$password_name] = md5($password_p)) {
                echo $logid = $row["id"];
                $_SESSION["userid"] = $logid;
                $_SESSION['username'] = $row['username'];
                header("location:login.php?msg=error_noerror");
            } else {
                header("location:login.php?msg=error_wrong");
            }
        } else {
            header("location:login.php?msg=error_nouser");
        }
    }

    function findmanager($userid)
    {
        $department = $this->selectfield('employeecompletion', 'department', 'userid', $userid);
        $result = $this->selectextrawhere('companystructure', "department=$department and parentid=0");
        $manager = array();
        while ($row = $this->fetch_assoc($result)) {
            $manager[] .= $row['id'];
        }
        $mgr = implode(",", $manager);
        $mngrs = array();
        $result1 = $this->selectextrawhere('employeecompletion', "postappointed in($mgr) and active=1");
        while ($rows = $this->fetch_assoc($result1)) {
            $mngrs[$rows['userid']] = $rows['email'];
        }
        return $mngrs;
    }

    function findmanagerid($userid)
    {
        $department = $this->selectfield('employeecompletion', 'department', 'userid', $userid);
        $result = $this->selectextrawhere('companystructure', "department=$department and parentid=0");
        $manager = array();
        while ($row = $this->fetch_assoc($result)) {
            $manager[] .= $row['id'];
        }
        $mgr = implode(",", $manager);
        $result1 = $this->selectextrawhere('employeecompletion', "postappointed in($mgr) and active=1");
        while ($rows = $this->fetch_assoc($result1)) {
            $mngrs[$rows['userid']] = $rows['userid'];
        }
        return $mngrs;
    }

    function findmanagerdepartment($departmentid)
    {
        $result = $this->selectextrawhere('companystructure', "department=$departmentid and parentid=0");
        // echo $result;
        $manager = array();
        while ($row = $this->fetch_assoc($result)) {
            $manager[] .= $row['id'];
            // echo $row['id'];
        }
        $mgr = implode(",", $manager);
        // echo $mgr."<br/>";
        $result1 = $this->selectextrawhere('employeecompletion', "postappointed in($mgr) and active=1");
        while ($rows = $this->fetch_assoc($result1)) {
            $mngrs[$rows['userid']] = $rows['userid'];
        }
        //print_r($mngrs);
        return $mngrs;
        //  return 1;
    }

    function alldepartmentheadid()
    {
        $result = $this->selectextrawhere('companystructure', " parentid=0");
        // echo $result;
        $manager = array();
        while ($row = $this->fetch_assoc($result)) {
            $manager[] .= $row['id'];
            // echo $row['id'];
        }
        $mgr = implode(",", $manager);
        // echo $mgr."<br/>";
        $result1 = $this->selectextrawhere('employeecompletion', "postappointed in($mgr) and active=1");
        while ($rows = $this->fetch_assoc($result1)) {
            $mngrs[$rows['userid']] = $rows['userid'];
        }
        //print_r($mngrs);
        return $mngrs;
    }

    function getEmployeeName($id)
    {
        $result = $this->selectextrawhere("user", " id=$id");
        $row = $this->fetch_assoc($result);
        return $row['name'] . "(" . $row['employeecode'] . ")";
    }

    /**
     * @return int
     */
    function getinsertData($tb_name, $postdata)
    {
        foreach ($postdata as $key => $value) {
            $tbl[$key] = $key;
            $postdata[$key] = $this->escape($value);
        }
        $tbl_coloumn_name = array(implode('`, `', $tbl));
        $tbl_data = array(implode("', '", $postdata));
        $tb_col_name1 = "`" . implode("`, `", $tbl_coloumn_name) . "`";
        $form_field1 = implode("', '", $tbl_data);
        $sql = "('$form_field1')";

        return $sql;
    }

    function approve($tb_name, $id)
    {
        $sql = "update `$tb_name` set status=1 where `id`='$id' ";
        if ($this->execute($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    function deletewhere($tb_name, $where, $print = 0)
    {
        $sql = "update`$tb_name` set status=99, updated_on = Now(), updated_by = " . $this->employeeid . " where $where";
        //        $sql = "delete from `$tb_name` where $where ";
        if ($this->execute($sql, $print)) {
            return 1;
        } else {
            return 0;
        }
    }

    function deletein($tb_name, $id)
    {
        $sql = "update`$tb_name` set status=99 where `id` in '$id' ";
        //        $sql = "delete from `$tb_name` where `id` in '$id' ";
        if ($this->execute($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    function deletefile($path)
    {
        if (file_exists($path)) {
            if (unlink($path)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 1;
        }
    }

    function search($tb_name, $tb_col_name)
    {
        $sql = "select * from $tb_name where $tb_col_name like '%" . $_POST["search"] . "%'";
        $result = $this->execute($sql);
        return $result;
    }

    function check_login()
    {
        if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
            $employeeid = $_SESSION['username'];
        } else {

            header('location:login');
        }
    }

    function check_activate()
    {
        $activate = $this->selectfieldwhere("users", "activate", "id=" . $this->employeeid . "");
        if (!empty($activate) && $activate === 'No') {
            header("location:logout");
            $this->logout();
        }
    }

    function logout()
    {

        setcookie('userData', '', time() - 3600, '/');
        session_destroy();
    }

    function createCache($tablename)
    {
        $data = array();
        $result = $this->selecttable("$tablename");
        while ($row = $this->fetch_assoc($result)) {
            $data[$row['id']] = $row['description'];
        }

        $fp = fopen("cache/$tablename.json", 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);
    }

    function uploadimage($path, $image, $name)
    {
        $imagename = "";
        // print_r($image);
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $image[$name]["name"]);
        $exte = end($temp);
        $extension = strtolower($exte);
        if (in_array($extension, $allowedExts)) {
            if (($image[$name]["size"] < 600000000)) {

                if ((($image[$name]["type"] == "image/gif") || ($image[$name]["type"] == "image/jpeg") || ($image[$name]["type"] == "image/jpg") || ($image[$name]["type"] == "image/pjpeg") || ($image[$name]["type"] == "image/x-png") || ($image[$name]["type"] == "image/png"))) {
                    if ($image[$name]["error"] > 0) {

                        return "Return Code: " . $image[$name]["error"] . "<br>";
                    } else {
                        $imgname = time() . chr(rand(65, 90)) . chr(rand(97, 122)) . chr(rand(65, 90)) . "." . $extension;
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        if (file_exists($path . "/" . $image[$name]["name"])) {

                            $imagename = $path . "/" . $imgname;
                            if (move_uploaded_file($image["$name"]["tmp_name"], $imagename)) {
                                $x['filename'] = $imgname;
                                $x['orgname'] = $image[$name]["name"];
                                $x['uploadedby'] = $_SESSION['calitechemployee'];
                                $x['uploadedon'] = date("Y-m-d H:i:s");
                                $x['path'] = $imagename;
                                $x['status'] = 1;
                                $this->insertnew("uploadfile", $x);
                                return $imagename;
                            }
                        } else {
                            $imagename = $path . "/" . $imgname;
                            if (move_uploaded_file($image[$name]["tmp_name"], $imagename)) {
                                $x['filename'] = $imgname;
                                $x['orgname'] = $image[$name]["name"];
                                $x['uploadedby'] = $_SESSION['calitechemployee'];
                                $x['uploadedon'] = date("Y-m-d H:i:s");
                                $x['path'] = $imagename;
                                $x['status'] = 1;
                                print_r($x);
                                $this->insertnew("uploadfile", $x);
                                return $imagename;
                            }
                        }
                    }
                } else {
                    return " Invalid file Please Resave file";
                }
            } else {
                echo ' Invalid File gif,jpeg,png,jpg files allowed';
            }
        } else {
            echo ' Invalid File file size not more then 500MB';
        }
    }

    function uploadfilenew($path, $image, $name, $allowedext, $savename = "")
    {
        $imagename = "";
        // print_r($image);
        $allowedExts = $allowedext;
        $temp = explode(".", $image[$name]["name"]);
        $exte = end($temp);
        $extension = strtolower($exte);
        if (($image[$name]["size"] < 600000000)) {
            if (in_array($extension, $allowedExts)) {
                if ($image[$name]["error"] > 0) {
                    return "Return Code: " . $image[$name]["error"] . "<br>";
                } else {
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $imgname = $savename . "." . $extension;
                    if (empty($savename)) {
                        $imgname = time() . chr(rand(65, 90)) . chr(rand(97, 122)) . chr(rand(65, 90)) . "." . $extension;
                    }
                    if (file_exists($path . "/" . $image[$name]["name"])) {
                        $imagename = $path . "/" . $imgname;
                        echo move_uploaded_file($image["$name"]["tmp_name"], $imagename);
                        if (move_uploaded_file($image["$name"]["tmp_name"], $imagename)) {
                            $x['filename'] = $imgname;
                            $x['orgname'] = $image[$name]["name"];
                            $x['updated_by'] = $this->employeeid;
                            $x['updated_on'] = date("Y-m-d H:i:s");
                            $x['path'] = $imagename;
                            $x['status'] = 1;
                            //print_r($x);
                            $id = $this->insertnew("uploadfile", $x);
                            return $id;
                        }
                    } else {
                        $imagename = $path . "/" . $imgname;
                        if (move_uploaded_file($image[$name]["tmp_name"], $imagename)) {
                            $x['filename'] = $imgname;
                            $x['orgname'] = $image[$name]["name"];
                            $x['updated_by'] = $this->employeeid;
                            $x['updated_on'] = date("Y-m-d H:i:s");
                            $x['path'] = $imagename;
                            $x['status'] = 1;
                            $id = $this->insertnew("uploadfile", $x);
                            return $id;
                        }
                    }
                }
            } else {

                echo ' Invalid File gif,jpeg,png,jpg files allowed';
                return "Invalid File";
            }
        } else {
            echo ' Invalid File file size not more then 500MB';
            return "Invalid File";
        }
    }

    function uploadmultiple($path, $image, $name, $allowedext)
    {
        $imagename = "";
        // print_r($image);
        $allowedExts = $allowedext;
        $imagesarray = array();
        foreach ($image[$name]["tmp_name"] as $key => $tmp_name) {
            $temp = explode(".", $image[$name]["name"][$key]);
            $exte = end($temp);
            $extension = strtolower($exte);
            if (($image[$name]["size"][$key] < 600000000)) {
                if (in_array($extension, $allowedExts)) {
                    if ($image[$name]["error"][$key] > 0) {
                        return "Return Code: " . $image[$name]["error"][$key] . "<br>";
                    } else {
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        $imgname = time() . chr(rand(65, 90)) . chr(rand(97, 122)) . chr(rand(65, 90)) . "." . $extension;
                        if (file_exists($path . "/" . $image[$name]["name"][$key])) {
                            $imagename = $path . "/" . $imgname;
                            if (move_uploaded_file($image["$name"]["tmp_name"][$key], $imagename)) {
                                $x['filename'] = $imgname;
                                $x['orgname'] = $image[$name]["name"][$key];
                                $x['uploadedby'] = $_SESSION['calitechemployee'];
                                $x['uploadedon'] = date("Y-m-d H:i:s");
                                $x['path'] = $imagename;
                                $x['status'] = 1;
                                $id = $this->insertnew("uploadfile", $x);
                                $imagesarray[] .= $id;
                            }
                        } else {
                            $imagename = $path . "/" . $imgname;
                            if (move_uploaded_file($image[$name]["tmp_name"][$key], $imagename)) {
                                $x['filename'] = $imgname;
                                $x['orgname'] = $image[$name]["name"][$key];
                                $x['updatedby'] = $_SESSION['calitechemployee'];
                                $x['updatedon'] = date("Y-m-d H:i:s");
                                $x['path'] = $imagename;
                                $x['status'] = 1;
                                $id = $this->insertnew("uploadfile", $x);
                                $imagesarray[] .= $id;
                            }
                        }
                    }
                } else {
                    echo ' Invalid File gif,jpeg,png,jpg files allowed';
                }
            } else {
                echo ' Invalid File file size not more then 500MB';
            }
        }
        return implode(",", $imagesarray);
    }

    function uploadfile($path, $image, $name, $allowedext)
    {
        $imagename = "";
        // print_r($image);
        $allowedExts = $allowedext;
        $temp = explode(".", $image[$name]["name"]);
        $exte = end($temp);
        $extension = strtolower($exte);
        if (($image[$name]["size"] < 600000000)) {
            if (in_array($extension, $allowedExts)) {
                if ($image[$name]["error"] > 0) {
                    return "Return Code: " . $image[$name]["error"] . "<br>";
                } else {
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $imgname = time() . chr(rand(65, 90)) . chr(rand(97, 122)) . chr(rand(65, 90)) . "." . $extension;
                    if (file_exists($path . "/" . $image[$name]["name"])) {
                        $imagename = $path . "/" . $imgname;
                        if (move_uploaded_file($image["$name"]["tmp_name"], $imagename)) {
                            $x['filename'] = $imgname;
                            $x['orgname'] = $image[$name]["name"];
                            $x['uploadedby'] = $_SESSION['calitechemployee'];
                            $x['uploadedon'] = date("Y-m-d H:i:s");
                            $x['path'] = $imagename;
                            $x['status'] = 1;
                            $id = $this->insertnew("uploadfile", $x);
                            return $imagename;
                        }
                    } else {
                        $imagename = $path . "/" . $imgname;
                        if (move_uploaded_file($image[$name]["tmp_name"], $imagename)) {
                            $x['filename'] = $imgname;
                            $x['orgname'] = $image[$name]["name"];
                            $x['uploadedby'] = $_SESSION['calitechemployee'];
                            $x['uploadedon'] = date("Y-m-d H:i:s");
                            $x['path'] = $imagename;
                            $x['status'] = 1;
                            $id = $this->insertnew("uploadfile", $x);
                            return $imagename;
                        }
                    }
                }
            } else {
                echo ' Invalid File gif,jpeg,png,jpg files allowed';
            }
        } else {
            echo ' Invalid File file size not more then 500MB';
        }
    }

    function uploadfilesame($path, $image, $name, $allowedext)
    {
        $imagename = "";
        // print_r($image);
        $allowedExts = $allowedext;
        $temp = explode(".", $image[$name]["name"]);
        $exte = end($temp);
        $extension = strtolower($exte);
        if (($image[$name]["size"] < 600000000)) {
            if (in_array($extension, $allowedExts)) {
                if ($image[$name]["error"] > 0) {
                    return "Return Code: " . $image[$name]["error"] . "<br>";
                } else {
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $imgname = time() . chr(rand(65, 90)) . chr(rand(97, 122)) . chr(rand(65, 90)) . "." . $extension;
                    if (file_exists($path . "/" . $image[$name]["name"])) {
                        $imagename = $path . "/" . $imgname;
                        if (move_uploaded_file($image["$name"]["tmp_name"], $imagename)) {
                            $x['filename'] = $imgname;
                            $x['orgname'] = $image[$name]["name"];
                            $x['uploadedby'] = $_SESSION['calitechemployee'];
                            $x['uploadedon'] = date("Y-m-d H:i:s");
                            $x['path'] = $imagename;
                            $x['status'] = 1;
                            $this->insertnew("uploadfile", $x);
                            return $imagename;
                        }
                    } else {
                        $imagename = $path . "/" . $imgname;
                        if (move_uploaded_file($image[$name]["tmp_name"], $imagename)) {
                            $x['filename'] = $imgname;
                            $x['orgname'] = $image[$name]["name"];
                            $x['uploadedby'] = $_SESSION['calitechemployee'];
                            $x['uploadedon'] = date("Y-m-d H:i:s");
                            $x['path'] = $imagename;
                            $x['status'] = 1;
                            $this->insertnew("uploadfile", $x);
                            return $imagename;
                        }
                    }
                }
            } else {
                echo ' Invalid File gif,jpeg,png,jpg files allowed';
            }
        } else {
            echo ' Invalid File file size not more then 500MB';
        }
    }

    function sendnotification($playerid, $cname)
    {
        $authorization = 'Bearer MzBkY2Q0MGUtMzU4ZC00ZjVkLWFhN2ItZTUwZTc0MWVkMTJi';
        $content_type = 'application/json';

        $data = array(
            'app_id' => '8c7ea433-de47-448e-b9e4-67a1acea3503',
            'content_available' => true,
            'contents' => array(
                'en' => 'You have an Enquiry from ' . $cname
            ),
            'headings' => array(
                'en' => 'Dear Driver'
            ),
            'include_player_ids' => $playerid
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . $authorization,
            'Content-Type: ' . $content_type
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        // echo $response;
    }

    function getdatafromurl($url, $fields)
    {
        //API URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . "?" . $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //           $ch = curl_init($url."?".$fields);
        echo $output = curl_exec($ch);
        //Print error if any
        curl_close($ch);
        return $output;
    }



    public function saveucertantyctg($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid ");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "' ");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;

        $maxpoint = $this->selectfieldwhere("crfcalibrationpoint$tablesuffix", "max(cast(point as DECIMAL(10,3)))", "crfitemid='$instid'  and status=1");
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid  and status=1 and cast(point as DECIMAL(10,3)) ='$maxpoint' order by cast(point as DECIMAL(10,3)) desc limit 0,1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['masterunit']) && (!empty($rowcalibpoint['masterunit'])) && $rowcalibpoint['masterunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $this->unitconversion($rowcalibpoint['masterunit'], $rowcalibpoint['unit'], $rowmatrix['leastcount']);

            $masterunc = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(cmc*cmc))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
            $masterunc = $masterunc / 1000;
            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
            $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
            $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
            $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
            $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc'");

            $typea = ($repeatability / 1000) / sqrt(5);
            $leastcount = $rowmatrix['leastcount'] / 1000;
            $thermalcomaster = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffmaster' and repeatable=0");
            $thermalcouuc = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffuuc' and repeatable=0");
            $thermalcomaster = $thermalcomaster * pow(10, -6);
            $thermalcouuc = $thermalcouuc * pow(10, -6);
            $diffofthercoff = abs($thermalcouuc - $thermalcomaster);
            if ($diffofthercoff == 0) {
                $diffofthercoff = 0.000001;
            }
            $uncertaintytempdevice = 0;
            $resultsupportmastermatrix = $this->selectextrawhere("masterscopematrix", "certificateid in (" . $rowcalibpoint['supportvalidityid'] . ") and unit =12 and masterid in (select id from mminstrument where type like '357' and id in (" . $rowcalibpoint['supportmasterinstid'] . ")) and status=1 order by cmc desc");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $uncertaintytempdevice = $rowsupportmastermatrix['cmc'];
            }
            //2
            $uncertaintytempdevicemm = $averageuuc * $thermalcomaster * $uncertaintytempdevice / 1000;
            $stduncthercof20 = $averageuuc * $diffofthercoff * 2 * 0.2;
            $stduncdiffinmasuuc = $averageuuc * $diffofthercoff * 2 * 0.5;
            $uncduetoparalism = 0;

            $uncduetoerror = 0;
            $uncduetoerror = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(drift*drift))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
            $uncduetoerror = $uncduetoerror / 2000;
            $comuncer = SQRT(pow($typea, 2) + pow(($masterunc / 2), 2) + pow(($leastcount / 2 / SQRT(3)), 2) + pow(($uncertaintytempdevicemm / SQRT(3)), 2) + pow(($stduncthercof20 / SQRT(3)), 2) + pow(($stduncdiffinmasuuc / SQRT(3)), 2) + pow(($uncduetoparalism / SQRT(3)), 2) + pow(($uncduetoerror / SQRT(3)), 2));

            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor * 1000;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`)))  and location  like '" . $rowinwarditem['location'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantydg($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['masterunit']) && (!empty($rowcalibpoint['masterunit'])) && $rowcalibpoint['masterunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $scopeid = 0;
            $leastcount = $this->unitconversion($rowcalibpoint['masterunit'], $rowcalibpoint['unit'], $rowmatrix['leastcount']);
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
                $scopeid = $row2['id'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $scopeid = $row2['id'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }
            $masterunc = $masterunc / 1000;
            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='masterinc' and repeatable=0");
            $master1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='masterdec' and repeatable=0");
            $master2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='masterinc' and repeatable=1");
            $master3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='masterdec' and repeatable=1");
            $errorinc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='errorinc' and repeatable=0");
            $errordec = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='errordec' and repeatable=0");
            $husterisis = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='hysterisis' and repeatable=0");
            $averageinc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemasterinc' and repeatable=0");
            $averagedec = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemasterdec' and repeatable=0");
            $averageuuc = ($averageinc + $averagedec) / 2;
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and (type='masterinc' or type='masterdec')");
            $typea = $repeatability / sqrt(4);
            $leastcount = $rowmatrix['leastcount'];
            $thermalcomaster = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffmaster' and repeatable=0");
            $thermalcouuc = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffuuc' and repeatable=0");
            $thermalcomaster = $thermalcomaster * pow(10, -6);
            $thermalcouuc = $thermalcouuc * pow(10, -6);
            $uncertaintytempdevice = 0;
            $uncertaintytempdevicemm = $averageuuc * $thermalcomaster * $uncertaintytempdevice;
            $stduncthercof20 = $averageuuc * abs($thermalcouuc - $thermalcomaster) * 2 * 0.2;
            $stduncdiffinmasuuc = $averageuuc * abs($thermalcouuc - $thermalcomaster) * 2 * 0.5;

            $uncduetoerror = 0;
            $scopesearch = "id in (" . $rowcalibpoint['mastersopematrixid'] . ")";
            if (empty($rowcalibpoint['mastersopematrixid'])) {
                $scopesearch = "id in (" . $scopeid . ")";
            }

            $uncduetoerror = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(drift*drift))", "$scopesearch");
            $uncduetoerror = $uncduetoerror / 2000;
            $comuncer = SQRT(pow($typea, 2) + pow(($masterunc / 2), 2) + pow(($leastcount / 2 / SQRT(3)), 2) + pow(($uncertaintytempdevicemm / SQRT(3)), 2) + pow(($stduncthercof20 / SQRT(3)), 2) + pow(($stduncdiffinmasuuc / SQRT(3)), 2) + pow(($uncduetoerror / SQRT(3)), 2));

            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor * 1000;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`)))  and location  like '" . $rowinwarditem['location'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantydpg($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid ");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);
        $i = 1;
        $maxzeroerror = 0;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $masterunit = $rowcalibpoint['masterunit'];
            $testpoint = $rowcalibpoint['point'];

            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $leastcount = $rowmatrix['leastcount'];
            $masterleastcount = $rowmastermatrix['leastcount'];
            $lc = 0;

            if ($rowmatrix['leastcount'] != "NA") {
                $lc = 0;
                $temp1 = explode(".", $rowmatrix['leastcount']);
                if (count($temp1) > 1) {
                    $temp2 = end($temp1);
                    $lc = strlen($temp2);
                }
            } else {
                $lc = "NA";
            }

            $mlc = 0;
            if ($rowmastermatrix['leastcount'] != "NA") {

                $temp1 = explode(".", $rowmastermatrix['leastcount']);
                if (count($temp1) > 1) {
                    $temp2 = end($temp1);
                    $mlc = strlen($temp2);
                }
            } else {
                $mlc = "NA";
            }
            $mainlc = $lc;
            $mainmlc = $mlc;
            if (isset($masterunit) && (!empty($masterunit)) && $masterunit != $testunit) {
                $testunit = $masterunit;

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);

                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    $leastcount = $rowmatrix['leastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    //                $lc = 0;
                    //
                    //                if ($leastcount != "NA") {
                    //                    $lc = 0;
                    //                    $temp1 = explode(".", $leastcount);
                    //                    if (count($temp1) > 1) {
                    //                        $temp2 = end($temp1);
                    //                        $lc = strlen($temp2);
                    //                    }
                    //                } else {
                    //                    $lc = "NA";
                    //                }
                    $lc = $mlc;
                    $testpoint = sprintf("%.0" . $lc . "f", $testpoint);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                        $leastcount = $rowmatrix['leastcount'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                        //                    $lc = 0;
                        //                    echo $leastcount;
                        //                    if ($leastcount != "NA") {
                        //                        $lc = 0;
                        //                        $temp1 = explode(".", $leastcount);
                        //                        if (count($temp1) > 1) {
                        //                            $temp2 = end($temp1);
                        //                            $lc = strlen($temp2);
                        //                        }
                        //                    } else {
                        //                        $lc = "NA";
                        //                    }
                        $lc = $mlc;
                        $testpoint = sprintf("%.0" . $lc . "f", $testpoint);
                    }
                }
            }
            $masterunc = 0;
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }

            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
            $master1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=1");
            $master2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=2");
            $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='repeatability' and repeatable=0");
            $hysterisis = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='hysterisis' and repeatable=0");
            $zeropoint = $this->selectfieldwhere("crfcalibrationpoint$tablesuffix", "id", "crfitemid=$instid and point=0");

            $maxzeroerror = abs($master2 - $master1);

            if (!empty($zeropoint)) {
                $zerosql = "select ((select value from $summarytable where instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint='$zeropoint' and type='master' and repeatable=2) - (select value from $summarytable where instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint='$zeropoint' and type='master' and repeatable=1)) as zeroerror";
                $zeroresult = $this->execute($zerosql);
                $zerorow = $this->fetch_assoc($zeroresult);

                $maxzeroerror = abs($zerorow['zeroerror']);
            }

            $comuncer = sqrt(pow(($maxzeroerror / sqrt(3)), 2) + pow(($hysterisis / sqrt(3)), 2) + pow(($repeatability / sqrt(3)), 2) + pow(($leastcount / 2 / sqrt(3)), 2) + pow(($rowmastermatrix['uncertainty'] / 2), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`))) and mode='" . $rowcalibpoint['mastermode'] . "' and location  like '" . $rowinwarditem['location'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;
            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantydutm($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid ");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);
        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }
            $masterunc = $masterunc / 1000;
            if ($rowmatrix['leastcount'] != "NA") {
                $lc = 0;
                $temp1 = explode(".", $rowmatrix['leastcount']);
                if (count($temp1) > 1) {
                    $temp2 = end($temp1);
                    $lc = strlen($temp2);
                }
            } else {
                $lc = "NA";
            }

            $mlc = 0;
            if ($rowmastermatrix['leastcount'] != "NA") {

                $temp1 = explode(".", $rowmastermatrix['leastcount']);
                if (count($temp1) > 1) {
                    $temp2 = end($temp1);
                    $mlc = strlen($temp2);
                }
            } else {
                $mlc = "NA";
            }
            $leastcount = $rowmatrix['leastcount'];
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "'  order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);

                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if ($num2) {
                    if ($num3) {
                        $cmcunit = $row2['cmcunit'];
                        $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
                    } else {
                        $masterunc = $row2['cmc'];
                        $cmcunit = $row2['cmcunit'];
                    }
                } else {
                    if ($num3) {
                        $masterunc = $row3['cmc'];
                        $cmcunit = $row3['cmcunit'];
                    }
                }
            }
            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
            $master1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=1");
            $averagemaster = $this->selectfieldwhere("$summarytable", "avg(format(value,$mlc))", "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' ");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master'");

            $typea = $repeatability / sqrt(2);
            $comuncer = sqrt(pow($typea, 2) + pow(($masterunc) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $expandeduncertaintypercent = ($expandeduncertainty / $testpoint) * 100;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(`parameter`)) ");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantydw($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid ");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);
        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $repeatablecycle = (!empty($rowcalibpoint['repeatble'])) ? $rowcalibpoint['repeatble'] : 3;
            $typeaarray = array();
            for ($ri = 0; $ri < $repeatablecycle; $ri++) {
                $t1 = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and (type='uuca' or type='uucb') and repeatable='$ri'");
                $t2 = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and (type='mastera' or type='masterb') and repeatable='$ri'");

                $temptypea = (floatval($t1) + floatval($t2)) / 2;
                $typeaarray[] = $temptypea;
                //                  echo   $temptypea." = ".$t1." + ".$t2." / 2"."<br>";
            }
            $typea = max($typeaarray);
            $testunit = $rowcalibpoint['unit'];
            $masterunit = $rowcalibpoint['masterunit'];
            $testpoint = $rowcalibpoint['point'];

            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);

            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $leastcount = $rowmatrix['leastcount'];
            $masterleastcount = $this->selectfieldwhere("mastermatrix", "leastcount", "unit like '" . $rowcalibpoint['unit'] . "' and '" . $rowcalibpoint['point'] . "' between cast(calibratedrangemin as decimal(10,6)) and cast(calibratedrangemax as decimal(10,6))  and certificateid in (" . $rowcalibpoint['supportvalidityid'] . ") and masterid in (select id from mminstrument where id in (" . $rowcalibpoint['supportmasterinstid'] . ") and type like '359')");
            $lc = 0;

            if ($rowmatrix['leastcount'] != "NA") {
                $lc = 0;
                $temp1 = explode(".", $rowmatrix['leastcount']);
                if (count($temp1) > 1) {
                    $temp2 = end($temp1);
                    $lc = strlen($temp2);
                }
            } else {
                $lc = "NA";
            }

            $mlc = 0;
            if ($rowmastermatrix['leastcount'] != "NA") {

                $temp1 = explode(".", $rowmastermatrix['leastcount']);
                if (count($temp1) > 1) {
                    $temp2 = end($temp1);
                    $mlc = strlen($temp2);
                }
            } else {
                $mlc = "NA";
            }
            $mainlc = $lc;
            $mainmlc = $mlc;
            $leastcount = $rowmatrix['leastcount'];
            if (isset($masterunit) && (!empty($masterunit)) && $masterunit != $testunit) {
                $testunit = $masterunit;

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);

                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    $leastcount = $rowmatrix['leastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    //                $lc = 0;
                    //
                    //                if ($leastcount != "NA") {
                    //                    $lc = 0;
                    //                    $temp1 = explode(".", $leastcount);
                    //                    if (count($temp1) > 1) {
                    //                        $temp2 = end($temp1);
                    //                        $lc = strlen($temp2);
                    //                    }
                    //                } else {
                    //                    $lc = "NA";
                    //                }
                    $lc = $mlc;
                    $testpoint = sprintf("%.0" . $lc . "f", $testpoint);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                        $leastcount = $rowmatrix['leastcount'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                        //                    $lc = 0;
                        //                    echo $leastcount;
                        //                    if ($leastcount != "NA") {
                        //                        $lc = 0;
                        //                        $temp1 = explode(".", $leastcount);
                        //                        if (count($temp1) > 1) {
                        //                            $temp2 = end($temp1);
                        //                            $lc = strlen($temp2);
                        //                        }
                        //                    } else {
                        //                        $lc = "NA";
                        //                    }
                        $lc = $mlc;
                        $testpoint = sprintf("%.0" . $lc . "f", $testpoint);
                    }
                }
            }
            $masterunc = 0;
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }

            $refweightmass = $rowcalibpoint['point'];
            $averagedeltai = $this->selectfieldwhere("$summarytable", 'avg(value)', "instid=" . $instid . " and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='deltai' ");
            //            $stddev1 = $this->selectfieldwhere("");
            //            $stddev2 = $this->selectfieldwhere("");

            $densityofmaster = $this->selectfieldwhere("masterscopematrix", "density", "certificateid in (" . $rowcalibpoint['validityid'] . ") and id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
            $densityuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . " and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='density' and repeatable=0 ");
            $averagepressure = $this->selectfieldwhere("$summarytable", 'avg(value)', "instid=" . $instid . " and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='pressure' ");
            $averagetemp = ($rowinwarditem['temperature'] + $rowinwarditem['tempend']) / 2;
            $averagehumidity = ($rowinwarditem['humidity'] + $rowinwarditem['humiend']) / 2;

            $densityofair = (0.3484 * $averagepressure - 0.009 * $averagehumidity * EXP(0.061 * $averagetemp)) / (273.15 + $averagetemp) / 1000;
            $densityofairref = 0.0012;
            $volumeoftestweight = $rowcalibpoint['point'] / $densityuuc;
            $volumofref = $refweightmass / $densityofmaster;
            $airbyouncy = ($volumeoftestweight - $volumofref) * ($densityofair - $densityofairref);

            $mcr = $rowcalibpoint['point'] + $averagedeltai + $airbyouncy;
            //             echo " SQRT(pow(".$typea.", 2) + pow((".$masterleastcount." / 2 / SQRT(3)), 2) + pow(".$airbyouncy." / SQRT(3), 2) + pow((".$masterunc." / 2), 2))";
            $comuncer = SQRT(pow($typea, 2) + pow(($masterleastcount / 2 / SQRT(3)), 2) + pow($airbyouncy / SQRT(3), 2) + pow(($masterunc / 2), 2));
            $coveragefactor = 2;

            $expandeduncertainty = ($comuncer * $coveragefactor) * 1000;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`))) and mode='" . $rowcalibpoint['mastermode'] . "' and location  like '" . $rowinwarditem['location'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantyexm($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultunittype = $this->selectextrawhereupdate("crfmatrix$tablesuffix", "id,matrixtype", "crfitemid='$instid'  and status=1 group by matrixtype ");
        while ($rowunittype = $this->fetch_assoc($resultunittype)) {

            $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and matrixid='" . $rowunittype['id'] . "' and status=1 order by convert(point,DECIMAL) desc limit 0,1");
            while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
                $testunit = $rowcalibpoint['unit'];
                $testpoint = $rowcalibpoint['point'];
                if (isset($rowcalibpoint['masterunit']) && (!empty($rowcalibpoint['masterunit'])) && $rowcalibpoint['masterunit'] != $rowcalibpoint['unit']) {
                    $testunit = $rowcalibpoint['unit'];

                    $testpoint = $rowcalibpoint['point'];
                    $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                    if ($this->total_rows($resultconversion1)) {
                        $rowconversion1 = $this->fetch_assoc($resultconversion1);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                    } else {
                        $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                        if ($this->total_rows($resultconversion2)) {
                            $rowconversion2 = $this->fetch_assoc($resultconversion2);
                            $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        }
                    }
                }
                $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
                $rowmatrix = $this->fetch_assoc($resultmatrix);
                $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
                $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
                $masterunc = 0;
                $leastcount = $this->unitconversion($rowcalibpoint['masterunit'], $rowcalibpoint['unit'], $rowmatrix['leastcount']);

                $masterunc = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(cmc*cmc))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
                $masterunc = $masterunc / 1000;
                $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

                $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
                $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
                $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
                $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
                $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
                $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
                $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
                $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc'");

                $typea = $repeatability / sqrt(5);
                $leastcount = $rowmatrix['leastcount'];
                $thermalcomaster = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffmaster' and repeatable=0");
                $thermalcouuc = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffuuc' and repeatable=0");
                $thermalcomaster = $thermalcomaster * pow(10, -6);
                $thermalcouuc = $thermalcouuc * pow(10, -6);
                $diffofthercoff = abs($thermalcouuc - $thermalcomaster);
                if ($diffofthercoff == 0) {
                    $diffofthercoff = 0.000001;
                }
                $uncertaintytempdevice = 0;
                $resultsupportmastermatrix = $this->selectextrawhere("masterscopematrix", "certificateid in (" . $rowcalibpoint['supportvalidityid'] . ") and unit =12 and masterid in (select id from mminstrument where type like '357' and id in (" . $rowcalibpoint['supportmasterinstid'] . ")) order by cmc desc");
                if ($this->total_rows($resultsupportmastermatrix)) {
                    $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                    $uncertaintytempdevice = $rowsupportmastermatrix['cmc'];
                }

                $uncertaintytempdevicemm = $averageuuc * $thermalcomaster * $uncertaintytempdevice;
                $stduncthercof20 = $averageuuc * $diffofthercoff * 2 * 0.2;
                $stduncdiffinmasuuc = $averageuuc * $diffofthercoff * 2 * 0.5;
                $uncduetoparalism = 0;

                $uncduetoparalism = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='parallinternal' and repeatable=0");
                $uncduetoparalism = $uncduetoparalism / 1000;
                $uncduetoerror = 0;
                $uncduetoerror = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(drift*drift))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
                $uncduetoerror = $uncduetoerror / 2000;
                $comuncer = SQRT(pow($typea, 2) + pow(($masterunc / 2), 2) + pow(($leastcount / 2 / SQRT(3)), 2) + pow(($uncertaintytempdevicemm / SQRT(3)), 2) + pow(($stduncthercof20 / SQRT(3)), 2) + pow(($stduncdiffinmasuuc / SQRT(3)), 2) + pow(($uncduetoparalism / SQRT(3)), 2) + pow(($uncduetoerror / SQRT(3)), 2));

                if (!empty($repeatability)) {
                    $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
                } else {
                    $dof = "-";
                }
                $coveragefactor = 2;
                $expandeduncertainty = $comuncer * $coveragefactor * 1000;
                $cmcuncertainty = $expandeduncertainty;
                $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`)))  and location  like '" . $rowinwarditem['location'] . "'");

                if ($this->total_rows($checkcmcreuslt)) {
                    $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                    $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                    $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
                }
                $n['expandeduncertainty'] = $cmcuncertainty;

                $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
            }
        }
    }

    public function saveucertantyexten($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultunittype = $this->selectextrawhereupdate("crfmatrix$tablesuffix", "id,matrixtype", "crfitemid='$instid'  and status=1 group by matrixtype ");
        while ($rowunittype = $this->fetch_assoc($resultunittype)) {

            $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and matrixid='" . $rowunittype['id'] . "' and status=1 order by convert(point,DECIMAL) desc limit 0,1");
            while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {

                $testunit = $rowcalibpoint['unit'];
                $testpoint = $rowcalibpoint['point'];
                if (isset($rowcalibpoint['masterunit']) && (!empty($rowcalibpoint['masterunit'])) && $rowcalibpoint['masterunit'] != $rowcalibpoint['unit']) {
                    $testunit = $rowcalibpoint['unit'];

                    $testpoint = $rowcalibpoint['point'];
                    $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                    if ($this->total_rows($resultconversion1)) {
                        $rowconversion1 = $this->fetch_assoc($resultconversion1);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                    } else {
                        $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                        if ($this->total_rows($resultconversion2)) {
                            $rowconversion2 = $this->fetch_assoc($resultconversion2);
                            $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        }
                    }
                }
                $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
                $rowmatrix = $this->fetch_assoc($resultmatrix);
                $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
                $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
                $masterunc = 0;
                $leastcount = $this->unitconversion($rowcalibpoint['masterunit'], $rowcalibpoint['unit'], $rowmatrix['leastcount']);

                $uncertaintyofvernier = $this->selectfieldwhere("masterscopematrix", "max(cmc)", "certificateid in (" . $rowcalibpoint['validityid'] . ") and masterid in (select id from mminstrument where id in (" . $rowcalibpoint['masterinstid'] . ") and type like '330')");
                $uncertaintyofvernier = $uncertaintyofvernier / 1000;
                $nominalpoint = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowmatrix['id'] . " and type='nominallength' and repeatable=0");
                $masterunc = 0;

                $masterunc = $this->selectfieldwhere("masterscopematrix", "max(cmc)", "certificateid in (" . $rowcalibpoint['validityid'] . ") and masterid not in (select id from mminstrument where id in (" . $rowcalibpoint['masterinstid'] . ") and type like '330')");
                $masterunc = $masterunc / 1000;

                $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
                $master1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=1");

                $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
                $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
                $error0 = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
                $error1 = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=1");
                $percenterror0 = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='percenterror' and repeatable=0");
                $percenterror1 = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='percenterror' and repeatable=1");
                $maxerror = ($error0 > $error1) ? $error0 : $error1;
                $maxpercenterror = ($percenterror0 > $percenterror1) ? $percenterror0 : $percenterror1;
                $maxreleativebiaserror = $uuc0 * $maxpercenterror / 100;
                $averagemaster = ($uuc0 + $uuc1 + $error0 + $error1 + $percenterror0) / 5;
                $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error'");

                $typea = $repeatability / sqrt(2);
                $leastcount = $rowmatrix['leastcount'];
                $thermalcomaster = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffmaster' and repeatable=0");
                $thermalcouuc = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffuuc' and repeatable=0");
                $thermalcomaster = $thermalcomaster * pow(10, -6);
                $thermalcouuc = $thermalcouuc * pow(10, -6);
                $diffofthercoff = abs($thermalcouuc - $thermalcomaster);
                if ($diffofthercoff == 0) {
                    $diffofthercoff = 0.000001;
                }
                $uncertaintytempdevice = 0;
                $resultsupportmastermatrix = $this->selectextrawhere("masterscopematrix", "certificateid in (" . $rowcalibpoint['supportvalidityid'] . ") and unit =12 and masterid in (select id from mminstrument where type like '357' and id in (" . $rowcalibpoint['supportmasterinstid'] . ")) order by cmc desc");
                if ($this->total_rows($resultsupportmastermatrix)) {
                    $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                    $uncertaintytempdevice = $rowsupportmastermatrix['cmc'];
                }

                $uncertaintytempdevicemm = $averagemaster * $thermalcomaster * $uncertaintytempdevice;
                $stduncthercof20 = $averagemaster * $diffofthercoff * 2 * 0.2;
                $stduncdiffinmasuuc = $averagemaster * $diffofthercoff * 2 * 0.5;

                $comuncer = SQRT(pow($maxreleativebiaserror / 2 / sqrt(3), 2) + pow(($uncertaintyofvernier / 2), 2) + pow(($masterunc / 2), 2) + pow(($masterunc / 2), 2) + pow(($leastcount / 2 / SQRT(3)), 2) + pow(($uncertaintytempdevicemm / SQRT(3)), 2) + pow(($stduncthercof20 / SQRT(3)), 2) + pow(($stduncdiffinmasuuc / SQRT(3)), 2));

                if (!empty($repeatability)) {
                    $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
                } else {
                    $dof = "-";
                }
                $coveragefactor = 2;
                $expandeduncertainty = $comuncer * $coveragefactor * 1000;
                $cmcuncertainty = $expandeduncertainty;
                $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`)))  and location  like '" . $rowinwarditem['location'] . "'");

                if ($this->total_rows($checkcmcreuslt)) {
                    $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                    $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                    $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
                }
                $n['expandeduncertainty'] = $cmcuncertainty;

                $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
            }
        }
    }

    public function saveucertantyfg($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $maxpoint = $this->selectfieldwhere("crfcalibrationpoint$tablesuffix", "max(point)", "crfitemid='$instid' and status=1 ");
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and point = '$maxpoint' and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;

            $masterleastcount = $rowmastermatrix['leastcount'];
            if (isset($masterunit) && (!empty($masterunit)) && $masterunit != $uucunit) {
                $testunit = $uucunit;

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);

                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    $masterleastcount = $rowmastermatrix['leastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    $mlc = 0;
                    //
                    if ($masterleastcount != "NA") {
                        $mlc = 0;
                        $temp1 = explode(".", $masterleastcount);
                        if (count($temp1) > 1) {
                            $temp2 = end($temp1);
                            $mlc = strlen($temp2);
                        }
                    } else {
                        $mlc = "NA";
                    }

                    $testpoint = sprintf("%.0" . $mlc . "f", $testpoint);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                        //                        $masterleastcount = $rowmatrix ['leastcount'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                        $masterleastcount = $rowcalibpoint['masterleastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        $mlc = 0;
                        //
                        if ($masterleastcount != "NA") {
                            $mlc = 0;
                            $temp1 = explode(".", $masterleastcount);
                            if (count($temp1) > 1) {
                                $temp2 = end($temp1);
                                $mlc = strlen($temp2);
                            }
                        } else {
                            $mlc = "NA";
                        }

                        $testpoint = sprintf("%.0" . $mlc . "f", $testpoint);
                    }
                }
            }

            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }
            $masterunc = $masterunc / 1000;
            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
            $master1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=1");
            $master2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=2");
            $master3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=3");
            $master4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=4");
            $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master'");

            $typea = $repeatability / sqrt(5);

            $thermalcomaster = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffmaster' and repeatable=0");
            $thermalcouuc = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffuuc' and repeatable=0");
            $thermalcomaster = $thermalcomaster * pow(10, -6);
            $thermalcouuc = $thermalcouuc * pow(10, -6);
            $uncertaintytempdevice = 0;
            $resultsupportmastermatrix = $this->selectextrawhere("masterscopematrix", "certificateid='" . $rowcalibpoint['supportvalidityid'] . "' and unit =12 order by cmc desc");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $uncertaintytempdevice = $rowsupportmastermatrix['cmc'];
                //           $uncertaintytempdevice
            }
            $diffofthercoff = abs($thermalcouuc - $thermalcomaster);
            if ($diffofthercoff == 0) {
                $diffofthercoff = 0.000001;
            }
            $uncertaintytempdevicemm = $averagemaster * $thermalcomaster * $uncertaintytempdevice;
            $stduncthercof20 = $averagemaster * $diffofthercoff * 2 * 0.2;
            $stduncdiffinmasuuc = $averagemaster * $diffofthercoff * 2 * 0.5;
            $uncduetoparalism = 0;
            if (strtolower($rowmatrix['matrixtype'] == "external measurement")) {
                $uncduetoparalism = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='parallexternal' and repeatable=0");
            }
            if (strtolower($rowmatrix['matrixtype'] == "internal  measurement")) {
                $uncduetoparalism = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='parallinternal' and repeatable=0");
            }
            $uncduetoerror = 0;
            $comuncer = SQRT(pow($typea, 2) + pow(($masterunc / 2), 2) + pow(($masterleastcount / 2 / SQRT(3)), 2) + pow(($uncertaintytempdevicemm / SQRT(3)), 2) + pow(($stduncthercof20 / SQRT(3)), 2) + pow(($stduncdiffinmasuuc / SQRT(3)), 2) + pow(($uncduetoparalism / SQRT(3)), 2) + pow(($uncduetoerror / 2 / SQRT(3)), 2));

            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor * 1000;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(`parameter`)) and mode='" . $rowcalibpoint['mastermode'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }

            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantygtm($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $rowmatrix['leastcount'];
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }
            $drift = 0.1 * $masterunc;

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
            $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0");

            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
            $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
            $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
            $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
            $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc'");
            $sensitivitycoefient = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='sensitivitycoefficient' and repeatable=0");
            $masterunit = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='masterunit' and repeatable=0");
            $typea = ($repeatability / sqrt(5));
            $stability = 0;
            $uniformity = 0;
            $resultsupportmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['supportmastermatrixid'] . "'");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $stability = $rowsupportmastermatrix['stability'];
                $uniformity = $rowsupportmastermatrix['uniformity'];
            }
            $masterunc2 = 0;

            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $averagemaster . "' and (`unit` like '" . $masterunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc2 = $row2['cmc'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $averagemaster . "' and (`unit` like '" . $masterunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $averagemaster . "' and (unit like '" . $masterunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if (!empty($row2) && !empty($row3)) {
                    $masterunc2 = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $averagemaster);
                } elseif (!empty($row2)) {
                    $masterunc2 = $row2['cmc'];
                } elseif (!empty($row3)) {
                    $masterunc2 = $row3['cmc'];
                }
            }


            $masterunc2inc = $masterunc2 * $sensitivitycoefient;
            $resultsupportmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['supportmastermatrixid'] . "'");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $stability = $rowsupportmastermatrix['stability'];
                $uniformity = $rowsupportmastermatrix['uniformity'];
            }


            //            =sqrt(((pow($typea, 2) +(M8/2)^2+(N8/SQRT(3))^2+(O8/SQRT(3))^2+(P8/SQRT(3))^2+(Q8/SQRT(3))^2+(R8/2/SQRT(3))^2)))
            $comuncer = sqrt((pow($typea, 2) + pow(($masterunc / 2), 2) + pow($masterunc2inc / 2, 2) + pow($stability / sqrt(3), 2) + pow($uniformity / sqrt(3), 2) + pow($drift / sqrt(3), 2) + pow($leastcount / 2 / sqrt(3), 2)));
            //            $comuncer = sqrt(pow($typea, 2) + pow(( / sqrt(3)), 2) + pow(($masterunc * $averageuuc / 100) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / (pow($typea, 4) / 4);
            } else {
                $dof = "-";
            }
            //            if($dof)
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`))) and location  like '" . $rowinwarditem['location'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantyhg($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultunittype = $this->selectextrawhereupdate("crfmatrix$tablesuffix", "id,matrixtype", "crfitemid='$instid' and status=1 group by matrixtype ");
        while ($rowunittype = $this->fetch_assoc($resultunittype)) {

            $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and matrixid='" . $rowunittype['id'] . "' order by convert(point,DECIMAL) desc limit 0,1");
            while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
                $testunit = $rowcalibpoint['unit'];
                $testpoint = $rowcalibpoint['point'];
                if (isset($rowcalibpoint['masterunit']) && (!empty($rowcalibpoint['masterunit'])) && $rowcalibpoint['masterunit'] != $rowcalibpoint['unit']) {
                    $testunit = $rowcalibpoint['unit'];

                    $testpoint = $rowcalibpoint['point'];
                    $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                    if ($this->total_rows($resultconversion1)) {
                        $rowconversion1 = $this->fetch_assoc($resultconversion1);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                    } else {
                        $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                        if ($this->total_rows($resultconversion2)) {
                            $rowconversion2 = $this->fetch_assoc($resultconversion2);
                            $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        }
                    }
                }
                $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
                $rowmatrix = $this->fetch_assoc($resultmatrix);
                $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
                $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
                $masterunc = 0;
                $leastcount = $this->unitconversion($rowcalibpoint['masterunit'], $rowcalibpoint['unit'], $rowmatrix['leastcount']);

                $masterunc = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(cmc*cmc))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
                $masterunc = $masterunc / 1000;
                $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

                $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
                $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
                $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
                $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
                $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
                $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
                $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
                $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc'");

                $typea = $repeatability / sqrt(5);
                $leastcount = $rowmatrix['leastcount'];
                $thermalcomaster = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffmaster' and repeatable=0");
                $thermalcouuc = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffuuc' and repeatable=0");
                $thermalcomaster = $thermalcomaster * pow(10, -6);
                $thermalcouuc = $thermalcouuc * pow(10, -6);
                $diffofthercoff = abs($thermalcouuc - $thermalcomaster);
                if ($diffofthercoff == 0) {
                    $diffofthercoff = 0.000001;
                }
                $uncertaintytempdevice = 0;
                $resultsupportmastermatrix = $this->selectextrawhere("masterscopematrix", "certificateid in (" . $rowcalibpoint['supportvalidityid'] . ") and unit =12 and masterid in (select id from mminstrument where type like '357' and id in (" . $rowcalibpoint['supportmasterinstid'] . ")) order by cmc desc");
                if ($this->total_rows($resultsupportmastermatrix)) {
                    $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                    $uncertaintytempdevice = $rowsupportmastermatrix['cmc'];
                }
                $flatness = 0;
                $resultsupportmastermatrix2 = $this->selectextrawhere("mastermatrix", "certificateid in (" . $rowcalibpoint['supportvalidityid'] . ")  and masterid in (select id from mminstrument where type like '364' and id in (" . $rowcalibpoint['supportmasterinstid'] . ")) order by accuracyabsolute desc");
                if ($this->total_rows($resultsupportmastermatrix2)) {
                    $rowsupportmastermatrix2 = $this->fetch_assoc($resultsupportmastermatrix2);
                    $flatness = $rowsupportmastermatrix2['accuracyabsolute'];
                }

                $uncertaintytempdevicemm = $averageuuc * $thermalcomaster * $uncertaintytempdevice;
                $stduncthercof20 = $averageuuc * $diffofthercoff * 2 * 0.2;
                $stduncdiffinmasuuc = $averageuuc * $diffofthercoff * 2 * 0.5;
                $uncduetoparalism = 0;

                $uncduetoparalism = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='parallinternal' and repeatable=0");
                $uncduetoparalism = $uncduetoparalism / 1000;
                $uncduetoerror = 0;
                $uncduetoerror = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(drift*drift))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
                $uncduetoerror = $uncduetoerror / 2000;
                $comuncer = SQRT(pow($typea, 2) + pow(($masterunc / 2), 2) + pow(($leastcount / 2 / SQRT(3)), 2) + pow(($flatness / SQRT(3)), 2) + pow(($uncertaintytempdevicemm / SQRT(3)), 2) + pow(($stduncthercof20 / SQRT(3)), 2) + pow(($stduncdiffinmasuuc / SQRT(3)), 2) + pow(($uncduetoparalism / SQRT(3)), 2) + pow(($uncduetoerror / SQRT(3)), 2));

                if (!empty($repeatability)) {
                    $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
                } else {
                    $dof = "-";
                }
                $coveragefactor = 2;
                $expandeduncertainty = $comuncer * $coveragefactor * 1000;
                $cmcuncertainty = $expandeduncertainty;
                $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`)))  and location  like '" . $rowinwarditem['location'] . "'");

                if ($this->total_rows($checkcmcreuslt)) {
                    $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                    $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                    $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
                }
                $n['expandeduncertainty'] = $cmcuncertainty;

                $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
            }
        }
    }

    public function saveucertantymm($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);
        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "' and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $leastcount = $rowmatrix['leastcount'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                    $leastcount = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion2['fromvalue'] / $rowconversion2['tovalue']);
                        $leastcount = $rowcalibpoint['point'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                    }
                }
            }

            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "' and status=1");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;

            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "'  order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);

                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if ($num2) {
                    if ($num3) {
                        $cmcunit = $row2['cmcunit'];
                        $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
                    } else {
                        $masterunc = $row2['cmc'];
                        $cmcunit = $row2['cmcunit'];
                    }
                } else {
                    if ($num3) {
                        $masterunc = $row3['cmc'];
                        $cmcunit = $row3['cmcunit'];
                    }
                }
            }
            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
            $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
            $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
            $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
            $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and (repeatable>=0 and repeatable<=4)");

            $masteraccuracy = 0;
            //            print_r($rowmastermatrix);
            if (!empty($rowmastermatrix['accuracyrange'])) {
                $masteraccuracy = ($rowmastermatrix['instrangemax'] - $rowmastermatrix['instrangemin']) * $rowmastermatrix['accuracyrange'] / 100;
            }
            if (!empty($rowmastermatrix['accuracymeasrement'])) {

                $masteraccuracy = floatval($masteraccuracy) + floatval($testpoint * $rowmastermatrix['accuracymeasrement'] / 100);
            }

            if (!empty($rowmastermatrix['accuracyabsolute'])) {


                $masteraccuracy = floatval($masteraccuracy) + floatval($rowmastermatrix['accuracyabsolute']);
            }


            $typea = $repeatability / sqrt(5);
            $comuncer = sqrt(pow($typea, 2) + pow(($masteraccuracy / sqrt(3)), 2) + pow(($masterunc * $averageuuc / 100) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $expandeduncertaintypercent = ($expandeduncertainty / $testpoint) * 100;
            $cmcuncertainty = $expandeduncertaintypercent;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and location='" . $rowinwarditem['location'] . "' and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowcalibpoint['unittype']) . "',LOWER(`parameter`)) and mode='" . $rowcalibpoint['mastermode'] . "' and (find_in_set(" . $rowcalibpoint['masterinstid'] . ",masters)) ");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertaintypercent) ? $tempcmc : $expandeduncertaintypercent;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantymsr($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);
        $i = 1;
        $resultunittype = $this->selectextrawhereupdate("crfmatrix$tablesuffix", "id,matrixtype", "crfitemid='$instid'  and status=1 group by matrixtype ");
        while ($rowunittype = $this->fetch_assoc($resultunittype)) {

            $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and matrixid='" . $rowunittype['id'] . "' and status=1 ");
            while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
                $testunit = $rowcalibpoint['unit'];
                $testpoint = $rowcalibpoint['point'];
                if (isset($rowcalibpoint['masterunit']) && (!empty($rowcalibpoint['masterunit'])) && $rowcalibpoint['masterunit'] != $rowcalibpoint['unit']) {
                    $testunit = $rowcalibpoint['unit'];

                    $testpoint = $rowcalibpoint['point'];
                    $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                    if ($this->total_rows($resultconversion1)) {
                        $rowconversion1 = $this->fetch_assoc($resultconversion1);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                    } else {
                        $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                        if ($this->total_rows($resultconversion2)) {
                            $rowconversion2 = $this->fetch_assoc($resultconversion2);
                            $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        }
                    }
                }
                $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
                $rowmatrix = $this->fetch_assoc($resultmatrix);
                $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
                $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
                $masterunc = 0;
                $leastcount = $this->unitconversion($rowcalibpoint['masterunit'], $rowcalibpoint['unit'], $rowmatrix['leastcount']);

                $masterunc = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(cmc*cmc))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
                $masterunc = $masterunc / 1000;
                $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");

                $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

                $masterleastcount = $this->selectfieldwhere("mastermatrix", "leastcount", "certificateid in (" . $rowcalibpoint['validityid'] . ") and masterid in (select id from mminstrument where id in (" . $rowcalibpoint['masterinstid'] . ") and type like '8')");
                $master1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=1");
                $master2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=2");
                $master3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=3");
                $master4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=4");
                $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0");
                $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
                $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master'");

                $typea = $repeatability / sqrt(5);
                $leastcount = $rowmatrix['leastcount'];
                $thermalcomaster = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffmaster' and repeatable=0");
                $thermalcouuc = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffuuc' and repeatable=0");
                $thermalcomaster = $thermalcomaster * pow(10, -6);
                $thermalcouuc = $thermalcouuc * pow(10, -6);
                $diffofthercoff = abs($thermalcouuc - $thermalcomaster);
                if ($diffofthercoff == 0) {
                    $diffofthercoff = 0.000001;
                }
                $uncertaintytempdevice = 0;
                $resultsupportmastermatrix = $this->selectextrawhere("masterscopematrix", "certificateid in (" . $rowcalibpoint['supportvalidityid'] . ") and unit =12 and masterid in (select id from mminstrument where type like '357' and id in (" . $rowcalibpoint['supportmasterinstid'] . ")) order by cmc desc");
                if ($this->total_rows($resultsupportmastermatrix)) {
                    $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                    $uncertaintytempdevice = $rowsupportmastermatrix['cmc'];
                }
                $uncertaintyofdialguage = $this->selectfieldwhere("masterscopematrix", "max(cmc)", "certificateid in (" . $rowcalibpoint['validityid'] . ") and masterid in (select id from mminstrument where id in (" . $rowcalibpoint['masterinstid'] . ") and type like '8')");
                $uncertaintyofdialguage = $uncertaintyofdialguage / 1000;
                $flatness = 0;
                $resultsupportmastermatrix2 = $this->selectextrawhere("mastermatrix", "certificateid in (" . $rowcalibpoint['validityid'] . ")  and masterid in (select id from mminstrument where type like '323' and id in (" . $rowcalibpoint['masterinstid'] . ")) order by accuracyabsolute desc");
                if ($this->total_rows($resultsupportmastermatrix2)) {
                    $rowsupportmastermatrix2 = $this->fetch_assoc($resultsupportmastermatrix2);
                    $flatness = $rowsupportmastermatrix2['accuracyabsolute'];
                }
                $uncertaintytempdevicemm = $averagemaster * $thermalcomaster * $uncertaintytempdevice;
                $stduncthercof20 = $averagemaster * $diffofthercoff * 2 * 0.2;
                $stduncdiffinmasuuc = $averagemaster * $diffofthercoff * 2 * 0.5;
                $uncduetoparalism = 0;

                $uncduetoerror = 0;
                $uncduetoerror = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(drift*drift))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
                $uncduetoerror = $uncduetoerror / 2000;
                $comuncer = SQRT(pow($typea, 2) + pow(($masterunc / 2), 2) + pow(($uncertaintyofdialguage / 2), 2) + pow(($flatness / SQRT(3)), 2) + pow(($masterleastcount / 2 / SQRT(3)), 2) + pow(($uncertaintytempdevicemm / SQRT(3)), 2) + pow(($stduncthercof20 / SQRT(3)), 2) + pow(($stduncdiffinmasuuc / SQRT(3)), 2) + pow(($uncduetoparalism / SQRT(3)), 2) + pow(($uncduetoerror / SQRT(3)), 2));

                if (!empty($repeatability)) {
                    $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
                } else {
                    $dof = "-";
                }
                $coveragefactor = 2;
                $expandeduncertainty = $comuncer * $coveragefactor * 1000;
                $cmcuncertainty = $expandeduncertainty;
                $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`)))  and location  like '" . $rowinwarditem['location'] . "'");

                if ($this->total_rows($checkcmcreuslt)) {
                    $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                    $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                    $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
                }
                $n['expandeduncertainty'] = $cmcuncertainty;

                $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
            }
        }
    }

    public function saveucertantymt($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $maxpoint = $this->selectfieldwhere("crfcalibrationpoint$tablesuffix", "max(cast(point as DECIMAL(10,3)))", "crfitemid='$instid' and status=1 ");
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and cast(point as DECIMAL(10,3)) = '$maxpoint' and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $lc = 0;

            if ($rowmatrix['leastcount'] != "NA") {
                $lc = 0;
                $temp1 = explode(".", $rowmatrix['leastcount']);
                if (count($temp1) > 1) {
                    $temp2 = end($temp1);
                    $lc = strlen($temp2);
                }
            } else {
                $lc = "NA";
            }

            $masterleastcount = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thicknessofgraduation' and repeatable=0");
            if (isset($masterunit) && (!empty($masterunit)) && $masterunit != $uucunit) {
                $testunit = $uucunit;

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);

                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    $masterleastcount = $rowmastermatrix['leastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    $mlc = 0;
                    //
                    if ($masterleastcount != "NA") {
                        $mlc = 0;
                        $temp1 = explode(".", $masterleastcount);
                        if (count($temp1) > 1) {
                            $temp2 = end($temp1);
                            $mlc = strlen($temp2);
                        }
                    } else {
                        $mlc = "NA";
                    }

                    $testpoint = sprintf("%.0" . $mlc . "f", $testpoint);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                        //                        $masterleastcount = $rowmatrix ['leastcount'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                        $masterleastcount = $rowcalibpoint['masterleastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        $mlc = 0;
                        //
                        if ($masterleastcount != "NA") {
                            $mlc = 0;
                            $temp1 = explode(".", $masterleastcount);
                            if (count($temp1) > 1) {
                                $temp2 = end($temp1);
                                $mlc = strlen($temp2);
                            }
                        } else {
                            $mlc = "NA";
                        }

                        $testpoint = sprintf("%.0" . $mlc . "f", $testpoint);
                    }
                }
            }

            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }
            $masterunc = $masterunc / 1000;
            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
            $master1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=1");
            $master2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=2");
            $master3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=3");
            $master4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=4");
            $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master'");

            $typea = $repeatability / sqrt(5);
            $masterleastcount = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thicknessofgraduation' and repeatable=0");

            $thermalcomaster = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffmaster' and repeatable=0");
            $thermalcouuc = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffuuc' and repeatable=0");
            $thermalcomaster = $thermalcomaster * pow(10, -6);
            $thermalcouuc = $thermalcouuc * pow(10, -6);
            $uncertaintytempdevice = 0;
            $resultsupportmastermatrix = $this->selectextrawhere("masterscopematrix", "certificateid='" . $rowcalibpoint['supportvalidityid'] . "' and unit =12 order by cmc desc");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $uncertaintytempdevice = $rowsupportmastermatrix['cmc'];
                //           $uncertaintytempdevice
            }
            $diffofthercoff = abs($thermalcouuc - $thermalcomaster);
            if ($diffofthercoff == 0) {
                $diffofthercoff = 0.000001;
            }
            $uncertaintytempdevicemm = $averagemaster * $thermalcomaster * $uncertaintytempdevice;
            $stduncthercof20 = $averagemaster * $diffofthercoff * 2 * 0.2;
            $stduncdiffinmasuuc = $averagemaster * $diffofthercoff * 2 * 0.5;
            $uncduetoparalism = 0;
            if (strtolower($rowmatrix['matrixtype'] == "external measurement")) {
                $uncduetoparalism = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='parallexternal' and repeatable=0");
            }
            if (strtolower($rowmatrix['matrixtype'] == "internal  measurement")) {
                $uncduetoparalism = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='parallinternal' and repeatable=0");
            }
            $uncduetoerror = 0;
            $comuncer = SQRT(pow($typea, 2) + pow(($masterunc / 2), 2) + pow(($masterleastcount / 2 / SQRT(3)), 2) + pow(($uncertaintytempdevicemm / SQRT(3)), 2) + pow(($stduncthercof20 / SQRT(3)), 2) + pow(($stduncdiffinmasuuc / SQRT(3)), 2) + pow(($uncduetoparalism / SQRT(3)), 2) + pow(($uncduetoerror / 2 / SQRT(3)), 2));

            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor * 1000;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower(trim($rowlistoinst['name'])) . "',LOWER(trim(`parameter`))) ");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantyodfm($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid  and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['masterunit']) && (!empty($rowcalibpoint['masterunit'])) && $rowcalibpoint['masterunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $this->unitconversion($rowcalibpoint['masterunit'], $rowcalibpoint['unit'], $rowmatrix['leastcount']);
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }
            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
            $master1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=1");
            $master2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=2");
            $master3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=3");
            $master4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=4");
            $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master'");

            $typea = $repeatability / sqrt(5);
            $leastcount = $rowmatrix['leastcount'];
            $sensitivitycoff = 2.5;
            $masterunc2 = 0;
            $stability = 0;
            $uniformity = 0;
            $drift = 0;

            $comuncer = SQRT((pow($typea, 2) + pow(($masterunc / 2), 2) + pow(($masterunc2 * $sensitivitycoff / 2), 2) + pow(($stability / SQRT(3)), 2) + pow(($uniformity / SQRT(3)), 2) + pow(($drift / SQRT(3)), 2) + pow(($leastcount / 2 / SQRT(3)), 2)));

            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower(trim($rowlistoinst['name'])) . "',LOWER(trim(`parameter`))) and status=1");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantyrht($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);
        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $rowmatrix['leastcount'];
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "'  order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);

                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if ($num2) {
                    if ($num3) {
                        $cmcunit = $row2['cmcunit'];
                        $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
                    } else {
                        $masterunc = $row2['cmc'];
                        $cmcunit = $row2['cmcunit'];
                    }
                } else {
                    if ($num3) {
                        $masterunc = $row3['cmc'];
                        $cmcunit = $row3['cmcunit'];
                    }
                }
            }
            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
            $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
            $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
            $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
            $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and (repeatable>=0 and repeatable<=4)");

            $typea = $repeatability / sqrt(5) * 1.14;
            $comuncer = sqrt(pow($typea, 2) + pow(($masterunc) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $expandeduncertaintypercent = ($expandeduncertainty / $testpoint) * 100;
            $cmcuncertainty = $expandeduncertaintypercent;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowcalibpoint['unittype']) . "',LOWER(`parameter`)) and mode='" . $rowcalibpoint['mastermode'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertaintypercent) ? $tempcmc : $expandeduncertaintypercent;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantyrtdwi($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $rowmatrix['leastcount'];
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }
            $drift = 0.1 * $masterunc;

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
            $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='saveragemaster' and repeatable=0");

            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
            $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
            $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
            $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
            $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc'");
            $sensitivitycoefient = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='sensitivitycoefficient' and repeatable=0");
            $masterunit = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='masterunit' and repeatable=0");
            $typea = ($repeatability / sqrt(5));
            $stability = 0;
            $uniformity = 0;
            $resultsupportmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['supportmastermatrixid'] . "'");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $stability = $rowsupportmastermatrix['stability'];
                $uniformity = $rowsupportmastermatrix['uniformity'];
            }
            $masterunc2 = 0;

            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $averagemaster . "' and (`unit` like '" . $masterunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc2 = $row2['cmc'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $averagemaster . "' and (`unit` like '" . $masterunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $averagemaster . "' and (unit like '" . $masterunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if (!empty($row2) && !empty($row3)) {
                    $masterunc2 = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $averagemaster);
                } elseif (!empty($row2)) {
                    $masterunc2 = $row2['cmc'];
                } elseif (!empty($row3)) {
                    $masterunc2 = $row3['cmc'];
                }
            }
            $masterunc2 = $masterunc2 * $averagemaster / 100;
            $masterunc2inc = $masterunc2 * $sensitivitycoefient;
            $resultsupportmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['supportmastermatrixid'] . "'");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $stability = $rowsupportmastermatrix['stability'];
                $uniformity = $rowsupportmastermatrix['uniformity'];
            }


            //            =sqrt(((pow($typea, 2) +(M8/2)^2+(N8/SQRT(3))^2+(O8/SQRT(3))^2+(P8/SQRT(3))^2+(Q8/SQRT(3))^2+(R8/2/SQRT(3))^2)))
            $comuncer = sqrt((pow($typea, 2) + pow(($masterunc / 2), 2) + pow($masterunc2inc / 2, 2) + pow($stability / sqrt(3), 2) + pow($uniformity / sqrt(3), 2) + pow($drift / sqrt(3), 2) + pow($leastcount / 2 / sqrt(3), 2)));
            //            $comuncer = sqrt(pow($typea, 2) + pow(( / sqrt(3)), 2) + pow(($masterunc * $averageuuc / 100) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / (pow($typea, 4) / 4);
            } else {
                $dof = "-";
            }
            //            if($dof)
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`))) and location  like '" . $rowinwarditem['location'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantyrtdwoi($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $rowmastermatrix['leastcount'];
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }
            $drift = 0.1 * $masterunc;

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
            $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0");

            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
            $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
            $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
            $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
            $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");

            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc'");
            $sensitivitycoefient = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='sensitivitycoefficient' and repeatable=0");
            $masterunit = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='masterunit' and repeatable=0");
            $uucunit = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucunit' and repeatable=0");
            $typea = ($repeatability / sqrt(5)) * $sensitivitycoefient;
            $stability = 0;
            $uniformity = 0;
            $resultsupportmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['supportmastermatrixid'] . "'");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $stability = $rowsupportmastermatrix['stability'];
                $uniformity = $rowsupportmastermatrix['uniformity'];
            }
            //            $masterunc2 = 0;
            //            $masterunc2 = $this->selectfieldwhere("masterscopematrix", "cmc", "unit=3 and masterid in () and certificateid in (" . $rowcalibpoint['validityid'] . ")");
            //

            $masterunc2 = 0;

            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $averagemaster . "' and (`unit` like '" . $masterunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc2 = $row2['cmc'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $averagemaster . "' and (`unit` like '" . $masterunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $averagemaster . "' and (unit like '" . $masterunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if (!empty($row2) && !empty($row3)) {

                    $masterunc2 = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $averagemaster);
                } elseif (!empty($row2)) {
                    $masterunc2 = $row2['cmc'];
                } elseif (!empty($row3)) {
                    $masterunc2 = $row3['cmc'];
                }
            }
            $masterunc2 = $masterunc2 * $averageuuc / 100;
            $masterunc2inc = $masterunc2 * $sensitivitycoefient;

            $resultsupportmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['supportmastermatrixid'] . "'");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $stability = $rowsupportmastermatrix['stability'];
                $uniformity = $rowsupportmastermatrix['uniformity'];
            }


            //            =sqrt(((pow($typea, 2) +(M8/2)^2+(N8/SQRT(3))^2+(O8/SQRT(3))^2+(P8/SQRT(3))^2+(Q8/SQRT(3))^2+(R8/2/SQRT(3))^2)))
            $comuncer = sqrt((pow($typea, 2) + pow(($masterunc / 2), 2) + pow($masterunc2inc / 2, 2) + pow($stability / sqrt(3), 2) + pow($uniformity / sqrt(3), 2) + pow($drift / sqrt(3), 2) + pow($leastcount / 2 / sqrt(3), 2)));
            //            $comuncer = sqrt(pow($typea, 2) + pow(( / sqrt(3)), 2) + pow(($masterunc * $averageuuc / 100) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / (pow($typea, 4) / 4);
            } else {
                $dof = "-";
            }
            //            if($dof)
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`))) and location  like '" . $rowinwarditem['location'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantysrf($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultunittype = $this->selectextrawhereupdate("crfmatrix$tablesuffix", "id,matrixtype", "crfitemid='$instid'  and status=1 group by matrixtype ");
        while ($rowunittype = $this->fetch_assoc($resultunittype)) {

            $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and matrixid='" . $rowunittype['id'] . "' and status=1 order by convert(point,DECIMAL) desc limit 0,1");
            while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
                $testunit = $rowcalibpoint['unit'];
                $testpoint = $rowcalibpoint['point'];
                if (isset($rowcalibpoint['masterunit']) && (!empty($rowcalibpoint['masterunit'])) && $rowcalibpoint['masterunit'] != $rowcalibpoint['unit']) {
                    $testunit = $rowcalibpoint['unit'];

                    $testpoint = $rowcalibpoint['point'];
                    $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                    if ($this->total_rows($resultconversion1)) {
                        $rowconversion1 = $this->fetch_assoc($resultconversion1);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                    } else {
                        $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                        if ($this->total_rows($resultconversion2)) {
                            $rowconversion2 = $this->fetch_assoc($resultconversion2);
                            $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        }
                    }
                }
                $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
                $rowmatrix = $this->fetch_assoc($resultmatrix);
                $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
                $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
                $masterunc = 0;
                $leastcount = $this->unitconversion($rowcalibpoint['masterunit'], $rowcalibpoint['unit'], $rowmatrix['leastcount']);

                $masterunc = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(cmc*cmc))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
                $masterunc = $masterunc * $rowcalibpoint['point'] / 100;
                $masterunc = $masterunc / 1000;

                $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

                $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
                $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
                $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
                $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
                $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
                $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
                $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
                $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc'");
                $repeatability;
                $typea = $repeatability / (1000 * sqrt(5));
                $leastcount = $rowmatrix['leastcount'] / 1000;
                $thermalcomaster = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffmaster' and repeatable=0");
                $thermalcouuc = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffuuc' and repeatable=0");
                $thermalcomaster = $thermalcomaster * pow(10, -6);
                $thermalcouuc = $thermalcouuc * pow(10, -6);
                $diffofthercoff = abs($thermalcouuc - $thermalcomaster);
                if ($diffofthercoff == 0) {
                    $diffofthercoff = 0.000001;
                }
                $uncertaintytempdevice = 0;
                $resultsupportmastermatrix = $this->selectextrawhere("masterscopematrix", "certificateid in (" . $rowcalibpoint['supportvalidityid'] . ") and unit =12 and masterid in (select id from mminstrument where type like '357' and id in (" . $rowcalibpoint['supportmasterinstid'] . ")) order by cmc desc");
                if ($this->total_rows($resultsupportmastermatrix)) {
                    $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                    $uncertaintytempdevice = $rowsupportmastermatrix['cmc'];
                }

                $uncertaintytempdevicemm = $averageuuc * $thermalcomaster * $uncertaintytempdevice;
                $stduncthercof20 = $averageuuc * $diffofthercoff * 2 * 0.2;
                $stduncdiffinmasuuc = $averageuuc * $diffofthercoff * 2 * 0.5;
                $uncduetoparalism = 0;

                $uncduetoerror = 0;
                $uncduetoerror = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(drift*drift))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
                $uncduetoerror = $uncduetoerror / 2000;
                $comuncer = SQRT(pow($typea, 2) + pow(($masterunc / 2), 2) + pow(($leastcount / 2 / SQRT(3)), 2) + pow(($uncertaintytempdevicemm / SQRT(3)), 2) + pow(($stduncthercof20 / SQRT(3)), 2) + pow(($stduncdiffinmasuuc / SQRT(3)), 2) + pow(($uncduetoparalism / SQRT(3)), 2) + pow(($uncduetoerror / SQRT(3)), 2));

                if (!empty($repeatability)) {
                    $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
                } else {
                    $dof = "-";
                }
                $coveragefactor = 2;
                $expandeduncertainty = $comuncer * $coveragefactor * 1000;
                $expandeduncertaintypercent = $expandeduncertainty * 100 / $rowcalibpoint['point'];
                $cmcuncertainty = $expandeduncertaintypercent;

                $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`)))  and location  like '" . $rowinwarditem['location'] . "'");

                if ($this->total_rows($checkcmcreuslt)) {
                    $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                    $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                    $cmcuncertainty = ($tempcmc > $expandeduncertaintypercent) ? $tempcmc : $expandeduncertaintypercent;
                }
                $n['expandeduncertainty'] = $expandeduncertaintypercent;

                $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
            }
        }
    }

    public function saveucertantysutm($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $rowmatrix['leastcount'];

            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
            $master1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=1");
            $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master'");

            $averagedisp = $this->selectfieldwhere("$summarytable", 'avg(cast(value as decimal(10,3)))', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='masterinc' ");
            $averagetime = $this->selectfieldwhere("$summarytable", 'avg(cast(value as decimal(10,3)))', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='masterdec' ");
            $averagetime = $averagetime / 60;
            $averagespeed = $averagedisp / $averagetime;

            $typea = $repeatability / sqrt(2);

            $uncoflinearscale = $this->selectfieldwhere("masterscopematrix", "cmc", "masterid in (select id from mminstrument where type like '362' and id in (" . $rowcalibpoint['masterinstid'] . "))");
            $uncoflinearscale = $uncoflinearscale / 1000;
            $uncofstopwatch = $this->selectfieldwhere("masterscopematrix", "cmc", "masterid in (select id from mminstrument where type like '301' and id in (" . $rowcalibpoint['masterinstid'] . "))");
            $uncofstopwatch = $uncofstopwatch / 60;
            //            echo "masteruc=".$averagespeed ."- ((".$averagedisp." + ".$uncoflinearscale.") / (".$averagetime."+ ".$uncofstopwatch."))";
            $masterunc = $averagespeed - ((floatval($averagedisp) + floatval($uncoflinearscale)) / (floatval($averagetime) + floatval($uncofstopwatch)));
            $leastcountoflinear = $this->selectfieldwhere("mastermatrix", "leastcount", "certificateid in (" . $rowcalibpoint['validityid'] . ") and masterid in (select id from mminstrument where type like '362' and id in (" . $rowcalibpoint['masterinstid'] . "))");;
            $leastcountofstopwatch = $this->selectfieldwhere("mastermatrix", "leastcount", "certificateid in (" . $rowcalibpoint['validityid'] . ") and masterid in (select id from mminstrument where type like '301' and id in (" . $rowcalibpoint['masterinstid'] . "))");;;
            $leastcount = $rowmatrix['leastcount'];
            $comuncer = sqrt(pow($typea, 2) + pow(($masterunc) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $expandeduncertaintypercent = ($expandeduncertainty / $testpoint) * 100;
            $cmcuncertainty = $expandeduncertaintypercent;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(`parameter`)) ");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertaintypercent) ? $tempcmc : $expandeduncertaintypercent;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantyth($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);
        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $this->unitconversion($rowcalibpoint['calculationunit'], $rowcalibpoint['unit'], $rowmatrix['leastcount']);
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }
            $drift = 0;
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $drift = $row2['cmc'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                $drift = cmcinterpolation($row3['point'], $row2['point'], $row3['drift'], $row2['drift'], $testpoint);
            }

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
            $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
            $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
            $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
            $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc'");

            $typea = $repeatability / sqrt(5);
            $stability = 0;
            $uniformity = 0;
            $resultsupportmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['supportmastermatrixid'] . "'");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $stability = $rowsupportmastermatrix['stability'];
                $uniformity = $rowsupportmastermatrix['uniformity'];
            }
            $masteraccuracy = 0;
            if (!empty($rowmastermatrix['accuracyrange'])) {
                $masteraccuracy = ($rowmastermatrix['instrangemax'] - $rowmastermatrix['instrangemin']) * $rowmastermatrix['accuracyrange'] / 100;
            }
            if (!empty($rowmastermatrix['accuracymeasrement'])) {

                $masteraccuracy = $masteraccuracy + ($rowcalibpoint['point'] * $rowmastermatrix['accuracymeasrement'] / 100);
            }

            if (!empty($rowmastermatrix['accuracyabsolute'])) {


                $masteraccuracy = floatval($masteraccuracy) + floatval($rowmastermatrix['accuracyabsolute']);
            }
            $accuracy = $masteraccuracy;
            //            =sqrt(((pow($typea, 2) +(M8/2)^2+(N8/SQRT(3))^2+(O8/SQRT(3))^2+(P8/SQRT(3))^2+(Q8/SQRT(3))^2+(R8/2/SQRT(3))^2)))
            $comuncer = sqrt((pow($typea, 2) + pow(($masterunc / 2), 2) + pow($accuracy / sqrt(3), 2) + pow($stability / sqrt(3), 2) + pow($uniformity / sqrt(3), 2) + pow($drift / sqrt(3), 2) + pow($leastcount / 2 / sqrt(3), 2)));
            //            $comuncer = sqrt(pow($typea, 2) + pow(( / sqrt(3)), 2) + pow(($masterunc * $averageuuc / 100) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / (pow($typea, 4) / 4);
            } else {
                $dof = "-";
            }
            //            if($dof)
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`))) and mode='" . $rowcalibpoint['mastermode'] . "' and location  like '" . $rowinwarditem['location'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantytm($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);
        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "' and status=1");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $rowmatrix['leastcount'];
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "'  order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);

                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if ($num2) {
                    if ($num3) {
                        $cmcunit = $row2['cmcunit'];
                        $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
                    } else {
                        $masterunc = $row2['cmc'];
                        $cmcunit = $row2['cmcunit'];
                    }
                } else {
                    if ($num3) {
                        $masterunc = $row3['cmc'];
                        $cmcunit = $row3['cmcunit'];
                    }
                }
            }
            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
            $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
            $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
            $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
            $uuc5 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=5");
            $uuc6 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=6");
            $uuc7 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=7");
            $uuc8 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=8");
            $uuc9 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=9");

            $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc'");

            $masteraccuracy = 0;
            if (!empty($rowmastermatrix['accuracyrange'])) {
                $masteraccuracy = ($rowmastermatrix['instrangemax'] - $rowmastermatrix['instrangemin']) * $rowmastermatrix['accuracyrange'] / 100;
            }
            if (!empty($rowmastermatrix['accuracymeasrement'])) {

                $masteraccuracy = $masteraccuracy + ($rowcalibpoint['point'] * $rowmastermatrix['accuracymeasrement'] / 100);
            }

            if (!empty($rowmastermatrix['accuracyabsolute'])) {


                $masteraccuracy = floatval($masteraccuracy) + floatval($rowmastermatrix['accuracyabsolute']);
            }


            $typea = $repeatability / sqrt(10);
            $comuncer = sqrt(pow($typea, 2) + pow(($masteraccuracy / sqrt(3)), 2) + pow(($masterunc * $averageuuc / 100) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $expandeduncertaintypercent = ($expandeduncertainty / $testpoint) * 100;
            $cmcuncertainty = $expandeduncertaintypercent;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(`parameter`)) ");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertaintypercent) ? $tempcmc : $expandeduncertaintypercent;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantyts($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "' and status=1");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);
        $i = 1;

        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1  order by convert(point,DECIMAL) desc limit 0,1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['masterunit']) && (!empty($rowcalibpoint['masterunit'])) && $rowcalibpoint['masterunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterleastcount = $rowmastermatrix['leastcount'];
            //                $masterleastcount = $this->unitconversion($rowcalibpoint['masterunit'], $rowcalibpoint['unit'], $rowmatrix['leastcount']);
            $mlc = getleastcount($masterleastcount);
            $masterunc = 0;

            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "'  order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);

                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if ($num2) {
                    if ($num3) {
                        $cmcunit = $row2['cmcunit'];
                        $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
                    } else {
                        $masterunc = $row2['cmc'];
                        $cmcunit = $row2['cmcunit'];
                    }
                } else {
                    if ($num3) {
                        $masterunc = $row3['cmc'];
                        $cmcunit = $row3['cmcunit'];
                    }
                }
            }
            $masterunc = $masterunc / 1000;
            $averageuuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
            $averageuuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=1");
            $averageuuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=2");
            $averageuuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=3");
            $averageuuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=4");
            $averageaverageuuc = $this->selectfieldwhere("$summarytable", "avg(cast(value as decimal(10,$mlc)))", "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' ");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc'");

            $typea = $repeatability / sqrt(5);

            $thermalcomaster = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffmaster' and repeatable=0");
            $thermalcouuc = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffuuc' and repeatable=0");
            $thermalcomaster = $thermalcomaster * pow(10, -6);
            $thermalcouuc = $thermalcouuc * pow(10, -6);
            $diffofthercoff = abs($thermalcouuc - $thermalcomaster);
            if ($diffofthercoff == 0) {
                $diffofthercoff = 0.000001;
            }
            $uncertaintytempdevice = 0;
            $resultsupportmastermatrix = $this->selectextrawhere("masterscopematrix", "certificateid in (" . $rowcalibpoint['supportvalidityid'] . ") and unit =12 and masterid in (select id from mminstrument where type like '357' and id in (" . $rowcalibpoint['supportmasterinstid'] . ")) order by cmc desc");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $uncertaintytempdevice = $rowsupportmastermatrix['cmc'];
            }

            $uncertaintytempdevicemm = $averageaverageuuc * $thermalcomaster * $uncertaintytempdevice;
            $stduncthercof20 = $averageaverageuuc * $diffofthercoff * 2 * 0.2;
            $stduncdiffinmasuuc = $averageaverageuuc * $diffofthercoff * 2 * 0.5;
            $uncduetoparalism = 0;
            $uncduetoerror = 0;
            $comuncer = SQRT(pow($typea, 2) + pow(($masterunc / 2), 2) + pow(($masterleastcount / 2 / SQRT(3)), 2) + pow(($uncertaintytempdevicemm / SQRT(3)), 2) + pow(($stduncthercof20 / SQRT(3)), 2) + pow(($stduncdiffinmasuuc / SQRT(3)), 2));

            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor * 1000;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`)))  and location  like '" . $rowinwarditem['location'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantytswi($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $rowmatrix['leastcount'];
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }
            $drift = 0.1 * $masterunc;

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
            $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0");
            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
            $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
            $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
            $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
            $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc'");
            $sensitivitycoefient = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='sensitivitycoefficient' and repeatable=0");
            $masterunit = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='masterunit' and repeatable=0");
            $typea = ($repeatability / sqrt(5));
            $stability = 0;
            $uniformity = 0;
            $resultsupportmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['supportmastermatrixid'] . "'");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $stability = $rowsupportmastermatrix['stability'];
                $uniformity = $rowsupportmastermatrix['uniformity'];
            }
            $masterunc2 = 0;

            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $averagemaster . "' and (`unit` like '" . $masterunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc2 = $row2['cmc'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $averagemaster . "' and (`unit` like '" . $masterunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $averagemaster . "' and (unit like '" . $masterunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if (!empty($row2) && !empty($row3)) {
                    $masterunc2 = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $averagemaster);
                } elseif (!empty($row2)) {
                    $masterunc2 = $row2['cmc'];
                } elseif (!empty($row3)) {
                    $masterunc2 = $row3['cmc'];
                }
            }

            $masterunc2inc = $masterunc2 * $sensitivitycoefient;
            $resultsupportmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['supportmastermatrixid'] . "'");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $stability = $rowsupportmastermatrix['stability'];
                $uniformity = $rowsupportmastermatrix['uniformity'];
            }


            //            =sqrt(((pow($typea, 2) +(M8/2)^2+(N8/SQRT(3))^2+(O8/SQRT(3))^2+(P8/SQRT(3))^2+(Q8/SQRT(3))^2+(R8/2/SQRT(3))^2)))
            $comuncer = sqrt((pow($typea, 2) + pow(($masterunc / 2), 2) + pow($masterunc2inc / 2, 2) + pow($stability / sqrt(3), 2) + pow($uniformity / sqrt(3), 2) + pow($drift / sqrt(3), 2) + pow($leastcount / 2 / sqrt(3), 2)));
            //            $comuncer = sqrt(pow($typea, 2) + pow(( / sqrt(3)), 2) + pow(($masterunc * $averageuuc / 100) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / (pow($typea, 4) / 4);
            } else {
                $dof = "-";
            }
            //            if($dof)
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`))) and location  like '" . $rowinwarditem['location'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantytswoi($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $rowmastermatrix['leastcount'];
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);
                $cmcunit = $row2['cmcunit'];
                $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
            }
            $drift = 0.1 * $masterunc;

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
            $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0");
            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
            $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
            $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
            $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
            $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
            $saverageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='saverageuuc' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc'");
            $sensitivitycoefient = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='sensitivitycoefficient' and repeatable=0");
            $masterunit = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='masterunit' and repeatable=0");
            $uucunit = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucunit' and repeatable=0");
            $typea = ($repeatability / sqrt(5)) * $sensitivitycoefient;
            $stability = 0;
            $uniformity = 0;
            $resultsupportmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['supportmastermatrixid'] . "'");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $stability = $rowsupportmastermatrix['stability'];
                $uniformity = $rowsupportmastermatrix['uniformity'];
            }
            $masterunc2 = 0;

            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $averagemaster . "' and (`unit` like '" . $masterunit . "') order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc2 = $row2['cmc'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $averagemaster . "' and (`unit` like '" . $masterunit . "') order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $averagemaster . "' and (unit like '" . $masterunit . "') order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if (!empty($row2) && !empty($row3)) {
                    $masterunc2 = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $averagemaster);
                } elseif (!empty($row2)) {
                    $masterunc2 = $row2['cmc'];
                } elseif (!empty($row3)) {
                    $masterunc2 = $row3['cmc'];
                }
            }
            $masterunc2 = $masterunc2 * $saverageuuc / 100;
            $masterunc2inc = $masterunc2 * $sensitivitycoefient;
            $resultsupportmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['supportmastermatrixid'] . "'");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $stability = $rowsupportmastermatrix['stability'];
                $uniformity = $rowsupportmastermatrix['uniformity'];
            }


            //            =sqrt(((pow($typea, 2) +(M8/2)^2+(N8/SQRT(3))^2+(O8/SQRT(3))^2+(P8/SQRT(3))^2+(Q8/SQRT(3))^2+(R8/2/SQRT(3))^2)))
            $comuncer = sqrt((pow($typea, 2) + pow(($masterunc / 2), 2) + pow($masterunc2inc / 2, 2) + pow($stability / sqrt(3), 2) + pow($uniformity / sqrt(3), 2) + pow($drift / sqrt(3), 2) + pow($leastcount / 2 / sqrt(3), 2)));
            //            $comuncer = sqrt(pow($typea, 2) + pow(( / sqrt(3)), 2) + pow(($masterunc * $averageuuc / 100) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / (pow($typea, 4) / 4);
            } else {
                $dof = "-";
            }
            //            if($dof)
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`))) and location  like '" . $rowinwarditem['location'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantyuc($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);
        $i = 1;

        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {

            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            //                       echo $rowcalibpoint['point']." = ";
            $masterunit = $rowmastermatrix['unit'];
            $leastcount = $rowmatrix['leastcount'];
            $uucunit = $rowcalibpoint['unit'];

            //echo $rowcalibpoint['point']." = ".$testpoint.", leastcount=   $leastcount <br>";
            //echo $leastcount."<br>".$testunit;

            if ($rowcalibpoint['mode'] == "Measure") {
                if (isset($masterunit) && (!empty($masterunit)) && $masterunit != $uucunit) {
                    $testunit = $uucunit;
                    //echo 123;
                    $testpoint = $rowcalibpoint['point'];
                    $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion1)) {
                        $rowconversion1 = $this->fetch_assoc($resultconversion1);

                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        $masterleastcount = $rowmastermatrix['leastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        $leastcount = $rowmatrix['leastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        $mlc = 0;
                        //
                        if ($masterleastcount != "NA") {
                            $mlc = 0;
                            $temp1 = explode(".", $masterleastcount);
                            if (count($temp1) > 1) {
                                $temp2 = end($temp1);
                                $mlc = strlen($temp2);
                            }
                        } else {
                            $mlc = "NA";
                        }

                        //                    $testpoint = sprintf("%.0" . $mlc . "f", $testpoint);
                    } else {
                        $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                        if ($this->total_rows($resultconversion2)) {
                            $rowconversion2 = $this->fetch_assoc($resultconversion2);
                            $testpoint = $rowcalibpoint['point'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                            $leastcount = $rowmatrix['leastcount'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                            //                     $masterleastcount = $rowcalibpoint ['masterleastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                            $mlc = 0;
                            //
                            if ($masterleastcount != "NA") {
                                $mlc = 0;
                                $temp1 = explode(".", $masterleastcount);
                                if (count($temp1) > 1) {
                                    $temp2 = end($temp1);
                                    $mlc = strlen($temp2);
                                }
                            } else {
                                $mlc = "NA";
                            }

                            //                        $testpoint = sprintf("%.0" . $mlc . "f", $testpoint);
                        }
                    }
                }
                $masterunc = 0;

                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') and trim(unittype) like '" . trim($rowcalibpoint['unittype']) . "'  order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);

                if ($num2) {

                    $row2 = $this->fetch_assoc($result2);
                    $masterunc = $row2['cmc'];
                    $cmcunit = $row2['cmcunit'];
                } else {

                    $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') and trim(unittype) like '" . trim($rowcalibpoint['unittype']) . "' order by `point` asc limit 0,1";
                    $result2 = $this->execute($sql2);

                    $num2 = $this->total_rows($result2);
                    $row2 = $this->fetch_assoc($result2);
                    $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') and trim(unittype) like '" . trim($rowcalibpoint['unittype']) . "' order by point desc limit 0,1";
                    $result3 = $this->execute($sql3);
                    $num3 = $this->total_rows($result3);
                    $row3 = $this->fetch_assoc($result3);

                    if ($num2) {
                        if ($num3) {

                            $cmcunit = $row2['cmcunit'];
                            $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
                        } else {

                            $masterunc = $row2['cmc'];
                            $cmcunit = $row2['cmcunit'];
                        }
                    } else {
                        if ($num3) {

                            $masterunc = $row3['cmc'];
                            $cmcunit = $row3['cmcunit'];
                        }
                    }
                }


                $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

                $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
                $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
                $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
                $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
                $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
                $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
                $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
                $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and (repeatable>=0 and repeatable<=4)");
                $masterleastcount = $rowmastermatrix['leastcount'];
                $masteraccuracy = 0;
                if (!empty($rowmastermatrix['accuracyrange'])) {
                    $masteraccuracy = ($rowmastermatrix['instrangemax'] - $rowmastermatrix['instrangemin']) * $rowmastermatrix['accuracyrange'] / 100;
                }
                if (!empty($rowmastermatrix['accuracymeasrement'])) {

                    $masteraccuracy = floatval($masteraccuracy) + floatval($testpoint * $rowmastermatrix['accuracymeasrement'] / 100);
                }

                if (!empty($rowmastermatrix['accuracyabsolute'])) {


                    $masteraccuracy = floatval($masteraccuracy) + floatval($rowmastermatrix['accuracyabsolute']);
                }
                //                echo $rowcalibpoint['point']." (".$rowcalibpoint['unit'].")=".$masterunc." *". $averageuuc." / 100<br>";
                $masterunc1 = $masterunc;
                if ($rowcalibpoint['unit'] != 12) {
                    $masterunc1 = $masterunc * $averageuuc / 100;
                }

                $typea = $repeatability / sqrt(5);
                $comuncer = sqrt(pow($typea, 2) + pow(($masteraccuracy / sqrt(3)), 2) + pow(($masterunc1) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
                if (!empty($repeatability)) {
                    $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
                } else {
                    $dof = "-";
                }
                $coveragefactor = 2;
                $expandeduncertainty = $comuncer * $coveragefactor;
                $expandeduncertaintypercent = ($expandeduncertainty / $rowcalibpoint['point']) * 100;
                $cmcuncertainty = $expandeduncertaintypercent;
                if ($rowcalibpoint['unit'] == 12) {
                    $cmcuncertainty = $expandeduncertainty;
                }
                $searchmaster = "";
                $masterids = explode(",", $rowcalibpoint['masterinstid']);
                $text = "";
                foreach ($masterids as $miv) {
                    if (!empty($text)) {
                        $text .= " or ";
                    }
                    $text .= "  find_in_set(" . $miv . ",masters)";
                }
                $searchmaster = "and ($text)";
                $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and location='" . $rowinwarditem['location'] . "' and FIND_IN_SET ('" . strtolower($rowcalibpoint['unittype']) . "',LOWER(`parameter`)) and mode='" . $rowcalibpoint['mastermode'] . "' $searchmaster ");

                if ($this->total_rows($checkcmcreuslt)) {
                    $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                    $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                    $cmcuncertainty = ($tempcmc > $cmcuncertainty) ? $tempcmc : $cmcuncertainty;
                }
                $n['expandeduncertainty'] = $cmcuncertainty;

                $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
            } elseif ($rowcalibpoint['mode'] == "Source") {
                if (isset($masterunit) && (!empty($masterunit)) && $masterunit != $uucunit) {
                    $testunit = $masterunit;
                    //echo 123;
                    $testpoint = $rowcalibpoint['point'];
                    $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion1)) {
                        $rowconversion1 = $this->fetch_assoc($resultconversion1);

                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        $masterleastcount = $rowmastermatrix['leastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        $leastcount = $rowmatrix['leastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        $mlc = 0;
                        //
                        if ($masterleastcount != "NA") {
                            $mlc = 0;
                            $temp1 = explode(".", $masterleastcount);
                            if (count($temp1) > 1) {
                                $temp2 = end($temp1);
                                $mlc = strlen($temp2);
                            }
                        } else {
                            $mlc = "NA";
                        }

                        //                    $testpoint = sprintf("%.0" . $mlc . "f", $testpoint);
                    } else {
                        $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                        if ($this->total_rows($resultconversion2)) {
                            $rowconversion2 = $this->fetch_assoc($resultconversion2);
                            $testpoint = $rowcalibpoint['point'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                            $leastcount = $rowmatrix['leastcount'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                            //                     $masterleastcount = $rowcalibpoint ['masterleastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                            $mlc = 0;
                            //
                            if ($masterleastcount != "NA") {
                                $mlc = 0;
                                $temp1 = explode(".", $masterleastcount);
                                if (count($temp1) > 1) {
                                    $temp2 = end($temp1);
                                    $mlc = strlen($temp2);
                                }
                            } else {
                                $mlc = "NA";
                            }

                            //                        $testpoint = sprintf("%.0" . $mlc . "f", $testpoint);
                        }
                    }
                }
                $masterunc = 0;

                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') and trim(unittype) like '" . trim($rowcalibpoint['unittype']) . "'  order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $num2 = $this->total_rows($result2);

                if ($num2) {

                    $row2 = $this->fetch_assoc($result2);
                    $masterunc = $row2['cmc'];
                    $cmcunit = $row2['cmcunit'];
                } else {

                    $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') and trim(unittype) like '" . trim($rowcalibpoint['unittype']) . "' order by `point` asc limit 0,1";
                    $result2 = $this->execute($sql2);

                    $num2 = $this->total_rows($result2);
                    $row2 = $this->fetch_assoc($result2);
                    $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') and trim(unittype) like '" . trim($rowcalibpoint['unittype']) . "' order by point desc limit 0,1";
                    $result3 = $this->execute($sql3);
                    $num3 = $this->total_rows($result3);
                    $row3 = $this->fetch_assoc($result3);

                    if ($num2) {
                        if ($num3) {


                            $cmcunit = $row2['cmcunit'];
                            $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
                        } else {
                            //                             if ($rowcalibpoint['point'] > 100 && $rowcalibpoint['point'] < 1000) {
                            //                        echo $testpoint." ".$rowcalibpoint['point'] . "=" . "" ;
                            //                        print_r($row2);
                            //                        echo ""
                            //                        . "<br>";
                            //                    }
                            $masterunc = $row2['cmc'];
                            $cmcunit = $row2['cmcunit'];
                        }
                    } else {
                        if ($num3) {

                            $masterunc = $row3['cmc'];
                            $cmcunit = $row3['cmcunit'];
                        }
                    }
                }


                $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");

                $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
                $master1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=1");
                $master2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=2");
                $master3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=3");
                $master4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=4");
                $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0");
                $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
                $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and (repeatable>=0 and repeatable<=4)");

                $masteraccuracy = 0;
                //                print_r($rowmastermatrix);
                if (!empty($rowmastermatrix['accuracyrange'])) {
                    $masteraccuracy = ($rowmastermatrix['instrangemax'] - $rowmastermatrix['instrangemin']) * $rowmastermatrix['accuracyrange'] / 100;
                }
                if (!empty($rowmastermatrix['accuracymeasrement'])) {

                    $masteraccuracy = floatval($masteraccuracy) + floatval($testpoint * $rowmastermatrix['accuracymeasrement'] / 100);
                }

                if (!empty($rowmastermatrix['accuracyabsolute'])) {


                    $masteraccuracy = floatval($masteraccuracy) + floatval($rowmastermatrix['accuracyabsolute']);
                }
                $masterunc1 = $masterunc;
                if ($rowcalibpoint['unit'] != 12) {
                    $masterunc1 = $masterunc * $averagemaster / 100;
                }

                $typea = $repeatability / sqrt(5);
                $comuncer = sqrt(pow($typea, 2) + pow(($masteraccuracy / sqrt(3)), 2) + pow(($masterunc1) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
                if (!empty($repeatability)) {
                    $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
                } else {
                    $dof = "-";
                }
                $coveragefactor = 2;
                $expandeduncertainty = $comuncer * $coveragefactor;
                $expandeduncertaintypercent = ($expandeduncertainty / $testpoint) * 100;
                $cmcuncertainty = $expandeduncertaintypercent;

                if ($rowcalibpoint['unit'] == 12) {
                    $cmcuncertainty = $expandeduncertainty;
                }
                $searchmaster = "";
                $masterids = explode(",", $rowcalibpoint['masterinstid']);
                $text = "";
                foreach ($masterids as $miv) {
                    if (!empty($text)) {
                        $text .= " or ";
                    }
                    $text .= "  find_in_set(" . $miv . ",masters)";
                }
                $searchmaster = "and ($text)";
                $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and location='" . $rowinwarditem['location'] . "' and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowcalibpoint['unittype']) . "',LOWER(`parameter`)) and mode='" . $rowcalibpoint['mastermode'] . "' $searchmaster ");

                if ($this->total_rows($checkcmcreuslt)) {
                    $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                    $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                    $cmcuncertainty = ($tempcmc > $cmcuncertainty) ? $tempcmc : $cmcuncertainty;
                }
                $n['expandeduncertainty'] = $cmcuncertainty;

                $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
            }
        }
    }

    public function saveucertantyutm($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $rowmatrix['leastcount'];
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "'  order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);

                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if ($num2) {
                    if ($num3) {
                        $cmcunit = $row2['cmcunit'];
                        $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
                    } else {
                        $masterunc = $row2['cmc'];
                        $cmcunit = $row2['cmcunit'];
                    }
                } else {
                    if ($num3) {
                        $masterunc = $row3['cmc'];
                        $cmcunit = $row3['cmcunit'];
                    }
                }
            }
            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");

            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");
            $master1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=1");
            $master2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=2");
            $averagemaster = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and (repeatable>=0 and repeatable<=4)");
            $maxzeroerror = $this->selectfieldwhere("$summarytable", "max(CAST(value AS DECIMAL(10,2) ))", "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowmatrix['id'] . " and type='zeroerror'");
            $releativeresolution = ($leastcount / $rowcalibpoint['point']) * 100;

            $typea = (($repeatability / sqrt(3)) / $averagemaster) * 100;
            //            $comuncer = sqrt(pow($typea, 2) + pow(($masteraccuracy / sqrt(3)), 2) + pow(($masterunc( * $averagemaster / 100) / 2, 2) + pow($leastcount / 2 / SQRT(3), 2));
            $comuncer = sqrt(pow($typea, 2) + pow(($masterunc / 2), 2) + pow(($maxzeroerror / sqrt(3)), 2) + pow((($releativeresolution / 2) / sqrt(3)), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;

            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(`parameter`)) and mode like '" . $rowmastermatrix['mode'] . "'");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantyvc($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultunittype = $this->selectextrawhereupdate("crfmatrix$tablesuffix", "id,matrixtype", "crfitemid='$instid' and status=1 group by matrixtype ");
        while ($rowunittype = $this->fetch_assoc($resultunittype)) {

            $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and matrixid='" . $rowunittype['id'] . "' and status=1 order by convert(point,DECIMAL) desc limit 0,1");
            while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
                $testunit = $rowcalibpoint['unit'];
                $testpoint = $rowcalibpoint['point'];
                if (isset($rowcalibpoint['masterunit']) && (!empty($rowcalibpoint['masterunit'])) && $rowcalibpoint['masterunit'] != $rowcalibpoint['unit']) {
                    $testunit = $rowcalibpoint['unit'];

                    $testpoint = $rowcalibpoint['point'];
                    $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                    if ($this->total_rows($resultconversion1)) {
                        $rowconversion1 = $this->fetch_assoc($resultconversion1);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                    } else {
                        $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                        if ($this->total_rows($resultconversion2)) {
                            $rowconversion2 = $this->fetch_assoc($resultconversion2);
                            $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        }
                    }
                }
                $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
                $rowmatrix = $this->fetch_assoc($resultmatrix);
                $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
                $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
                $masterunc = 0;
                $leastcount = $this->unitconversion($rowcalibpoint['masterunit'], $rowcalibpoint['unit'], $rowmatrix['leastcount']);

                $masterunc = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(cmc*cmc))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
                $masterunc = $masterunc / 1000;
                $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

                $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
                $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
                $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
                $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
                $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
                $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
                $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
                $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc'");

                $typea = $repeatability / sqrt(5);
                $leastcount = $rowmatrix['leastcount'];
                $thermalcomaster = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffmaster' and repeatable=0");
                $thermalcouuc = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='thermalcoffuuc' and repeatable=0");
                $thermalcomaster = $thermalcomaster * pow(10, -6);
                $thermalcouuc = $thermalcouuc * pow(10, -6);
                $diffofthercoff = abs($thermalcouuc - $thermalcomaster);
                if ($diffofthercoff == 0) {
                    $diffofthercoff = 0.000001;
                }
                $uncertaintytempdevice = 0;
                $resultsupportmastermatrix = $this->selectextrawhere("masterscopematrix", "certificateid in (" . $rowcalibpoint['supportvalidityid'] . ") and unit =12 and masterid in (select id from mminstrument where type like '357' and id in (" . $rowcalibpoint['supportmasterinstid'] . ")) order by cmc desc");
                if ($this->total_rows($resultsupportmastermatrix)) {
                    $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                    $uncertaintytempdevice = $rowsupportmastermatrix['cmc'];
                }

                $uncertaintytempdevicemm = $averageuuc * $thermalcomaster * $uncertaintytempdevice;
                $stduncthercof20 = $averageuuc * $diffofthercoff * 2 * 0.2;
                $stduncdiffinmasuuc = $averageuuc * $diffofthercoff * 2 * 0.5;
                $uncduetoparalism = 0;
                if (strtolower(trim($rowmatrix['matrixtype'])) == trim("external measurement")) {
                    $uncduetoparalism = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='parallexternal' and repeatable=0");
                }
                if (strtolower(trim($rowmatrix['matrixtype'])) == "internal measurement") {
                    $uncduetoparalism = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $instid . " and type='parallinternal' and repeatable=0");
                }
                $uncduetoparalism = $uncduetoparalism / 1000;
                $uncduetoerror = 0;
                $uncduetoerror = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(drift*drift))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
                $uncduetoerror = $uncduetoerror / 2000;
                $comuncer = SQRT(pow($typea, 2) + pow(($masterunc / 2), 2) + pow(($leastcount / 2 / SQRT(3)), 2) + pow(($uncertaintytempdevicemm / SQRT(3)), 2) + pow(($stduncthercof20 / SQRT(3)), 2) + pow(($stduncdiffinmasuuc / SQRT(3)), 2) + pow(($uncduetoparalism / SQRT(3)), 2) + pow(($uncduetoerror / SQRT(3)), 2));

                if (!empty($repeatability)) {
                    $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
                } else {
                    $dof = "-";
                }
                $coveragefactor = 2;
                $expandeduncertainty = $comuncer * $coveragefactor * 1000;
                $cmcuncertainty = $expandeduncertainty;
                $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(TRIM(`parameter`)))  and location  like '" . $rowinwarditem['location'] . "'");

                if ($this->total_rows($checkcmcreuslt)) {
                    $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                    $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                    $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
                }
                $n['expandeduncertainty'] = $cmcuncertainty;

                $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
            }
        }
    }

    public function saveucertantyvht($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $testunit = $rowcalibpoint['unit'];
            $testpoint = $rowcalibpoint['point'];
            if (isset($rowcalibpoint['calculationunit']) && (!empty($rowcalibpoint['calculationunit'])) && $rowcalibpoint['calculationunit'] != $rowcalibpoint['unit']) {
                $testunit = $rowcalibpoint['unit'];

                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['calculationunit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);
                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['calculationunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    }
                }
            }
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'  and status=1");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $masterunc = 0;
            $leastcount = $rowmatrix['leastcount'];
            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "'  order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);

                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "' order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if ($num2) {
                    if ($num3) {
                        $cmcunit = $row2['cmcunit'];
                        $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
                    } else {
                        $masterunc = $row2['cmc'];
                        $cmcunit = $row2['cmcunit'];
                    }
                } else {
                    if ($num3) {
                        $masterunc = $row3['cmc'];
                        $cmcunit = $row3['cmcunit'];
                    }
                }
            }
            $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=1");
            $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=2");
            $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=3");
            $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=4");
            $mean = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='caverageuuc' and repeatable=0");
            $averageuuc = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuuc' and repeatable=0");
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' ");
            $sensitivitycoff = (2 * $master0) / $mean;

            $typea = $repeatability / sqrt(5) * 1.15;
            $comuncer = sqrt(pow($typea, 2) + pow(($masterunc) / 2, 2) + pow(($leastcount / 2 / SQRT(3) * $sensitivitycoff), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            $expandeduncertaintypercent = ($expandeduncertainty / $testpoint) * 100;
            $cmcuncertainty = $expandeduncertaintypercent;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(`parameter`)) ");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertaintypercent) ? $tempcmc : $expandeduncertaintypercent;
            }
            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantyvol($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);

        $i = 1;
        $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and status=1");
        while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
            $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "id='" . $rowcalibpoint['matrixid'] . "'");
            $rowmatrix = $this->fetch_assoc($resultmatrix);
            $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "'");
            $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
            $testunit = $rowcalibpoint['unit'];
            $uucunit = $rowcalibpoint['unit'];
            $masterunit = $rowmastermatrix['unit'];
            $testpoint = $rowcalibpoint['point'];
            $leastcount = $rowmatrix['leastcount'];
            if (isset($masterunit) && (!empty($masterunit)) && $masterunit != $uucunit) {
                $testunit = $masterunit;
                //echo 123;
                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['masterunit'] . "' and tounit='" . $rowcalibpoint['unit'] . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);

                    $testpoint = $rowcalibpoint['point'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    $masterleastcount = $rowmastermatrix['leastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    $leastcount = $rowmatrix['leastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                    $mlc = 0;
                    //
                    if ($masterleastcount != "NA") {
                        $mlc = 0;
                        $temp1 = explode(".", $masterleastcount);
                        if (count($temp1) > 1) {
                            $temp2 = end($temp1);
                            $mlc = strlen($temp2);
                        }
                    } else {
                        $mlc = "NA";
                    }

                    //                    $testpoint = sprintf("%.0" . $mlc . "f", $testpoint);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='" . $rowcalibpoint['masterunit'] . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $testpoint = $rowcalibpoint['point'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                        $leastcount = $rowmatrix['leastcount'] * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                        //                     $masterleastcount = $rowcalibpoint ['masterleastcount'] * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                        $mlc = 0;
                        //
                        if ($masterleastcount != "NA") {
                            $mlc = 0;
                            $temp1 = explode(".", $masterleastcount);
                            if (count($temp1) > 1) {
                                $temp2 = end($temp1);
                                $mlc = strlen($temp2);
                            }
                        } else {
                            $mlc = "NA";
                        }

                        //                        $testpoint = sprintf("%.0" . $mlc . "f", $testpoint);
                    }
                }
            }

            $masterleastcount = $rowmastermatrix['leastcount'];
            $masterunc = 0;

            $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "')   order by `point` asc limit 0,1";
            $result2 = $this->execute($sql2);
            $num2 = $this->total_rows($result2);
            if ($num2) {
                $row2 = $this->fetch_assoc($result2);
                $masterunc = $row2['cmc'];
                $cmcunit = $row2['cmcunit'];
            } else {
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` >'" . $testpoint . "' and (`unit` like '" . $testunit . "')  order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);

                $num2 = $this->total_rows($result2);
                $row2 = $this->fetch_assoc($result2);
                $sql3 = "select * from masterscopematrix where certificateid in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and `point` <'" . $testpoint . "' and (unit like '" . $testunit . "')  order by point desc limit 0,1";
                $result3 = $this->execute($sql3);
                $num3 = $this->total_rows($result3);
                $row3 = $this->fetch_assoc($result3);

                if ($num2) {
                    if ($num3) {
                        $cmcunit = $row2['cmcunit'];
                        $masterunc = cmcinterpolation($row3['point'], $row2['point'], $row3['cmc'], $row2['cmc'], $testpoint);
                    } else {
                        $masterunc = $row2['cmc'];
                        $cmcunit = $row2['cmcunit'];
                    }
                } else {
                    if ($num3) {
                        $masterunc = $row3['cmc'];
                        $cmcunit = $row3['cmcunit'];
                    }
                }
            }
            $zvalue = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='zvalue' and repeatable=0");
            $master0 = ($this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0")) * $zvalue;
            $master1 = ($this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=1")) * $zvalue;
            $master2 = ($this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=2")) * $zvalue;
            $master3 = ($this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=3")) * $zvalue;
            $master4 = ($this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=4")) * $zvalue;
            $master5 = ($this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=5")) * $zvalue;
            $master6 = ($this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=6")) * $zvalue;
            $master7 = ($this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=7")) * $zvalue;
            $master8 = ($this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=8")) * $zvalue;
            $master9 = ($this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=9")) * $zvalue;

            $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uuc' and repeatable=0");
            $averagemaster = ($this->selectfieldwhere("$summarytable", 'value*' . $zvalue, "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averagemaster' and repeatable=0"));
            $error = $this->selectfieldwhere("$summarytable", 'value', " instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='error' and repeatable=0");
            $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value*' . $zvalue . ')', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and (repeatable>=0 and repeatable<=9)");

            $masteraccuracy = $rowmastermatrix['uniformity'];
            //
            $uncertaintytempdevice = 0;
            $resultsupportmastermatrix = $this->selectextrawhere("masterscopematrix", "certificateid in (" . $rowcalibpoint['supportvalidityid'] . ") and unit =12 and masterid in (select id from mminstrument where type like '357' and id in (" . $rowcalibpoint['supportmasterinstid'] . ")) order by cmc desc");
            if ($this->total_rows($resultsupportmastermatrix)) {
                $rowsupportmastermatrix = $this->fetch_assoc($resultsupportmastermatrix);
                $uncertaintytempdevice = $rowsupportmastermatrix['cmc'];
            }
            $uncertaintyinwater = $uncertaintytempdevice * 0.00021;

            $typea = $repeatability / sqrt(10);
            $comuncer = sqrt(pow($typea, 2) + pow(($masteraccuracy / sqrt(3)), 2) + pow($masterunc / 2, 2) + pow(($uncertaintyinwater / sqrt(3)), 2) + pow($masterleastcount / 2 / SQRT(3), 2));
            if (!empty($repeatability)) {
                $dof = pow($comuncer, 9) / (pow($typea, 9) / 9);
            } else {
                $dof = "-";
            }
            $coveragefactor = 2;
            $expandeduncertainty = $comuncer * $coveragefactor;
            //            echo $rowcalibpoint['point']."=".$expandeduncertainty."<br>";
            if (isset($masterunit) && (!empty($masterunit)) && $masterunit != $uucunit) {
                $testunit = $masterunit;
                $testpoint = $rowcalibpoint['point'];
                $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $uucunit . "' and tounit='" . $masterunit . "'");
                if ($this->total_rows($resultconversion1)) {
                    $rowconversion1 = $this->fetch_assoc($resultconversion1);

                    $expandeduncertainty = $expandeduncertainty * ($rowconversion1['fromvalue'] / $rowconversion1['tovalue']);
                } else {
                    $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='" . $masterunit . "' and tounit='" . $uucunit . "'");
                    if ($this->total_rows($resultconversion2)) {
                        $rowconversion2 = $this->fetch_assoc($resultconversion2);
                        $expandeduncertainty = $expandeduncertainty * ($rowconversion2['tovalue'] / $rowconversion2['fromvalue']);
                    }
                }
            }
            $cmcuncertainty = $expandeduncertainty;
            $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $rowcalibpoint['point'] . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $rowcalibpoint['unit'] . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(`parameter`))");

            if ($this->total_rows($checkcmcreuslt)) {
                $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);

                $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
            }

            $n['expandeduncertainty'] = $cmcuncertainty;

            $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
        }
    }

    public function saveucertantywb($instid, $inwardid)
    {
        $resultinward = $this->selectextrawhere("inwardentry", "id=$inwardid");
        $rowinward = $this->fetch_assoc($resultinward);
        $tablesuffix = changedateformatespecito($rowinward['addedon'], "Y-m-d H:i:s", "Ymd");
        $resultinwarditem = $this->selectextrawhere("crfinstrument$tablesuffix", "id=$instid");
        $rowinwarditem = $this->fetch_assoc($resultinwarditem);
        $summarytable = $rowinwarditem['summarytable'];
        $resultlistoinst = $this->selectextrawhere("listofinstruments", "id='" . $rowinwarditem['instid'] . "'");
        $rowlistoinst = $this->fetch_assoc($resultlistoinst);
        $i = 1;
        $resultmatrix = $this->selectextrawhere("crfmatrix$tablesuffix", "crfitemid=$instid and mode like 'Repeatability'  and status=1");
        if ($this->total_rows($resultmatrix)) {
            $rowmatrix = $this->fetch_assoc($resultmatrix);

            $resultcalibpoint = $this->selectextrawhere("crfcalibrationpoint$tablesuffix", "crfitemid=$instid and matrixid='" . $rowmatrix['id'] . "' and status=1");
            while ($rowcalibpoint = $this->fetch_assoc($resultcalibpoint)) {
                $testunit = $rowcalibpoint['unit'];
                $testpoint = $rowcalibpoint['point'];
                $multiplicationfactor = 1;
                if ($rowcalibpoint['unit'] != 58) {
                    $testunit = $rowcalibpoint['unit'];

                    $testpoint = $rowcalibpoint['point'];
                    $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $rowcalibpoint['unit'] . "' and tounit='58'");
                    if ($this->total_rows($resultconversion1)) {
                        $rowconversion1 = $this->fetch_assoc($resultconversion1);
                        $multiplicationfactor = ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                    } else {
                        $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='58' and tounit='" . $rowcalibpoint['unit'] . "'");
                        if ($this->total_rows($resultconversion2)) {
                            $rowconversion2 = $this->fetch_assoc($resultconversion2);
                            $multiplicationfactor = ($rowconversion2['fromvalue'] / $rowconversion2['tovalue']);
                        }
                    }
                }
                $multiplicationfactor = floatval($multiplicationfactor);
                $resultmastermatrix = $this->selectextrawhere("mastermatrix", "id='" . $rowcalibpoint['mastermatrixid'] . "' and status=1");
                $rowmastermatrix = $this->fetch_assoc($resultmastermatrix);
                $masterunc = 0;
                $leastcount = $rowmatrix['leastcount'] * $multiplicationfactor;
                $sql2 = "select * from `masterscopematrix` where `certificateid` in (" . $rowcalibpoint['validityid'] . ") and `masterid` in (" . $rowcalibpoint['masterinstid'] . ") and  `point` ='" . $testpoint . "' and (`unit` like '" . $testunit . "') and unittype like '" . $rowcalibpoint['unittype'] . "'  order by `point` asc limit 0,1";
                $result2 = $this->execute($sql2);
                $masterunc = $this->selectfieldwhere("masterscopematrix", "sqrt(sum(cmc*cmc))", "id in (" . $rowcalibpoint['mastersopematrixid'] . ")");
                $drift = $masterunc / 10;

                $master0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='master' and repeatable=0");

                $uuc0 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucr' and repeatable=0");
                $uuc1 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucr' and repeatable=1");
                $uuc2 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucr' and repeatable=2");
                $uuc3 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucr' and repeatable=3");
                $uuc4 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucr' and repeatable=4");
                $uuc5 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucr' and repeatable=5");
                $uuc6 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucr' and repeatable=6");
                $uuc7 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucr' and repeatable=7");
                $uuc8 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucr' and repeatable=8");
                $uuc9 = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucr' and repeatable=9");

                $averageuuc = $this->selectfieldwhere("$summarytable", 'value', " inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='averageuucr' and repeatable=0");
                $averageuuc = floatval($averageuuc) * $multiplicationfactor;

                $repeatability = $this->selectfieldwhere("$summarytable", 'STDDEV_SAMP(value)', "instid=" . $instid . "  and inwardid=" . $inwardid . " and calibrationpoint=" . $rowcalibpoint['id'] . " and type='uucr'");

                $typea = ($repeatability / sqrt(10)) * $multiplicationfactor;
                $eccentricity = $this->selectfieldwhere("$summarytable", 'value', "instid=" . $instid . "  and inwardid=" . $inwardid . "  and type='eccentricity' and repeatable=0");
                $eccentricityfactor = ($eccentricity * 2 / 3) * $multiplicationfactor;
                $comuncer = sqrt(pow($typea, 2) + pow(($drift / sqrt(3)), 2) + pow(($eccentricityfactor / 2 / sqrt(3)), 2) + pow(($masterunc / 2), 2) + pow($leastcount / 2 / SQRT(3), 2));
                if (!empty($repeatability)) {
                    $dof = pow($comuncer, 4) / pow($repeatability, 4) / 4;
                } else {
                    $dof = "-";
                }
                $coveragefactor = 2;
                $expandeduncertainty = $comuncer * $coveragefactor;
                //                $expandeduncertaintymg = ($expandeduncertainty * 1000);
                $cmcuncertainty = $expandeduncertainty;
                $checkcmcreuslt = $this->selectextrawhere("cmcscope", "'" . $testpoint . "' between `minfrequency` and `maxfrequency` and `unit` = '" . $testunit . "' and FIND_IN_SET ('" . strtolower($rowlistoinst['name']) . "',LOWER(`parameter`)) ");

                if ($this->total_rows($checkcmcreuslt)) {
                    $checkcmcrow = $this->fetch_assoc($checkcmcreuslt);
                    if ($checkcmcrow['cmcunit'] != 58) {

                        $testunit = $rowcalibpoint['unit'];

                        $testpoint = $rowcalibpoint['point'];
                        $resultconversion1 = $this->selectextrawhere("unitconversion", "fromunit='" . $checkcmcrow['cmcunit'] . "' and tounit='58'");
                        if ($this->total_rows($resultconversion1)) {
                            $rowconversion1 = $this->fetch_assoc($resultconversion1);
                            $multiplicationfactor = ($rowconversion1['tovalue'] / $rowconversion1['fromvalue']);
                            $checkcmcrow['mincmc'] = $multiplicationfactor * $checkcmcrow['mincmc'];
                            $checkcmcrow['maxcmc'] = $multiplicationfactor * $checkcmcrow['maxcmc'];
                        } else {
                            $resultconversion2 = $this->selectextrawhere("unitconversion", "fromunit='58' and tounit='" . $checkcmcrow['cmcunit'] . "'");
                            if ($this->total_rows($resultconversion2)) {
                                $rowconversion2 = $this->fetch_assoc($resultconversion2);
                                $multiplicationfactor = ($rowconversion2['fromvalue'] / $rowconversion2['tovalue']);
                                $checkcmcrow['mincmc'] = $multiplicationfactor * $checkcmcrow['mincmc'];
                                $checkcmcrow['maxcmc'] = $multiplicationfactor * $checkcmcrow['maxcmc'];
                            }
                        }
                    }
                    $tempcmc = cmcinterpolation($checkcmcrow['minfrequency'], $checkcmcrow['maxfrequency'], $checkcmcrow['mincmc'], $checkcmcrow['maxcmc'], $testpoint);

                    $cmcuncertainty = ($tempcmc > $expandeduncertainty) ? $tempcmc : $expandeduncertainty;
                }

                $n['expandeduncertainty'] = $cmcuncertainty;

                $this->update("crfcalibrationpoint$tablesuffix", $n, $rowcalibpoint['id']);
            }
        }
    }

    public function sendsmsto($msgto, $type, $customerid, $vehicleid, $allotmentid)
    {
        $rowsmsdata = $this->selectextrawhere("sendsms", "type='$type' and status = 1 and notifyto = 'Customer'")->fetch_assoc();
        $rowallotment = $this->selectextrawhere("allotments", "id='$allotmentid'")->fetch_assoc();

        if ($type == 1) {
            $msgto = (int) $msgto;
            $amount = (is_integer($msgto) && $msgto != 0) ? $msgto : $rowallotment["tokenamount"];
            $rowsmsdata["message"] = str_replace(array("{#var#}"), array($amount), "आपके {#var#} जमा हो गए हे
        ई  सवारी  रेंटल्स प्रा ली ।"); //1207166237615237043
        } elseif ($type == 2) {
            $fiperson = $this->selectfieldwhere("users", "firstname", "id=" . $rowallotment["firesponsibleperson"] . "");
            $rowsmsdata["message"] = str_replace(array("{#var#}"), array($fiperson), "ऐफआई की प्रक्रिया शुरू कर दी गई हे ऐफआई {#var#} आपसे संपर्क करेंगे {#var#}
        ई  सवारी   रेंटल्स प्रा ली ।"); //1207166237634915158
        } elseif ($type == 4) {
            $rowsmsdata["message"] = "";
        } elseif ($type == 5) {
            $rowsmsdata["message"] = "आपकी गाड़ी सुविकरित की गई। कृपया शोरूम पर संप्रक कर अग्रीमन्ट की प्रकिरया पूरी करे । 
            ई  सवारी   रेंटल्स प्रा ली ।"; //1207166237740331325
        } elseif ($type == 6) {
            $rowsmsdata["message"] = "गाड़ी लीस के लिए आपकी ऐफ आई रिजेक्ट हो गई हे । 
            ई  सवारी   रेंटल्स प्रा ली ।"; //1207166237690275485
        } elseif ($type == 14) {
            $netdeposit = $rowallotment["depositamount"] - $rowallotment["tokenamount"];
            $rowsmsdata["message"] = str_replace(array("{#var#}"), array($netdeposit), "आपकी शेष राशि {#var#} कृपया जमा कराए। 
            ई  सवारी   रेंटल्स प्रा ली ।"); //1207166237677643974
        } elseif ($type == 15) {
            $netdeposit = $rowallotment["depositamount"] - $rowallotment["tokenamount"];
            $rowsmsdata["message"] = str_replace(array("{#var#}"), array($netdeposit), "आपके {#var#} रुपए जमा हो गए हे कृपया अग्रीमन्ट की प्रोसेस पूरा करे । 
            ई  सवारी   रेंटल्स प्रा ली ।"); //1207166237697510921
        } elseif ($type == 7) {
            $rowsmsdata["message"] = "";
        } elseif ($type == 8) {
            $rowsmsdata["message"] = "";
        } elseif ($type == 9) {
            $rowsmsdata["message"] = "आपकी गाड़ी अलोट कर दी गई हे कृपया गारी का कलर सिलेक्ट करे । 
            ई  सवारी   रेंटल्स प्रा ली ।"; //1207166237704710528
        }

        $xs['added_on'] = date('Y-m-d H:i:s');
        $xs['added_by'] = $this->employeeid;
        $xs['updated_on'] = date('Y-m-d H:i:s');
        $xs['updated_by'] = $this->employeeid;
        $xs['status'] = 1;
        $xs["message"] = $rowsmsdata["message"];
        $xs["templateid"] = $rowsmsdata["templateid"];
        $xs["employeeid"] = $rowsmsdata["employee"];
        $xs["additionalphone"] = $rowsmsdata["additionalphone"];
        $xs["type"] = $type;
        $xs["customerid"] = $customerid;
        if (!empty($vehicleid)) {
            $xs["vehicleid"] = $vehicleid;
        }
        if (!empty($allotmentid)) {
            $xs["allotmentid"] = $allotmentid;
        }
        $this->insertnew("notification", $xs);
        // echo $xs["message"];
        // echo "<br>".$xs["templateid"];
        $phoneno = $this->selectfieldwhere("users", "mobile", "id=" . $rowallotment["userid"] . "");
        if (isset($rowsmsdata["id"]) && !empty($xs["message"])) {
            $this->notifysms("$phoneno", $xs["templateid"], $xs["message"]); //9993901388
        }
    }

    function calculatecost($vid)
    {
        $vehiclecost = $this->selectfieldwhere("vehicles", "costprice", "id=" . $vid . "");
        if (empty($vehiclecost)) {
            return "No Cost";
        }
        $allotcount = $this->selectfieldwhere("allotments", "count(id)", "vehicleid=" . $vid . " and status != 99");
        if ($allotcount == 0) {
            return $vehiclecost;
        }
        $balancequery = $this->execute("select paymentstatus.allotmentid,paymentstatus.userid,paymentstatus.purpose,sum(price) as credit,sum(paymentstatus.amount) as debit,paymentstatus.startdate as date from paymentstatus
        left join payment_terms on payment_terms.paymentdate = paymentstatus.startdate and payment_terms.vehicle = '$vid' and payment_terms.status != 99
        where paymentstatus.vehicleid='$vid' and paymentstatus.status != 99 group by paymentstatus.startdate ORDER BY date ");
        $i = 1;
        $interest = 0;
        $principleleft = 0;
        while ($query = $this->fetch_assoc($balancequery)) {
            $mode = $this->selectfieldwhere("allotments", "frequency", "id=" . $query["allotmentid"] . "");
            $payment = 0;
            if ($i != 1) {
                $vehiclecost = $principleleft;
                if ($mode == "per day") {
                    $payment = (empty($query['credit'])) ? 0 : $query['credit'];
                    $interest = 33 / (12 * 30) / 100 * ($vehiclecost);
                } elseif ($mode == "per month") {
                    $interest = 33 / 12  / 100 * ($vehiclecost);

                    $lastmonthdate = date("Y-m-d", strtotime("-1 months +1 day", strtotime($query["date"])));
                    $payment = $this->selectfieldwhere("payment_terms", "sum(price)", "payment_terms.paymentdate >= '" . $lastmonthdate . "' and payment_terms.paymentdate <= '" . $query['date'] . "' and purpose != 'Deposit' and allotmentid = '" . $query["allotmentid"] . "'");
                } elseif ($mode == 'per week') {
                    $interest = 33 / (12 * 4.3) / 100 * ($vehiclecost);
                    $lastmonthdate = date("Y-m-d", strtotime("-1 week +1 day", strtotime($query["date"])));
                    $payment = $this->selectfieldwhere("payment_terms", "sum(price)", "payment_terms.paymentdate >= '" . $lastmonthdate . "' and payment_terms.paymentdate <= '" . $query['date'] . "' and purpose != 'Deposit' and allotmentid = '" . $query["allotmentid"] . "'");
                }
            } else {
                $payment = $query['credit'];
            }
            $principleleft = $vehiclecost + $interest - $payment;
            $i++;
        }
        return round($principleleft, 2);
    }

    public
    function __destruct()
    {
        mysqli_close($this->con);
    }
}

function addOrdinalNumberSuffix($num)
{
    if (!in_array(($num % 100), array(11, 12, 13))) {
        switch ($num % 10) {
                // Handle 1st, 2nd, 3rd
            case 1:
                return $num . 'st';
            case 2:
                return $num . 'nd';
            case 3:
                return $num . 'rd';
        }
    }
    return $num . 'th';
}

function changedateformate($dateString)
{
    if ((!empty($dateString)) && ($dateString != "00/00/0000")) {
        $myDateTime = DateTime::createFromFormat('d/m/Y', $dateString);
        //print_r($myDateTime);
        return $myDateTime->format('Y-m-d');
    } else {
        return "";
    }
}

function cmcinterpolation($minrange, $maxrange, $mincmc, $maxcmc, $cmctobefindon)
{
    //    echo $maxrange."-".$minrange;
    if ($maxrange == $minrange) {
        return $mincmc;
    }
    $z2 = ((($cmctobefindon - $minrange) * ($maxcmc - $mincmc)) / ($maxrange - $minrange)) + $mincmc;
    return $z2;
}

function changedateformatespeci($dateString, $speci)
{

    if ((!empty($dateString)) && ($dateString != "0000-00-00") && ($dateString != "0000-00-00 00:00:00")) {
        $myDateTime = DateTime::createFromFormat($speci, $dateString);
        try {
            return $myDateTime->format('Y-m-d');
        } catch (Exception $e) {
            echo $dateString;
            return $dateString;
        }
    } else {
        return "";
    }
}

function getleastcount($value)
{

    $temp1 = explode(".", $value);
    if (count($temp1) > 1) {
        $temp2 = end($temp1);
        $lc = strlen($temp2);
        return $lc;
    } else {
        return 1;
    }
}

function changedateformatespecito($dateString, $speci, $to)
{
    //    echo $dateString;
    if ((!empty($dateString)) && ($dateString != "0000-00-00") && ($dateString != "0000-00-00 00:00:00")) {
        $myDateTime = DateTime::createFromFormat($speci, $dateString);
        if ($myDateTime) {
            $newdate = $myDateTime->format($to);
            //if($newdate!="30")
            return $newdate;
        } else {
            //                    return $myDateTime;
            return $dateString;
        }
    } else {
        return "";
    }
}

function convert_number_to_words($number)
{

    $no = round($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        '0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
        } else
            $str[] = null;
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ?
        "." . $words[$point / 10] . " " .
        $words[$point = $point % 10] : '';
    return $result . "Rupees  ";
}

function convert_number_to_words1($number)
{

    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = array(
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'fourty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'hundred',
        1000 => 'thousand',
        10000 => 'lakh',
        1000000 => 'million',
        1000000000 => 'billion',
        1000000000000 => 'trillion',
        1000000000000000 => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

function zvalue($temp, $pressure, $ref)
{
    $zbar['18.0']['80.0'] = 1.0022;
    $zbar['18.0']['85.0'] = 1.0023;
    $zbar['18.0']['90.0'] = 1.0023;
    $zbar['18.0']['95.0'] = 1.0024;
    $zbar['18.0']['100.0'] = 1.0025;
    $zbar['18.0']['101.3'] = 1.0025;
    $zbar['18.0']['105.0'] = 1.0025;

    $zbar['18.5']['80.0'] = 1.0023;
    $zbar['18.5']['85.0'] = 1.0024;
    $zbar['18.5']['90.0'] = 1.0024;
    $zbar['18.5']['95.0'] = 1.0025;
    $zbar['18.5']['100.0'] = 1.0025;
    $zbar['18.5']['101.3'] = 1.0026;
    $zbar['18.5']['105.0'] = 1.0026;

    $zbar['19.0']['80.0'] = 1.0024;
    $zbar['19.0']['85.0'] = 1.0025;
    $zbar['19.0']['90.0'] = 1.0025;
    $zbar['19.0']['95.0'] = 1.0026;
    $zbar['19.0']['100.0'] = 1.0026;
    $zbar['19.0']['101.3'] = 1.0027;
    $zbar['19.0']['105.0'] = 1.0027;

    $zbar['19.5']['80.0'] = 1.0025;
    $zbar['19.5']['85.0'] = 1.0026;
    $zbar['19.5']['90.0'] = 1.0026;
    $zbar['19.5']['95.0'] = 1.0027;
    $zbar['19.5']['100.0'] = 1.0027;
    $zbar['19.5']['101.3'] = 1.0028;
    $zbar['19.5']['105.0'] = 1.0028;

    $zbar['20.0']['80.0'] = 1.0026;
    $zbar['20.0']['85.0'] = 1.0027;
    $zbar['20.0']['90.0'] = 1.0027;
    $zbar['20.0']['95.0'] = 1.0028;
    $zbar['20.0']['100.0'] = 1.0028;
    $zbar['20.0']['101.3'] = 1.0029;
    $zbar['20.0']['105.0'] = 1.0029;

    $zbar['20.5']['80.0'] = 1.0027;
    $zbar['20.5']['85.0'] = 1.0028;
    $zbar['20.5']['90.0'] = 1.0028;
    $zbar['20.5']['95.0'] = 1.0029;
    $zbar['20.5']['100.0'] = 1.0029;
    $zbar['20.5']['101.3'] = 1.0030;
    $zbar['20.5']['105.0'] = 1.0030;

    $zbar['21.0']['80.0'] = 1.0028;
    $zbar['21.0']['85.0'] = 1.0029;
    $zbar['21.0']['90.0'] = 1.0029;
    $zbar['21.0']['95.0'] = 1.0030;
    $zbar['21.0']['100.0'] = 1.0031;
    $zbar['21.0']['101.3'] = 1.0031;
    $zbar['21.0']['105.0'] = 1.0031;

    $zbar['21.5']['80.0'] = 1.0030;
    $zbar['21.5']['85.0'] = 1.0030;
    $zbar['21.5']['90.0'] = 1.0031;
    $zbar['21.5']['95.0'] = 1.0031;
    $zbar['21.5']['100.0'] = 1.0032;
    $zbar['21.5']['101.3'] = 1.0032;
    $zbar['21.5']['105.0'] = 1.0032;

    $zbar['22.0']['80.0'] = 1.0031;
    $zbar['22.0']['85.0'] = 1.0031;
    $zbar['22.0']['90.0'] = 1.0032;
    $zbar['22.0']['95.0'] = 1.0032;
    $zbar['22.0']['100.0'] = 1.0033;
    $zbar['22.0']['101.3'] = 1.0033;
    $zbar['22.0']['105.0'] = 1.0033;

    $zbar['22.5']['80.0'] = 1.0032;
    $zbar['22.5']['85.0'] = 1.0032;
    $zbar['22.5']['90.0'] = 1.0033;
    $zbar['22.5']['95.0'] = 1.0033;
    $zbar['22.5']['100.0'] = 1.0034;
    $zbar['22.5']['101.3'] = 1.0034;
    $zbar['22.5']['105.0'] = 1.0034;

    $zbar['23.0']['80.0'] = 1.0033;
    $zbar['23.0']['85.0'] = 1.0033;
    $zbar['23.0']['90.0'] = 1.0034;
    $zbar['23.0']['95.0'] = 1.0034;
    $zbar['23.0']['100.0'] = 1.0035;
    $zbar['23.0']['101.3'] = 1.0035;
    $zbar['23.0']['105.0'] = 1.0036;

    $zbar['23.5']['80.0'] = 1.0034;
    $zbar['23.5']['85.0'] = 1.0035;
    $zbar['23.5']['90.0'] = 1.0035;
    $zbar['23.5']['95.0'] = 1.0036;
    $zbar['23.5']['100.0'] = 1.0036;
    $zbar['23.5']['101.3'] = 1.0036;
    $zbar['23.5']['105.0'] = 1.0037;

    $zbar['24.0']['80.0'] = 1.0035;
    $zbar['24.0']['85.0'] = 1.0036;
    $zbar['24.0']['90.0'] = 1.0036;
    $zbar['24.0']['95.0'] = 1.0037;
    $zbar['24.0']['100.0'] = 1.0037;
    $zbar['24.0']['101.3'] = 1.0038;
    $zbar['24.0']['105.0'] = 1.0038;

    $zbar['24.5']['80.0'] = 1.0037;
    $zbar['24.5']['85.0'] = 1.0037;
    $zbar['24.5']['90.0'] = 1.0038;
    $zbar['24.5']['95.0'] = 1.0038;
    $zbar['24.5']['100.0'] = 1.0039;
    $zbar['24.5']['101.3'] = 1.0039;
    $zbar['24.5']['105.0'] = 1.0039;

    $zbar['25.0']['80.0'] = 1.0038;
    $zbar['25.0']['85.0'] = 1.0038;
    $zbar['25.0']['90.0'] = 1.0039;
    $zbar['25.0']['95.0'] = 1.0039;
    $zbar['25.0']['100.0'] = 1.0040;
    $zbar['25.0']['101.3'] = 1.0040;
    $zbar['25.0']['105.0'] = 1.0040;

    $zbar['25.5']['80.0'] = 1.0039;
    $zbar['25.5']['85.0'] = 1.0040;
    $zbar['25.5']['90.0'] = 1.0040;
    $zbar['25.5']['95.0'] = 1.0041;
    $zbar['25.5']['100.0'] = 1.0041;
    $zbar['25.5']['101.3'] = 1.0041;
    $zbar['25.5']['105.0'] = 1.0042;

    $zbar['26.0']['80.0'] = 1.0040;
    $zbar['26.0']['85.0'] = 1.0041;
    $zbar['26.0']['90.0'] = 1.0041;
    $zbar['26.0']['95.0'] = 1.0042;
    $zbar['26.0']['100.0'] = 1.0042;
    $zbar['26.0']['101.3'] = 1.0043;
    $zbar['26.0']['105.0'] = 1.0043;

    $zbar['26.5']['80.0'] = 1.0042;
    $zbar['26.5']['85.0'] = 1.0042;
    $zbar['26.5']['90.0'] = 1.0043;
    $zbar['26.5']['95.0'] = 1.0043;
    $zbar['26.5']['100.0'] = 1.0044;
    $zbar['26.5']['101.3'] = 1.0044;
    $zbar['26.5']['105.0'] = 1.0044;

    //    $temp = 25;
    //    $pressure = 95;
    $temp = sprintf("%.01f", $temp);
    $pressure = sprintf("%.01f", $pressure);
    $zfactor = $zbar[$temp][$pressure];
    return $zfactor;
    //    $averagemg = 5;
    //    $averageml = 5.0185;
    //    $meanvalue =round(($averagemg*$zfactor),4);
    //    $accuracy=$meanvalue-$ref;
    //    $accracyper=($accuracy/$ref)*100;
    //z=1/
}

function PlaceWatermark($file, $text, $xxx, $yyy, $op, $outdir, $name, $dirname = "directdigitalsignature", $logo = "idcardlogo.png", $debug = 0)
{



    if (!file_exists($dirname)) {
        mkdir($dirname, 0777);
    }
    $name = $dirname . "/" . $name;

    $font_size = $xxx;
    $ts = explode("\n", $text);
    $width = 0;
    foreach ($ts as $k => $string) {
        $width = max($width, strlen($string));
    }
    $iw = ($logo == "") ? 0 : (($xxx == 2) ? 35 : 20);
    $sw = ($logo == "") ? 0 : (($xxx == 2) ? 40 : 19);
    if ($debug) {
        echo $iw;
        echo "<br>";
        echo $sw;
    }
    $width = (imagefontwidth($font_size) * $width) + $sw;

    $height = imagefontheight($font_size) * count($ts);
    $el = imagefontheight($font_size);
    $em = imagefontwidth($font_size);
    $img = imagecreatetruecolor($width, $height);
    // Background color
    $bg = imagecolorallocate($img, 255, 255, 255);
    imagefilledrectangle($img, 0, 0, $width, $height, $bg);
    // Font color


    $color = imagecolorallocate($img, 0, 0, 0);
    foreach ($ts as $k => $string) {
        $len = strlen($string);
        $ypos = 0;
        for ($i = 0; $i < $len; $i++) {
            $xpos = $i * $em;
            $ypos = $k * $el;
            imagechar($img, $font_size, $xpos + $iw, $ypos, $string, $color);
            $string = substr($string, 1);
        }
    }
    imagecolortransparent($img, $bg);
    $blank = imagecreatetruecolor($width, $height);
    $tbg = imagecolorallocate($blank, 255, 255, 255);
    imagefilledrectangle($blank, 0, 0, $width, $height, $tbg);
    imagecolortransparent($blank, $tbg);

    if (($op < 0) or ($op > 100)) {
        $op = 100;
    }
    imagecopymerge($blank, $img, 0, 0, 0, 0, $width, $height, $op);

    //imagepng($blank,$name.".png");
    if (!empty($logo)) {
        //                $logo = trim($logo);
        //
        //                $stamp = imagecreatefrompng($logo);
        //                $sx = imagesx($stamp);
        //                $sy = imagesy($stamp);
        //                $ratio = ($height / $sy);
        //                $sx = intval($sx * $ratio);
        //                $sy = $height;
        //
        //                imagecopyresampled($stamp, $stamp, 0, 0, 0, 0, $sx, $sy, imagesx($stamp), imagesy($stamp));
        //                imagecopymerge($blank, $stamp, 0, 0, 0, 0, $sx, $sy, 100);
    }

    imagepng($blank, $name . ".png");
    // Created Watermark Image
    return $name . ".png";
}

function Stand_Deviation($arr)
{
    $num_of_elements = count($arr);

    $variance = 0.0;

    // calculating mean using array_sum() method
    $average = array_sum($arr) / $num_of_elements;

    foreach ($arr as $i) {
        // sum of squares of differences between
        // all numbers and means.
        $variance += pow(($i - $average), 2);
    }

    return (float) sqrt($variance / $num_of_elements);
}

function getFinancialYear($today)
{
    //    $today = date("Y-m-d");
    $month = date("m", strtotime($today));
    $year = date("y", strtotime($today));
    $financialYear = "";
    if ($month < 4) {
        $financialYear = ($year - 1) . "-" . $year;
    } else {
        $financialYear = ($year) . "-" . ($year + 1);
    }
    return $financialYear;
}

function getfirstandlastday($today)
{
    $month = date("m", strtotime($today));
    $year = date("Y", strtotime($today));
    $startdate = "";
    $enddate = "";
    if ($month < 4) {
        $financialYear = ($year - 1) . "-" . $year;
        $startdate = ($year - 1) . "-04-01";
        $enddate = $year . "-03-31";
    } else {
        $financialYear = ($year) . "-" . ($year + 1);
        $startdate = $year . "-04-01";
        $enddate = ($year + 1) . "-03-31";
    }
    return array("startdate" => $startdate, "enddate" => $enddate);
}
