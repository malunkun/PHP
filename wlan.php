<?php
include_once "./sysctl/systemctl.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["wlanSet"])){
        $var = $_POST["wlanSet"];
        echo json_encode(setwlan($var[0],$var[1],$var[2]));//name,passwd,channel
    }
    if(!empty($_POST["wlanGet"])){
        echo json_encode(getwlan());//传回数组(0=>name,1=>passwd,2=>channel)
    }
}

function setwlan($name,$passwd,$channel){
    $wlan = new wifi;
    if($wlan->setWifiName($name)&&$wlan->setWifiPasswd($passwd)&&$wlan->setWifiChannel($channel))
        return true;
    else
        return false;
}
function getwlan(){
    $wlan = new wifi;
    $name = $wlan->getWifiName();
    $passwd = $wlan->getWifiPasswd();
    $channel = $wlan->getWifiChannel();
    $arr = array($name,$passwd,$channel);
    if($name&&$passwd&&$channel)
        return $arr;
    else
        return "false";
}
?>
