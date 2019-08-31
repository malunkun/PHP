<?php
include_once "./sysctl/systemctl.php";
$status = new systemTool;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["cpuPercent"])){
        echo json_encode($status->getCpuUsed());
    }
    if(!empty($_POST["memPercent"])){
        echo json_encode($status->getMemUsed());
    }
}
?>
