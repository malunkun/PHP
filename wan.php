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
    if(!empty($_POST["set"])){//4G拨号不支持
        if($_POST["set"][0] == 1)
            echo json_encode($wan->setDHCPDNS($_POST["setDHCP"][2]));
        if($_POST["set"][0] == 2){
            if($wan->setStaticIP($_POST["set"][1],$_POST["set"][2]) && $wan->setStaticRoute($_POST["set"]))
                return json_encode("true");
            else
                return json_encode("false");
        }
    }
}
?>
