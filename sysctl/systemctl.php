<?php
class systemTool{//系统工具
		function reboot(){//重启，失败返回false
			exec("reboot",$result,$status);
			if($status != 0)
				return false;
	}
		function getSystemDate($format="'%Y-%m-%d %H:%M:%S'"){//,参数为时间格式字符串，获取系统时间，成功返回时间，失败返回false
			$shell = "date +$format";
			exec($shell,$result,$status);
			if($status != 0)
				return false;
			return $result[0];
        }
        function setSystemDatebyntp($ntpserver){//未完成模块
            $shell = "ntpdate ".$ntpserver;
            exec($shell,$result,$status);
            if($status != 0)
                return false;
            else
                return true;
        }
        function setSystemDate($date){
            $shell = "date --set ".$date;
            exec($shell,$result,$status);
            if($status != 0)
                return false;
            else
                return true;
        }
        function getMemUsed(){//返回内存使用率，未化为百分制
            exec("free",$result,$status);
            if($status != 0)
                return false;
            $str = preg_replace('/\s+/','/',$result[1]);
            $result = explode("/",$str);
            return round((intval($result[1])-intval($result[3]))/intval($result[1])*100,2);
        }
        function getCpuUsed(){//cpu使用率
            $file = fopen("/proc/stat","r");
            if($file == false)
                return false;
            $str = fgets($file);
            $str = preg_replace('/\s+/','/',$str);
            $result = explode("/",$str);
            $sum = 0;
            for($i=1;$i<count($result)-1;$i++){
                $sum += $result[$i];
            }
            return round(($sum-intval($result[4]))/$sum*100,2);
        }
        function changePasswd($oldpasswd,$newpasswd){//更改管理员密码
            $file = fopen("user.db","r");
            if($file == false)
                return false;
            $filestr = str_replace("\n","",fgets($file));
            fclose($file);
            if(md5($oldpasswd) === $filestr){
                $file = fopen("user.db","w");
                if($file == false)
                    return false;
                if(fputs($file,md5($newpasswd)) != false){
                    fclose($file);
                    return true;
                }else
                    return false;
            }else
                return false;
        }
}

class wifi{//wifi的设置以及已设置的信息获取
    const wifiConf = "/var/www/html/PHP/sysctl/wifi.conf";//配置文件路径
	const nameset	  = "ssid=";
    const passwdset	  = "wpa_passphrase=";
	const channelset	  = "channel=";
	const wpakeyset	  = "wpa_key_mgmt=";
    /*setter*/
	function setWifiName($wifiName){//wifi名称
        $file = fopen(self::wifiConf,"r");
        if(!$file){
            return false;
        }
        while(!feof($file)){
            $filestr = fgets($file);
            if(stristr($filestr,self::nameset)){
                $oldname =  $filestr;
            }
        }
        if($oldname == ""){
            return false;
        }
        fclose($file);
        $allFile = file_get_contents(self::wifiConf);
        $allFile = str_replace($oldname,self::nameset.$wifiName."\n",$allFile);
        file_put_contents(self::wifiConf,$allFile);
        return true;
    }

    function setWifiPasswd($wifiPasswd){//wifi 密码
        $file = fopen(self::wifiConf,"r");
        while(!feof($file)){
            $filestr = fgets($file);
            if(stristr($filestr,self::passwdset)){
                $oldpasswd =  $filestr;
            }
        }
        fclose($file);
        $allFile = file_get_contents(self::wifiConf);
        $allFile = str_replace($oldpasswd,self::passwdset.$wifiPasswd."\n",$allFile);
        file_put_contents(self::wifiConf,$allFile);
        return true;
    }
    function setWifiChannel($channel){//wifi信道
        if(!preg_match("/^[0-9]{1,2}$/",$channel))
            return false;
        if(intval($channel)<=0&&intval($channel)>13)//与上面正则表达式判断信道是否是1-13的数字
            return false;
        $file = fopen(self::wifiConf,"r");
        while(!feof($file)){
            $filestr = fgets($file);
            if(stristr($filestr,self::channelset)){
                $oldchannel =  $filestr;
            }
        }
        fclose($file);
        $allFile = file_get_contents(self::wifiConf);
        $allFile = str_replace($oldchannel,self::channelset.$channel."\n",$allFile);
        file_put_contents(self::wifiConf,$allFile);
        return true;
    }
    function setWifiWpakey($wapKey){//wifi加密方式/*WPA-PSK,WPA2-PSK,WPA-PSK/WPA2-PSK(混合加密)*/
        $count = 0;
        if($wapKey=="WPA-PSK")
            $count++;
        if($wapKey=="WPA2-PSK")
            $count++;
        if($wapKey=="WPA-PSK/WPA2-PSK")
            $count++;
        if($count != 1)
            return false;
        $file = fopen(self::wifiConf,"r");
        while(!feof($file)){
            $filestr = fgets($file);
            if(stristr($filestr,self::wpakeyset)){
                $oldkey =  $filestr;
            }
        }
        fclose($file);
        $allFile = file_get_contents(self::wifiConf);
        $allFile = str_replace($oldkey,self::wpakeyset.$wapKey."\n",$allFile);
        file_put_contents(self::wifiConf,$allFile);
        return true;
	}

