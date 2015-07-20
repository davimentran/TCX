<?php
if($_SESSION["Free"]==1)
{
?>
<div class="logo" style="text-align: center;  margin-top: 50px; margin-bottom: 20px ">
    <img src="style/images/logo.png" alt="" />
</div>
<?php
}
?>
<div class="post block" style="padding: 20px">
<?php
$msg2="";
$isEdit=(($URL[1]==md5("edit".date("dmYH")))?True:False);

if($_SESSION["Free"]==0 && !$isEdit)
{
	$html->redirectURL("account.html");
}
?>
<?php if($isEdit) { ?>
<div style="float: left; margin-left: 10px;">
<?php include("linkmember.php");?>
</div>
<div class="clear"></div>
<?php } ?>
<?php

if($_SESSION["Free"]==0)
{
        $rstgetInfo=$dbf->getDynamic("member","id='".$_SESSION["member_id"]."'","");
        $rowgetInfo=$dbf->nextData($rstgetInfo);
        foreach($rowgetInfo as $key=>$value){
            $$key = $value;
        }
}

if(isset($_POST["ok"]) || isset($_POST["email"]) )
{
    foreach($_POST as $key=>$value)
    {
            $$key = $value;
    }

    $password   =   $matkhau;
    $password   =   $utl->stripUnicode($password);
    $temp_pwd   =   $password;
    $arrayparentid   = explode($info["MS"],$parentid);
    array_shift($arrayparentid);

    if((int)$arrayparentid[0] > 0 )
    {
      $parentid = $arrayparentid[0];

    }else
    {
       $html->redirectURL("/register/nguoi-bao-tro-khong-co.html");
       exit;
    }

	$time=time();
    $code=strtoupper($_POST["captcha"]);
	if($code!=$_SESSION["captcha_id"])
	{
        $html->redirectURL("/register/security-code-error.html");
        exit;
	}else
	{
           $password=md5($password);
           if(!$isEdit)
            {

                $rstcheck =  $dbf->getDynamic("member","email='".$email."'","");
                $rstcheck2 = $dbf->getDynamic("member","tendangnhap ='".$tendangnhap."'","");
        		if($dbf->totalRows($rstcheck)>0)
        		{
                    $html->redirectURL("/register/email-is-register.html");
                    exit;
        		}elseif($dbf->totalRows($rstcheck2)>0)
                {
                    $html->redirectURL("/register/username-is-register.html");
                    exit;
                }
                else
                {

                  $array_col = array("hovaten"=>$hovaten, "parentid"=>$parentid, "date_ngaysinh"=>strtotime($date_ngaysinh), "gioitinh"=>$gioitinh, "cmnd"=>$cmnd, "date_ngaycap"=>strtotime($date_ngaycap), "noicap"=>$noicap, "diachi"=>$diachi, "xaphuong"=>$xaphuong, "tinhthanh"=>$tinhthanh, "quanhuyen"=>$quanhuyen, "didong"=>$didong, "email"=>$email, "tenchutaikhoan"=>$tenchutaikhoan, "sotaikhoan"=>$sotaikhoan, "nganhang"=>$nganhang, "chinhanh"=>$chinhanh, "tendangnhap"=>$tendangnhap, "password"=>$password, "datecreated"=>$time, "status"=>0);
                  $affect=$dbf->insertTable("member",$array_col);
                }
                //kiem tra người bảo trợ

                $rstcheck3 =  $dbf->getDynamic("member","id=".(int)$parentid."","");
                if((int)$dbf->totalRows($rstcheck3)<=0)
        		{
                    $html->redirectURL("/register/nguoi-bao-tro-khong-co.html");
                    exit;
        		}

            }else
            {
              $array_col=array("hovaten"=>$hovaten, "date_ngaysinh"=>strtotime($date_ngaysinh), "gioitinh"=>$gioitinh, "cmnd"=>$cmnd, "date_ngaycap"=>strtotime($date_ngaycap), "noicap"=>$noicap, "diachi"=>$diachi, "xaphuong"=>$xaphuong, "tinhthanh"=>$tinhthanh, "quanhuyen"=>$quanhuyen, "didong"=>$didong, "sotaikhoan"=>$sotaikhoan, "nganhang"=>$nganhang, "chinhanh"=>$chinhanh);
              $affect=$dbf->updateTable("member",$array_col,"id='".$_SESSION['member_id']."'");
            }

                if($affect>0)
				{
                    if($isEdit)
                    {
                        $html->redirectURL("/account.html");
                        exit;
                    }
                    else
                    {
                        $query=$dbf->getDynamic("member","email='".$email."'","");
    					if($dbf->totalRows($query)>0)
    					{
                            $row = $dbf->nextData($query);
                            $_SESSION["member_id"]          = stripslashes($row["id"]);
    						$_SESSION["member_email"]       = stripslashes($row["email"]);
                            $_SESSION["member_hovate"]      = stripslashes($row["hovaten"]);
                            $_SESSION["Free"]=0;
                		}
                        //gui mail
                        $str="<html>
                              <head>
                              <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                              <meta http-equiv='Content-Language' content=\en-us' />
                              <style type='text/css'>
                               body{font-family: Arial;font-size: 12px; color:#333333;}
                              .tableSendEmail .tdParent{ border-bottom: 1px solid #EBF1F6; height: 25px; text-align: left; vertical-align: middle; padding-left:10px;}
                              .tableSendEmail .tdParent div{ clear:both; text-align: left; padding-left:20px; background: url(../Images/bullet_sanpham.jpg) left center no-repeat; text-transform: uppercase; font-weight: bold;}
                              .tableSendEmail .tdParent div .link{ text-decoration: none;  color: #333333;}
                              .tableSendEmail .tdParent div .link:hover{ color: #F5841E; text-decoration: none;}
                              .tableSendEmail .tdItem{ border-bottom: 1px solid #EBF1F6; text-align: left; vertical-align: middle; padding:5px;}
                              .tableSendEmail .tdItem_right{ border-bottom: 1px solid #EBF1F6; text-align: left; vertical-align: middle; padding:5px; border-right:1px solid #B4CDD7;}
                              .tableSendEmail .tdItem_right .linkTitle{ font-size:13px; font-weight:bold; color:#333333; text-decoration: none;}
                              .tableSendEmail .tdItem_right .linkTitle:hover{ font-size:13px; font-weight:bold; color:#F5841E; text-decoration: none;}
                              </style>
                              </head>
                              <body>
                              <div class='aroundEmail' style='clear:both; text-align:left;'>
                              <table width='100%' height='100%' cellpadding='1' cellspacing='1' bgcolor='#C1C9DB'>

                                <tr style='background:#FFFFFF'><td colspan=\"2\" height:30px></td></tr>
                                <tr style='background:#FFFFFF'>
                                <td colspan=\"2\">
                                    Chào mừng : <b>".$hovaten."</b><br/>
                                    Chúc mừng bạn đã tạo tài khoản thành công tại  <a href='".HOST."'>".HOST." </a><br/>Để bắt đầu sử dụng những tiện ích này cho thành viên, vui lòng click vào: <a href='".HOST."'>".HOST." </a>
                                    <br/><br/>Tài khoản của bạn là: </b>
                                    <br/><br/>Email:<b>".$tendangnhap."</b>
                                    <br/>Password:<b> ".$_POST['matkhau']."</b>
                                </td>
                                </tr>
                              </table>
                              </div>
                              </body></html>";

                                $Subject  =  "A confirmation email members";
                                require("modum/class.phpmailer.php");
                                $mail = new PHPMailer();
                                $SMTP_Host = $arraySMTPSERVER["host"];
                                $SMTP_Port = 25;
                                $SMTP_UserName = $arraySMTPSERVER["user"];
                                $SMTP_Password = $arraySMTPSERVER["password"];

                                $from = $SMTP_UserName;
                                $fromName = $info["title"];
                                $to = $email_register;
                                $mail->IsSMTP();
                                $mail->Host     = $SMTP_Host;
                                $mail->SMTPAuth = true;
                                $mail->Username = $SMTP_UserName;
                                $mail->Password = $SMTP_Password;
                                $mail->From     = $from;
                                $mail->FromName = $fromName;
                                $mail->AddAddress($to);
                                $mail->AddReplyTo($from, $fromName);
                                $mail->WordWrap = 50;
                                $mail->IsHTML(true);
                                $mail->Subject  =  $Subject;
                                $mail->Body     =  $str;
                                $mail->AltBody  =  "This is the text-only body";


                              if($mail->Send())	{
                                 $html->redirectURL("/account.html");
                              }
                              else
                              {
                                 $html->redirectURL("/account.html");
                              }
                     }
				}
                else
                {
                  $html->redirectURL("/register/error.html");
                }

	}

}

switch ($URL[1]) {
      case "error" :
            $msg="Đăng ký thất bại. Vui lòng thực hiện lại";
            break;
      case "email-is-register" :
            $msg="Email này đã được đăng ký. Vui lòng nhập email khác";
            break;
      case "username-is-register" :
            $msg="Tên đăng nhập này đã được đăng ký. Vui lòng nhập tên đăng nhập khác";
            break;
       case "security-code-error" :
            $msg="Mã bảo vệ không đúng. Vui lòng nhập lại";
            break;
       case "nguoi-bao-tro-khong-co" :
            $msg="Người bảo trợ không tồn tại. Vui lòng nhập lại";
            break;


}

require 'captcharand.php';
$_SESSION['captcha_id'] = strtoupper($strcaptcha);
?>
<?php echo $html->normalForm("frm",array("action"=>"","method"=>"post"));?>
<div class='title_header'>ĐĂNG KÝ TÀI KHOẢN</div>
<div class="pro_c">
<div  style="text-align:left;padding-left:15px"><span class="saodo"><?=$msg?></span></div>

<fieldset style="border: 1px solid #999; padding: 5px;">
    <legend><b>Thông tin tài khoản</b></legend>

<div class="saodo"><h3 style="padding-left:10px;color:#c00;font-size:12px;margin:0px"><?php echo $msg2?></h3></div>

<div class="clear" style="padding-top:10px"></div>

<div class="clear"></div>
<div class="right_row1">Tên đăng nhập</div>
<div class="right_row2">
  <input class="full" type="text" maxlength="100" style="width:200px" onfocus="this.select();" value="<?php echo $tendangnhap?>" name="tendangnhap" id="tendangnhap"  /><span class="txtdo">*</span>
</div>

<?php
if(!$isEdit)
{
?>
<!--password-->
<div class="clear"></div>
<div class="right_row1">Mật khẩu</div>
<div class="right_row2">
  <input class="full" type="password" maxlength="50" style="width:200px" onfocus="this.select();" value="<?php echo $temp_pwd?>"   name="password" id="password"  /><span class="txtdo">*</span>
</div>
<div class="clear"></div>
<?php
}
?>
<div class="clear"></div>
<div class="right_row1">E-mail</div>
<div class="right_row2">
  <input class="full" <?=(($isEdit)?"readonly":"")?> type="text" maxlength="50" style="width:200px" onfocus="this.select();" value="<?php echo $email?>" name="email" id="email"  /><span class="txtdo">*</span>
</div>
<!--Email-->

<div class="clear"></div>
<div class="right_row1">Người bảo trợ</div>
<div class="right_row2">
  <input class="full" type="text" maxlength="100" style="width:200px" onfocus="this.select();" value="<?php echo $parentid?>" name="parentid" id="parentid"  /><span class="txtdo">*</span>
</div>

</fieldset>
<div class="clear" style="padding-top:10px"></div>
<fieldset style="border: 1px solid #999; padding: 5px;">
<legend>
   <b>Thông tin chung</b>
</legend>
<div class="clear" style="padding-top:10px"></div>
<div class="right_row1">Họ và Tên</div>
<div class="right_row2">
  <input class="full" maxlength="200" style="width:200px" type="text" onfocus="this.select();" value="<?php echo $hovaten?>" name="hovaten" id="hovaten"  /><span class="txtdo">*</span>
</div>
<div class="clear"></div>
<div class="right_row1">Ngày sinh</div>
<div class="right_row2">
  <input readonly="readonly" class="full" maxlength="200" style="width:200px" type="text" onfocus="this.select();" value="<?php echo (($date_ngaysinh!='')?date("d-m-Y",$date_ngaysinh):date("d-m-Y",time()))?>" name="date_ngaysinh" id="date_ngaysinh"  /><span class="txtdo">*</span>
  <script type="text/javascript">
  		$(function() {
  			$('#date_ngaysinh').datepicker({
  				changeMonth: true,
  				changeYear: true,
  				dateFormat: 'dd-mm-yy'
  			});
  		});
  	  </script>
</div>

<div class="clear"></div>
<div class="right_row1">Giới tính</div>
<div class="right_row2">
  <select name="gioitinh">
    <option value="">--Chọn giới tính --</option>
    <option <?php echo (($gioitinh=='Nam')?"Selected":"");?> value="Nam">Nam</option>
    <option <?php echo (($gioitinh=='Nữ')?"Selected":"");?> value="Nữ">Nữ</option>
  </select>

</div>

<div class="clear"></div>
<div class="right_row1">CMND</div>
<div class="right_row2">
  <input class="full" style="width:200px" type="text" onfocus="this.select();" value="<?php echo $cmnd?>" name="cmnd" id="cmnd" onkeypress="return nhapso(event,'cmnd')"  />
  <span class="txtdo">*</span>
</div>

<div class="clear"></div>
<div class="right_row1">Ngày cấp</div>
<div class="right_row2">
  <input class="full" readonly="readonly" style="width:200px" type="text" onfocus="this.select();" value="<?php echo (($date_ngaycap!='')?date("d-m-Y",$date_ngaycap):date("d-m-Y",time()));?>" name="date_ngaycap" id="date_ngaycap"  />
  <span class="txtdo">*</span>
   <script type="text/javascript">
  		$(function() {
  			$('#date_ngaycap').datepicker({
  				changeMonth: true,
  				changeYear: true,
  				dateFormat: 'dd-mm-yy'
  			});
  		});
  	  </script>
</div>

<div class="clear"></div>
<div class="right_row1">Nơi cấp</div>
<div class="right_row2">
  <input class="full" style="width:200px" type="text" onfocus="this.select();" value="<?php echo $noicap?>" name="noicap" id="noicap"  />
  <span class="txtdo">*</span>
</div>

<div class="clear"></div>
<div class="right_row1">Địa chỉ</div>
<div class="right_row2">
  <input class="full" style="width:200px" type="text" onfocus="this.select();" value="<?php echo $diachi?>" name="diachi" id="diachi"  />
  <span class="txtdo">*</span>
</div>

<div class="clear"></div>
<div class="right_row1">Xã/Phường</div>
<div class="right_row2">
   <input class="full" style="width:200px" type="text" onfocus="this.select();" value="<?php echo $xaphuong?>" name="xaphuong" id="xaphuong"  />
</div>

<div class="clear"></div>
<div class="right_row1">Quận/Huyện</div>
<div class="right_row2">
  <input class="full" style="width:200px" type="text" onfocus="this.select();" value="<?php echo $quanhuyen?>" name="quanhuyen" id="quanhuyen"  />  <span class="txtdo">*</span>
</div>

<div class="clear"></div>
<div class="right_row1">Tỉnh/Thành Phố</div>
<div class="right_row2">
<?php

      $rstTinh=$dbf->getDynamic("city_vietnam","status=1","title asc");
      echo'<select name="tinhthanh" id="tinhthanh" size="0" class="" style="width:205px !important">
           <option value="">- Chọn tỉnh/thành phố -</option>';
      while($row = $dbf->nextData($rstTinh))
       {
          echo'<option '.(($tinhthanh==$row['id'])?"selected":"").' value="'.$row['id'].'">'.$row['title'].'</option>';
       }

      echo'</select>';

?>
     <span class="txtdo">*</span>
</div>

<div class="clear"></div>
<div class="right_row1">Số điện thoại</div>
<div class="right_row2">
   <input class="full" style="width:200px" type="text" onfocus="this.select();" value="<?php echo $didong?>" name="didong" id="didong" onkeypress="return nhapso(event,'didong')"  />
   <span class="txtdo">*</span>
</div>
</fieldset>

<div class="clear" style="padding-top:10px"></div>
<fieldset style="border: 1px solid #999; padding: 5px;">
<legend><b>Thông tin thanh toán</b></legend>
<div class="clear" style="padding-top:10px"></div>

<div class="clear"></div>
<div class="right_row1">Tên chủ tài khoản</div>
<div class="right_row2">
   <input class="full" style="width:200px" type="text" onfocus="this.select();" value="<?php echo $tenchutaikhoan?>" name="tenchutaikhoan" id="tenchutaikhoan"  />
</div>

<div class="clear"></div>
<div class="right_row1">Số tài khoản</div>
<div class="right_row2">
   <input class="full" style="width:200px" type="text" onfocus="this.select();" value="<?php echo $sotaikhoan?>" name="sotaikhoan" id="sotaikhoan" onkeypress="return nhapso(event,'sotaikhoan')"   />
</div>

<div class="clear"></div>
<div class="right_row1">Ngân hàng</div>
<div class="right_row2">
   <input class="full" style="width:200px" type="text" onfocus="this.select();" value="<?php echo $nganhang?>" name="nganhang" id="nganhang"  />
</div>

<div class="clear"></div>
<div class="right_row1">Chi nhánh</div>
<div class="right_row2">
   <input class="full" style="width:200px" type="text" onfocus="this.select();" value="<?php echo $chinhanh?>" name="chinhanh" id="chinhanh"  />
</div>


</fieldset>

<div class="clear" style="padding-top:10px"></div>
<fieldset style="border: 1px solid #999; padding: 5px;">
<legend><b>Mã bảo vệ</b></legend>
<div class="clear" style="padding-top:10px"></div>
<div class="right_row1">Mã bảo vệ</div>
<div class="right_row2">
     <div id="captchaimage"><a href="javascript:void(0);" id="refreshimg" title="Click to refresh image">
     <img src="captchaimages/image.php?<?php echo time()?>" border="0" width="140" height="50" alt="Captcha image" /></a></div>
     <input type="text" maxlength="10" name="captcha" id="captcha" onfocus="this.select()" class="inputCode" />
</div>

</fieldset>
<div class="clear" style="padding-top:10px"></div>
<div class="clear"></div>

<fieldset style="border: 0">
<div class="right_row1"></div>
<div class="right_row2">
<?php
if($isEdit)
{
?>
<input type="submit"  value="Cập nhật" name="ok" id="ok" />
<input type="button"  onclick="window.location='/account.html';" value="Hủy cập nhật" name="retype" id="retype" />

<?php
}else{
?>
<input type="submit"  value="Tạo tài khoản" name="ok" id="ok"  />
<input type="reset" value="Nhập lại" name="retype" id="retype" />
<input type="button" onclick="window.location.href='/home.html'" value="Trở lại trang Đăng nhập" name="retype" id="retype" />
<?
}
?>
</div>
</fieldset>
<div class="clear" style="padding-top:8px"></div>
</div>

<!--check form-->

<?php
  echo $html->closeForm();
?>
<script type="text/javascript">
$(function(){
	$("#refreshimg").click(function(){
		$.post('captchanewsession.php');
		$("#captchaimage").load('captchaimage_req.php');
		return false;
	});
});
$().ready(function() {
$("#frm").validate({
            debug: false,
            errorElement: "em",
            success: function(label) {
    				label.text("").addClass("success");
    		},

           rules: {
			tendangnhap: {
				required: true,
				minlength: 6
			},
            password: {
				required: true,
				minlength: 6
			},

            email: {
				required: true,
				email: true
			},

			parentid: {
				required: true
			},

			hovaten:{
              required: true
			},

			date_ngaysinh: {
				required: true
			},

            cmnd: {
				required: true,
				number: true,
				minlength: 9,
			},

            date_ngaycap: {
				required: true
			},
			noicap: {
				required: true
			},

            diachi: {
				required: true
			},

            quanhuyen: {
				required: true
			},

            tinhthanh: {
				required: true
			},

			didong: {
				required: true,
				number: true
			},
            captcha:
            {
              required: true,
              remote: "captchaprocess.php"
            }
    		},

          messages: {
			tendangnhap: {
				required: "Tài khoản đăng nhập không được để trống",
				minlength: "Người giới thiệu trực tiếp phải từ 6 ký tự trở"
			},
            password: {
				required: "Mật khẩu không được để trống",
				minlength: "Mật khẩu phải có ít nhất 6 ký tự"
			},

            email: {
				required: "Email không được để trống",
				email: "Email không đúng định dạng",
			},
			parentid: {
				required: "Nhập mã ID người bảo trợ"
			},

			hovaten:{
              required: "Tên đầy đủ không được để trống"
			},
			date_ngaysinh: {
				required: "Ngày sinh không được để trống"
			},

            cmnd: {
				required: "CMND không được để trống",
				number: "CMND không đúng định dạng",
				minlength: "CMND phải có ít nhất 9 ký tự",
			},

            date_ngaycap: {
				required: "Ngày Nơi cấp CMND không được để trống"
			},
			noicap: {
				required: "Nơi cấp CMND không được để trống"
			},

            diachi: {
				required: "Đia chỉ không được để trống"
			},

            quanhuyen: {
				required: "Quận huyện không được để trống"
			},

            tinhthanh: {
				required: "Tỉnh thành không được để trống"
			},


			didong: {
				required: "Số điện thoại không được để trống",
				number: "Số điện thoại không đúng định dạng",
			},
            captcha:
            {
                required: "Nhập mã bảo vệ"

            }
		}

	});
});

</script>
</div>
<div class="clear"></div>