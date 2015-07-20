<?php
class UTILITIES {
		function format($price) {
                if($price>=0)
						return number_format($price,2,".",",");
				else
						return '-'. number_format(-$price,2,",",".");
		}

		function format_vlink($value,$code) {
				switch($code)
				{
					case "VND":				
						if($value>=0)
								return number_format($value,2,",",".");
						else
								return '-'. number_format(-$value,2,",",".");
						break;
					default:
						break;
				}
		}
				
		
		function generate_url_from_text($strText) {
				$strText=preg_replace('/[^A-Za-z0-9-]/',' ',$strText);
				$strText=preg_replace('/ +/',' ',$strText);
				$strText=trim($strText);
				$strText=str_replace(' ','-',$strText);
				$strText=preg_replace('/-+/','-',$strText);
				$strText=preg_replace("/-$/","",$strText);
				return $strText;
		}
		/*  ******************************************************************/
		function stripUnicode($str) {
				if(!$str)
						return false;
				$str=strip_tags($str);
				$unicode=array('a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ','d' => 'đ','e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ','i' => 'í|ì|ỉ|ĩ|ị','o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ','u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự','y' => 'ý|ỳ|ỷ|ỹ|ỵ','A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ','D' => 'Đ','E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ','I' => 'Í|Ì|Ỉ|Ĩ|Ị','O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ','U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự','Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',);
				foreach($unicode as $nonUnicode => $uni)
						$str=preg_replace("/($uni)/i",$nonUnicode,$str);
				return $str;
		}
		/* 	*******************************************************************/
		function takeShortText($longText,$numWords) {
				$ret="";
				if($longText!="") {
						$longText=trim($longText);
						$longText=stripslashes($longText);
						$longText=strip_tags($longText);
						if(str_word_count($longText)>$numWords) {
								$arrayText=explode(" ",$longText);
								for($i=0; $i<$numWords; $i++) {
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
		/*
		*******************************************************************/
		function checkFile($name,$arrayExt,$arrayUpload,$capacity,&$fname,$pathupload) {
				//status=-1: File không có,status=1: upload thanh cong;
				//status=2: upload that bai//status=3: kieu file khong duoc phep;
                //status=4: Dung luong file vuot qua 100kb;
				$status=1;
				$tmp_name=$_FILES[$name]['tmp_name'];
				$fname=$_FILES[$name]['name'];
				if($fname=="") {
						$status=-1;
						$fname="";
						return $status;
				}
				$part=pathinfo($fname);
				$fname=$this->stripUnicode($fname);
				$fname=$this->generate_url_from_text($fname);
				$ext=".".strtolower($part["extension"]);
				$fname.=$ext;
				if(in_array($ext,$arrayExt)) {
						$xsmall=date("YmdHis").$fname;
						if($_FILES[$name]['size']<=$capacity) {
								if(move_uploaded_file($tmp_name,$arrayUpload[$pathupload].$xsmall))
										$status=1;
								else
										$status=2;
						}
						else
								$status=4;
				}
				else{
						$status=3;
				}
				$fname=$xsmall;
				return $status;
		}
}
?>