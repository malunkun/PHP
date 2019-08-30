<?php
include_once "./sysctl/systemctl.php";
$wlan = new wifi;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["wifiName"]))
        if(!empty($_POST["wifiWpa"]))
            if(!empty($_POST["wifiPasswd"]))
                if(!empty($_POST["wifiChannel"])){
                    $name = $wlan->setWifiName($_POST["wifiName"]);
                    $wpa = $wlan->setWifiWpakey($_POST["wifiWpa"]);
                    $passwd = $wlan->setWifiPasswd($_POST["wifiPasswd"]);
                    $channel = $wlan->setWifiChannel($_POST["wifiChannel"]);
                    if($name==true&&$wpa==true&&$passwd==true&&$channel==true)
                        echo json_encode("true");
                    else
                        echo json_encode("false");
                }
}
?>
