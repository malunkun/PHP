<?php
include_once "./sysctl/systemctl.php";
$tool = new systemTool;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["reboot"]))
        echo json_encode($tool->reboot());
    if(!empty($_POST["getDate"]))
        echo json_encode($tool->getSystemDate());
    if(!empty($_POST["setDate"]))
        echo json_encode($tool->setSystemDate($_POST[setDate]));
    if(!empty($_POST["changePasswd"])){//changePasswd数组,(0=>"oldpasswd",1=>"newpasswd")
        $passwd = $_POST["changePasswd"];
        ehco json_encode($tool->changePasswd($passwd[0],$passwd[1]));
    }
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
echo json_encode("get");
}
?>
