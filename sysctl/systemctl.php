<?php
class systemTool{//系统工具类


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
}

class wifi{//wifi的设置以及已设置的信息获取
    const wifiConf = "/var/www/html/wifi.conf";//配置文件路径
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

}
?>

