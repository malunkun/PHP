<?php
include_once "./sysctl/systemctl.php";
$lan = new lan;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["lanInfo"])){
        $startIp = $lan->getStartIp();
        $endIp = $lan->getEndIp();
        $time = $lan->getTime();
        $mac = $lan->getMac();
        $arr = array($startIp,$endIp,$time,$mac);
        echo json_encode($arr);//数组(0=>startIP,1=>endIP,2=>租约时长min,3=>mac地址)
    }
    if(!empty($_POST["lanIP"])){
        echo json_encode($lan->getIp());//局域网IP
    }
    if(!empty($_POST["setDHCP"])){//传入数组(0=>startip,1=>endip,2=>租约.分钟),mac不更改
        echo json_encode($lan->setDHCP());
    }
    if(!empty($_POST["setLanIp"])){//传IP
        echo json_encode($lan->setLanIp($_POST["setLanIp"]));
    }
}
?>
