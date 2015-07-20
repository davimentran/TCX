<?php
class UTILITIES {
	/* 	*******************************************************************/
	function checkBrowser() {
		$browser = $_SERVER["HTTP_USER_AGENT"];
		if(strstr($browser, "Firefox") !="")
			return "FF";
		elseif (strstr($browser, "MSIE 7.0") !="")
			return "IE7.0";
		elseif (strstr($browser, "MSIE 6.0") !="")
			return "IE6.0";
	}
	/*	-----------------------------------------------------------------*/
    function format($price) {
                if((int)$price==0)
						return $price;
				else
						return number_format($price,0,".",",");
	}

    function price($price){
        $str = number_format($price,0,",",".");
        return $str;
   }
    function generate_url_from_text($strText)
    {
      $strText = preg_replace('/[^A-Za-z0-9-]/', ' ', $strText);
      $strText = preg_replace('/ +/', ' ', $strText);
      $strText = trim($strText);
      $strText = str_replace(' ', '-', $strText);
      $strText = preg_replace('/-+/', '-', $strText);
      $strText=  preg_replace("/-$/","",$strText);
      return $strText;
    }
	/*  ******************************************************************/
	function checkFile($name, $arrayExt, $arrayUpload, $capacity, & $fname, $pathupload) {
		//status=-1: File không có,status=1: upload thanh cong;
        //status=2: upload that bai
		//status=3: kieu file khong duoc phep;status=4: Dung luong file vuot qua 100kb;
		$status = 1;
		$tmp_name = $_FILES[$name]['tmp_name'];
		$fname = $_FILES[$name]['name'];
		if($fname == "") {
			$status = - 1;
			$fname = "";
			return $status;
		}
        $part = pathinfo($fname);
        $fname=$this->stripUnicode($fname);
        $fname=$this->generate_url_from_text($fname);
        $ext=".".strtolower($part["extension"]);
        $fname.=$ext;
		if(in_array($ext, $arrayExt)) {
			$xsmall = date("YmdHis") . $fname;
			if($_FILES[$name]['size'] <= $capacity) {
				if(move_uploaded_file($tmp_name, $arrayUpload[$pathupload] . $xsmall))
					$status = 1;
				else
					$status = 2;
			}
			else
				$status = 4;
		}
		else {
			$status = 3;
		}
        $fname=$xsmall;
		return $status;
	}
    /*  ******************************************************************/
     function stripUnicode($str){
        if(!$str) return false;
        $str=strip_tags($str);
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
         );
        foreach($unicode as $nonUnicode=>$uni) $str = preg_replace("/($uni)/i",$nonUnicode,$str);
        return $str;
    }
	/*  ******************************************************************/
	function createTextImage($image,$text="",$font="",$color="#000000",$size=10,$x=0,$y=0,$gocquay=0,$folder="") {
	    $type = strtolower(substr($image,-3));
        $wh=getimagesize($image);
        $originalWidth=$wh[0];
        $orginalHeight=$wh[1];
    /*  ******************************************************************/
        if(eregi("([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})", $color, $ca)) {
			$red = hexdec($ca[1]);
			$green = hexdec($ca[2]);
			$blue = hexdec($ca[3]);
		}
        switch($type)
        {
          case "jpg":
          case "jpeg":
            $im=imagecreatefromjpeg($image);
            $img=imagecreatetruecolor($originalWidth,$orginalHeight);
            imagecopyresized($img,$im,0,0,0,0,$originalWidth,$orginalHeight,$originalWidth,$orginalHeight);
            $color=imagecolorallocate($im,$red,$green,$blue);
            imagettftext($img,$size,$gocquay,$x,$y,$color,$font,$text);
            $text=str_replace(" ","",$this->stripUnicode($text));
            imagejpeg($img,$folder.$text.".jpg",100);
            imagedestroy($img);
            $filename=$folder.$text.".jpg";
            break;
          case "png":
            $im=imagecreatefrompng($image);
            $img=imagecreatetruecolor($originalWidth,$orginalHeight);
            imagecopyresized($img,$im,0,0,0,0,$originalWidth,$orginalHeight,$originalWidth,$orginalHeight);
            $color=imagecolorallocate($im,$red,$green,$blue);
            imagettftext($img,$size,$gocquay,$x,$y,$color,$font,$text);
            $text=str_replace(" ","",$this->stripUnicode($text));
            imagepng($img,$folder.$text.".png");
            imagedestroy($img);
            $filename=$folder.$text.".png";
            break;
          case "gif":
            $im=imagecreatefromgif($image);
            $img=imagecreatetruecolor($originalWidth,$orginalHeight);
            imagecopyresized($img,$im,0,0,0,0,$originalWidth,$orginalHeight,$originalWidth,$orginalHeight);
            $color=imagecolorallocate($im,$red,$green,$blue);
            imagettftext($img,$size,$gocquay,$x,$y,$color,$font,$text);
            $text=str_replace(" ","",$this->stripUnicode($text));
            imagegif($img,$folder.$text.".gif");
            imagedestroy($img);
            $filename=$folder.$text.".gif";
            break;
        }
        return $filename;
	}
	/* 	*******************************************************************/
    function takeShortText($longText,$numWords){
		$ret="";
		if($longText!=""){
			$longText=trim($longText);
            $longText=stripslashes($longText);
			$longText=strip_tags($longText);
			if(str_word_count($longText)>$numWords){
				$arrayText=explode(" ",$longText);
				for($i=0;$i<$numWords;$i++){
					$ret.=$arrayText[$i]." ";
				}
				$ret=trim($ret)."... ";
				return $ret;
			}
			else{
				return $longText;
			}
		}
	}
	/* *******************************************************************/
	function takeShortTextWithTag($longText, $numWords) {
		$ret = "";
		if($longText != "") {
			$longText = trim($longText);
			if(str_word_count($longText) > $numWords) {
				$arrayText = split(" ", $longText, $numWords);
				for ($i = 0; $i < $numWords - 1; $i++) {
					$ret .= $arrayText[$i] . " ";
				}
				$ret = trim($ret) . "... ";
				return $ret;
			}
			else {
				return $longText;
			}
		}
	}
	/* *******************************************************************/
	function encodeHTML($sHTML) {
		$sHTML = stripslashes($sHTML);
		$sHTML = ereg_replace("&", "&amp;", $sHTML);
		$sHTML = ereg_replace("<", "&lt;", $sHTML);
		$sHTML = ereg_replace(">", "&gt;", $sHTML);
		return $sHTML;
	}
	/* *******************************************************************/
	function fileExtension($filename) {
		$pathInfo = pathinfo($filename);
		return $pathInfo["extension"];
	}
	/* *******************************************************************/
	function stringToArray($char = ',', $value) {
		return explode($char, $value);
	}
	/* *******************************************************************/
	function iff($expression, $returntrue = '', $returnfalse = '') {
		return ($expression ? $returntrue : $returnfalse);
	}
	/* *******************************************************************/
	function getDate() {
		$date = getdate();
		return $date["year"] . "." . $date["mon"] . "." . $date["mday"];
	}
	/* *******************************************************************/
	function formatDate($stringFormat, $stringDate) {
		return date($stringFormat, strtotime($stringDate));
	}
	/* *******************************************************************/
	function make_pass() {
		$pass = "";
		$chars = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "a", "A", "b", "B", "c",
		              "C", "d", "D", "e", "E", "f", "F", "g", "G", "h", "H", "i", "I", "j", "J",
		              "k", "K", "l", "L", "m", "M", "n", "N", "o", "O", "p", "P", "q", "Q", "r",
		              "R", "s", "S", "t", "T", "u", "U", "v", "V", "w", "W", "x", "X", "y", "Y",
		              "z", "Z");
		$count = count($chars) - 1;
		srand((double) microtime() * 1000000);
		for ($i = 0; $i < 6; $i++)
			$pass .= $chars[rand(0, $count)];
		for ($i = 0; $i < 6; $i++) {
			if(is_numeric(substr($pass, $i, 1)))
				break;
		}
		if($i == 6)
			$pass = substr($pass, 0, 2) . rand(0, 9) . substr($pass, 3, 3);
		return ($pass);
	}
	/* *******************************************************************/
	function make_protect_image($image="",$font="",$protect="",$color="#000000",$size=15) {
        if(eregi("([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})", $color, $ca)) {
			$red = hexdec($ca[1]);
			$green = hexdec($ca[2]);
			$blue = hexdec($ca[3]);
        }
        $pass = "";
		$chars = array("1", "2", "3", "4", "5", "6", "7", "8", "9");
		$count = count($chars) - 1;
		srand((double) microtime() * 1000000);
		for ($i = 0; $i < 5; $i++)
			$pass .= $chars[rand(0, $count)];
		$img = imagecreatefromjpeg($image);
		$text_color = imagecolorallocate($img, $red, $green, $blue);
		$w = 10;
		srand((double) microtime() * 1000000);
		for ($i = 0; $i < strlen($pass); $i++) {
			$a = rand(0, 0);
			$t = substr($pass, $i, 1);
			imagettftext($img,$size,$a,$w,30,$text_color,$font,$t);
			$w = $w + 15;
		}
		imagejpeg($img, $protect);
		@ imagedestroy($img);
		return ($pass);
	}
	/* *******************************************************************/
	function chk_email($email) {
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3}[,]?)+$",
		  $email)) {
			return false;
		}
		return true;
	}
	/* *******************************************************************/
    function watermark($srcfilename, $newname, $watermark, $quality) {
    	$imageInfo = getimagesize($srcfilename);
    	$width = $imageInfo[0];
    	$height = $imageInfo[1];
    	$logoinfo = getimagesize($watermark);
    	$logowidth = $logoinfo[0];
    	$logoheight = $logoinfo[1];
    	$horizextra =$width - $logowidth;
    	$vertextra =$height - $logoheight;
    	$horizmargin = round($horizextra / 2);
    	$vertmargin = round($vertextra / 2);
    	$photoImage = ImageCreateFromJPEG($srcfilename);
    	ImageAlphaBlending($photoImage, true);
    	$logoImage = ImageCreateFromPNG($watermark);
    	$logoW = ImageSX($logoImage);
    	$logoH = ImageSY($logoImage);
    	ImageCopy($photoImage, $logoImage, $horizmargin, $vertmargin, 0, 0, $logoW, $logoH);
    	ImageJPEG($photoImage,"",$quality); // output to browser
    	//uncomment next line to save the watermarked image to a directory. need write access(changed directory to anything)
    	//ImageJPEG($photoImage, "../stock_photos/" . $newname, $quality);
    	//ImageDestroy($photoImage);
    	ImageDestroy($logoImage);
    }
	/* *******************************************************************/
    function getimage ($image)
    {
    	switch ($image)
        {
    	case 'file':
    		return base64_decode('R0lGODlhEQANAJEDAJmZmf///wAAAP///yH5BAHoAwMALAAAAAARAA0AAAItnIGJxg0B42rsiSvCA/REmXQWhmnih3LUSGaqg35vFbSXucbSabunjnMohq8CADsA'); break;
    	case 'folder':
    		return base64_decode('R0lGODlhEQANAJEDAJmZmf///8zMzP///yH5BAHoAwMALAAAAAARAA0AAAIqnI+ZwKwbYgTPtIudlbwLOgCBQJYmCYrn+m3smY5vGc+0a7dhjh7ZbygAADsA'); break;
    	case 'hidden_file':
    		return base64_decode('R0lGODlhEQANAJEDAMwAAP///5mZmf///yH5BAHoAwMALAAAAAARAA0AAAItnIGJxg0B42rsiSvCA/REmXQWhmnih3LUSGaqg35vFbSXucbSabunjnMohq8CADsA'); break;
    	case 'link':
    		return base64_decode('R0lGODlhEQANAKIEAJmZmf///wAAAMwAAP///wAAAAAAAAAAACH5BAHoAwQALAAAAAARAA0AAAM5SArcrDCCQOuLcIotwgTYUllNOA0DxXkmhY4shM5zsMUKTY8gNgUvW6cnAaZgxMyIM2zBLCaHlJgAADsA');break;
    	case 'smiley':
    		return base64_decode('R0lGODlhEQANAJECAAAAAP//AP///wAAACH5BAHoAwIALAAAAAARAA0AAAIslI+pAu2wDAiz0jWD3hqmBzZf1VCleJQch0rkdnppB3dKZuIygrMRE/oJDwUAOwA=');break;
    	case 'arrow':
    		return base64_decode('R0lGODlhDwAMAIAAAP39/ZmZmSH5BAEHAAAALAAAAAAPAAwAAAIjBIKmqxjn3JJvsgZfjfT4HGWfllTeJpLaVDJmyr3r5X40UAAAOw==');break;
        case "":
        break;
    	}
    }
}
?>