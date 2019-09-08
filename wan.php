<?php
include_once "./sysctl/systemctl.php";
$wan = new wan;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["netInfo"])){
        $type = $wan->getNetType();
        $ip = $wan->getIp();
        $mask = $wan->getMask();
        $rount = $wan->getRount();
        $dns = $wan->getDns();
        $arr = array($type,$ip,$mask,$rount,$dns);
        echo json_encode($arr);
    }
}
?>
