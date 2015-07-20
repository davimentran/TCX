<?php
	class JAVASCRIPT {
			
			function openJS() {
					try {
							$str="<script language=\"javascript\">\n";
							$str.="<!--\n";
							return $str;
					}
					catch (Exception $ex) {
							return "";
					}
			}
			
			function closeJS() {
					try {
							$str="\n-->\n";
							$str.="</script>";
							return $str;
					}
					catch (Exception $ex) {
							return "";
					}
			}

			function displayJS($contentScript) {
					try {
							echo $this->openJS();
							echo $contentScript;
							echo $this->closeJS();
					}
					catch (Exception $ex) {
					}
			}
			
			function linkJS($url) {
					echo "<script type=\"text/javascript\" src=\"$url\"></script>\n";
			}
			function redirectURL($url) {
					try {
							echo "<script type=\"text/javascript\">window.location='".$url."';</script>";
					}
					catch (Exception $ex) {
					}
			}
			
			function alert($str) {
					try {
							echo "<script type='text/javascript'>alert('".$str."');	</script>";
					}
					catch (Exception $ex) {
					}
			}
			function flashWrite($url,$w,$h,$id,$bg,$vars,$win) {
					$str="<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='".$w."' height='".$h."' id='".$id."' align='middle'>"."<param name='allowScriptAccess' value='always' />"."<param name='movie' value='".$url."' />"."<param name='FlashVars' value='".$vars."' />"."<param name='wmode' value='".$win."' />"."<param name='menu' value='false' />"."<param name='quality' value='high' />"."<param name='bgcolor' value='".$bg."' />"."<embed src='".$url."' FlashVars='".$vars."' wmode='".$win."' menu='false' quality='high' bgcolor='".$bg."' width='".$w."' height='".$h."' name='".$id."' align='middle' allowScriptAccess='always' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />"."</object>";
					return $str;
			}
	}
?>