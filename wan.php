<?php
include_once "./sysctl/systemctl.php";
$wan = new wan;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["netInfo"])){
        $info = $wan->getNetInfo();
        if($info != false){
            echo json_encode($info);
        }else
            echo json_encode("false");
    }
}
?>