    /*getter*/
    function getWifiName(){
        $file = fopen(self::wifiConf,"r");
        if(!$file)
            return false;
        while(!feof($file)){
            $filestr = fgets($file);
            if(stristr($filestr,self::nameset)){
                fclose($file);
                return str_replace("\n","",str_replace(self::nameset,"",$filestr));
            }
        }
        fclose($file);
        return false;
    }
    function getWifiPasswd(){
        $file = fopen(self::wifiConf,"r");
        if(!$file)
            return false;
        while(!feof($file)){
            $filestr = fgets($file);
            if(stristr($filestr,self::passwdset)){
                fclose($file);
                return str_replace("\n","",str_replace(self::passwdset,"",$filestr));
            }
        }
        fclose($file);
        return false;
    }
    function getWifiChannel(){
        $file = fopen(self::wifiConf,"r");
        if(!$file)
            return false;
        while(!feof($file)){
            $filestr = fgets($file);
            if(stristr($filestr,self::channelset)){
                fclose($file);
                return str_replace("\n","",str_replace(self::channelset,"",$filestr));
            }
        }
        fclose($file);
        return false;
    }
    function getWifiWpakey(){
        $file = fopen(self::wifiConf,"r");
        if(!$file)
            return false;
        while(!feof($file)){
            $filestr = fgets($file);
            if(stristr($filestr,self::wpakeyset)){
                fclose($file);
                return str_replace("\n","",str_replace(self::wpakeyset,"",$filestr));
            }
        }
        fclose($file);
        return false;
    }
}

class wan{
    /****getter****/
    function getNetType(){
        $shell = "service dhcpcd status|grep 'Active'|awk '{print $3}'";
        exec($shell,$result,$status);
        if($status == 0){
            if($result[0] == "(running)")
                return "DHCP";
            else
                return "static";
        }
        else
            return false;
    }
    function getMask(){
        $shell = "ifconfig wlp2s0|grep 'netmask'|awk '{print $4}'";
        exec($shell,$result,$status);
        if($status == 0)
            return $result[0];
        else
            return false;
    }
    function getIp(){
        $shell = "ifconfig wlp2s0|grep 'netmask'|awk '{print $2}'";
        exec($shell,$result,$status);
        if($status == 0)
            return $result[0];
        else
            return false;
    }
    function getRount(){
        $shell = "ifconfig wlp2s0|grep 'netmask'|awk '{print $2}'";
        exec($shell,$result,$status);
        if($status == 0)
            return preg_replace("/.[^.]*$/","",$result[0]).".1";
        else
            return false;
    }
    function getDns(){
        $file = fopen("/var/www/html/PHP/sysctl/dnsmasq.conf","r");
        if(!$file)
            return false;
        while(!feof($file)){
            $filestr = fgets($file);
            if(stristr($filestr,"server=")){
                fclose($file);
                return str_replace("\n","",str_replace("server=","",$filestr));
            }
        }
        fclose($file);
        return false;
    }
    /****setter****/

}
class lan{
    const conffile = "/var/www/html/PHP/sysctl/dnsmasq.conf";
    /********getter*********/
    function getStartIp(){
        $shell = "cat /var/www/html/PHP/sysctl/dnsmasq.conf|grep 'dhcp-range='|cut -d'=' -f2|cut -d',' -f1";
        exec($shell,$result,$status);
        if($status == 0){
            return $result[0];
        }else
            return false;
    }
    function getEndIp(){
        $shell = "cat /var/www/html/PHP/sysctl/dnsmasq.conf|grep 'dhcp-range='|cut -d'=' -f2|cut -d',' -f2";
        exec($shell,$result,$status);
        if($status == 0){
            return $result[0];
        }else
            return false;
    }
    function getTime(){
        $shell = "cat /var/www/html/PHP/sysctl/dnsmasq.conf|grep 'dhcp-range='|cut -d'=' -f2|cut -d',' -f3";
        exec($shell,$result,$status);
        if($status == 0){
            $hour = floatval(str_replace("h","",$result[0]));
            return $hour*60;
        }else
            return false;
    }
    function getIp(){
        $shell = "cat /var/www/html/PHP/sysctl/dnsmasq.conf|grep 'listen-address='|cut -d'=' -f2";
        exec($shell,$result,$status);
        if($status == 0)
            return $result[0];
        else
            return false;
    }
    /******setter******/
    function setDHCP($startIp,$endIp,$time){
        $file = fopen(self::conffile,"r");
        while(!feof($file)){
            $filestr = fgets($file);
            if(stristr($filestr,"dhcp-range=")){
                $olddhcp =  $filestr;
            }
        }
        fclose($file);
        $allFile = file_get_contents(self::conffile);
        $time = strval(intval($time)/60)."h";
        $newset = $startIp.",".$endIp.",".$time."\n";
        $allFile = str_replace($olddhcp,"dhcp-range=".$newset,$allFile);
        file_put_contents(self::conffile,$allFile);
        return true;
    }
    function setLanIp($ip){
        $file = fopen(self::conffile,"r");
        while(!feof($file)){
            $filestr = fgets($file);
            if(stristr($filestr,"listen-address=")){
                $oldip =  $filestr;
            }
        }
        fclose($file);
        $allFile = file_get_contents(self::conffile);
        $newset = "listen-address=".$ip."\n";
        $allFile = str_replace($oldip,$newset,$allFile);
        file_put_contents(self::conffile,$allFile);
        return true;
    }
}
?>

