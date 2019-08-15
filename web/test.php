<?php
class systemTool{//系统工具类


		function reboot(){//重启，失败返回false
			exec("reboot",$result,$status);
			if($status != 0)
				return false;
	}
		function getSystemDate(){//获取系统时间，成功返回时间，失败返回false
			$shell = "date +'%Y-%m-%d %H:%M:%S'";
			exec($shell,$result,$status);
			echo $status;
			if($status != 0)
				return false;
			return $result;
	}
}


class wifi{//wifi的设置以及已设置的信息获取
	function set($wifiName,$passwd,$passwdMethod="WPA2-PSK",$channel=6){
	//wifi名称及密码必要参数，加密方式、通道带有默认参数，可不设置
		$wifiConf	  = "/srv/www/wifi.conf";
		$bak          = ".bak";
		$bak_file     =	$wifiConf.$bak;//配置文件位置

		$nameset	  = "ssid=";
		$passwdset    = "wpa_passphrase=";
		$wpaset       = "wpa=";
		$channel      = "channel=";

		if(!copy($wifiConf,$bak_file)){//创建备份文件
			echo "false";
			return false;
		}
		$file = fopen($wifiConf,"r+");//读写方式打开文件，文件指针位于文末

		if(!file){
			unlink($wifiConf);
			rename($bak_file,$wifiConf);//出错改回配置文件，避免配置文件丢失
			return false;
		}
		while(! feof($file))
		{
			$text = fgets($file);
			if(stristr($text,$nameset) != false){//找标志
				$pos = ftell($file)-(strlen($text)-strlen($nameset));//获取修改位置
				fseek($file,$pos);//将文件指针移到相应位置
				$str = "";
				for($i=0;$i<(strlen($text)-strlen($nameset));$i++){//读出oldname+换行符
					$str = $str.fgetc($file);
				}
				echo "<br>";
				echo $str."<br>";
				$oldname = $str;
				$newname = substr_replace($oldname,$wifiName,0);
				echo $newname."<br>";
				//fseek($file,$pos);//将文件指针移到相应位置
				//fwrite($file,$str,20);
				//echo fgets($file)."<br>";
			}
		}
		unlink($bak_file);
		fclose($file);
	}
}
?>

