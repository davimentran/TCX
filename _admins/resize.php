<?
//-- Resize a picture
//-- Useage: <img src='resize.php?from=URL_of_ORG_Pict&to=URL_of_Des_Pict&w=NEW_WIDTH&h=NEW_HEIGHT'>
$from = $_GET['from'];
$tp   = $_GET['to'];
$w  = (int)$_GET['w'];
$h  = (int)$_GET['h'];
$n  = $_GET['to'];
$info = @getimagesize($from);
$width = $info[0];
$height= $info[1];
//-- Kiem tra xem co dung dang thuc duoc cho phep hay khong?
$ext  = $info[2];
if($ext == 2) $ext ='jpeg'; elseif($ext == 3) $ext = 'png'; else $ext = 'gif';
if(!$ext){ //-- Create 1 hinh thong bao loi
	error();
}
else $func="imagecreatefrom$ext";
	
	//-- Tinh toan chieu dai, chieu rong moi theo percent
	if($w || $h)	
	{
		if(!$w && $h)//-- Resize theo chieu height
		{
			$p = $h/$height;
			$w = $p*$width;
		}
		elseif(!$h && $w)//-- Resize theo chieu width
		{
			$p = $w/$width;		
			$h = $p*$height	;
		}
		else //-- Resize theo 2 chieu
		{
			$pw = $w/$width;
			$ph = $h/$height;
			if($pw<$ph) $p = $pw; else $p = $ph;
			$w = $p * $width;
			$h = $p * $height;
		}
		if($_REQUEST['t']==true)
			{if($h<80)
				{
				$p=80/$h;
				$h=80;
				$w=$p*$h;
				}
			}
		elseif ($p>1)
			{
			$w=$width;
			$h =$height;
			}
		$im = $func($from);
		$im2= imagecreatetruecolor($w, $h);
		$im = imagecopyresampled($im2, $im, 0, 0, 0, 0, $w, $h, $width, $height);
		header("Content-type: image/jpeg");						
		imagejpeg($im2);
		if($to) imagejpeg($im2, $to);			
		@imagedestroy($im);
		@imagedestroy($im2);					
	}
	else //-- Loi
		error();	
//============================================================================
function error(){
	$im = imagecreate(100,110);	
	$c = imagecolorallocate($im, 255, 255, 255); //WHITE
	$text_color = imagecolorallocate($im, 255, 0, 0);
	//-- Viet thong bao loi chu do nen trang
	imagestring($im, 2, 7, 10, "file not found", $text_color);
	imagestring($im, 2, 7, 30, "or file type", $text_color);	
	imagestring($im, 2, 7, 50, "was not support", $text_color);		
	imagestring($im, 2, 7, 70, "or invalid", $text_color);			
	imagestring($im, 2, 7, 90, "width or height", $text_color);				
	header("Content-type: image/jpeg");
	imagejpeg($im);
	imagedestroy($im);
}	
	
?>