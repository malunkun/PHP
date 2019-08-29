<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $file = fopen("./user.db","r");
    $filestr = fgets($file);
    $oldpasswd = str_replace("\n","",$filestr);
    if($oldpasswd === strval(md5($_POST["login"])))
        return true;
    else
        return false;
}
?>
