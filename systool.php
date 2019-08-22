<?php
include_once "./systemctl.php";
$tool = new systemTool;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    echo "post";
    if($_REQUEST["reboot"])
        echo json_decode($tool->reboot());
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
echo "get";
}
?>
