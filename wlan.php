<?php
include_once "./sysctl/systemctl.php";
$wlan = new wifi;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["wlanSet"])){
        $var = $_POST["wlanSet"];
        echo json_encode(setwlan($var[0],$var[1],$var[2],$var[3]));
    }
}

function setwlan($name,$wpa,$passwd,$channel){
    if($wlan->setWifiName($name)&&$wlan->setWifiWpakey($wpa)&&$wlan->setWifiPasswd($passwd)&&$wlan->setWifiChannel($channel))
        return true;
    else
        return false;
}
?>
