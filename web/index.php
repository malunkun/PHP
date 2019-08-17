<?php
include_once "./systemctl.php";

$wifi = new wifi;
echo $wifi->getWifiName();
echo $wifi->getWifiPasswd();
echo $wifi->getWifiChannel();
echo $wifi->getWifiWpakey();
?>
