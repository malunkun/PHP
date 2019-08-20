<?php
include_once "./systemctl.php";

$wifi = new wifi;
echo $wifi->getWifiName().PHP_EOL;
echo $wifi->getWifiPasswd().PHP_EOL;
echo $wifi->getWifiChannel().PHP_EOL;
echo $wifi->getWifiWpakey().PHP_EOL;
?>
