<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){//postname: login
    $file = fopen("./user.db","r");
    $filestr = fgets($file);
    $oldpasswd = str_replace("\n","",$filestr);
    if($oldpasswd === strval(md5($_POST["login"])))
        echo json_encode("true");
    else
        echo json_encode("false");
}
?>
