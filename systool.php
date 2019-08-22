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
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
echo "get";
}
?>
