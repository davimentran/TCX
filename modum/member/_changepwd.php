<div class="post block" style="padding: 20px">
<?php include("linkmember.php");?>
<div style="clear: both"></div>
<?php
if($_SESSION["Free"]==1)
{
	$html->redirectURL("login.html");
}
?>

<?php
    $msg="";
	if(isset($_POST["subchange"]))
	{
        $oldpassword=$_POST["oldpassword"];
		$oldpassword=md5($oldpassword);
		$newpassword=$_POST["newpassword"];
		$newpassword=md5($newpassword);
		$confirmpassword=$_POST["confirmpassword"];
		$confirmpassword=md5($confirmpassword);
		$code=strtoupper($_POST["captcha"]);
		if($code!=$_SESSION["captcha_id"])
		{
			$msg="Mã bảo vệ sai";
		}else
		{
	        $rstcheck=$dbf->getDynamic("member","id='".$_SESSION["member_id"]."' and password='".$oldpassword."'","");
			if($dbf->totalRows($rstcheck)>0)
			{
				$affect=$dbf->updateTable("member",array("password"=>$newpassword),"id='".$_SESSION["member_id"]."'");
                $html->redirectURL("/change-password/success/");
				//$msg="Tài khoản đã được cập nhật";
			}else
			{
			    $html->redirectURL("/change-password/error/");
				//$msg="Tài khoản không tồn tại";
			}
		}
	}

require 'captcharand.php';
$_SESSION['captcha_id'] = strtoupper($strcaptcha);
?>
<?php
 echo $html->normalForm("frmchange",array("class"=>"","action"=>"","method"=>"post"));
?>
   <div class='title_header'>ĐỔ MẬT KHẨU</div>
   <div class="pro_c">
   
    <?php
        if($URL[1]=='success')
        {
          echo'<div style="text-align:left;padding-left:15px"><span class="saodo">Thay đổi mật khẩu thành cồng</span></div>';
        }

        if($URL[1]=='error')
        {
           echo'<div style="text-align:left;padding-left:15px"><span class="saodo">Thay đổi mật khẩu thất bại. Vui lòng thực hiện lại</span></div>';
        }
    ?>

    <div id="clear"></div>
    <div class="productall1">
    <div class="clear" style="padding-top:5px;"></div>
	<div class="right_row1">Mật khẩu cũ</div>
	<div class="right_row2">
	    <input class="full" type="password" maxlength="30" onFocus="this.select()" name="oldpassword" id="oldpassword"/><span class="saodo">*</span>
	</div>
	<div class="clear"></div>
	<div class="right_row1">Mật khẩu mới</div>
	<div class="right_row2">
	    <input class="full" type="password" maxlength="30" onFocus="this.select()" name="newpassword" id="newpassword"/><span class="saodo">*</span>
	</div>
	<div class="clear"></div>
	<div class="right_row1">Nhập lại mật khẩu</div>
	<div class="right_row2">
	    <input class="full" type="password" maxlength="30" onFocus="this.select()" name="confirmpassword" id="confirmpassword"/><span class="saodo">*</span>
	</div>
    <div class="clear"></div>
    </div>
    <div class="clear"></div>

	<div class="clear" style="padding-top:7px;"></div>
     <div class="title">
      <b>MÃ BẢO VỆ</b>
     </div>
    <div class="productall1">
	<div class="clear" style="padding-top:5px;"></div>
	<div class="right_row1">Mã bảo vệ</div>
	<div class="right_row2">
        <div id="captchaimage"><a href="javascript:void(0);" id="refreshimg" title="Click to refresh image">
        <img src="captchaimages/image.php?<?php echo time()?>" border="0" width="140" height="50" alt="Captcha image" /></a></div>
        <input type="text" maxlength="10" name="captcha" id="captcha" onfocus="this.select()" class="inputCode" /><span class="saodo">*</span>
	</div>

	<div class="clear"></div>
        <div class="right_row1"></div>
      	<div class="right_row2">
      	<input type="submit" value="Thay đổi mật khẩu" name="subchange" id="subchange"  />
        <input type="button" value="Trở về" name="butback" id="butback"  />
      	</div>

    <div class="clear"></div>
    </div>
 </div>
 <div class='box_bottom_main'></div>

<?php echo $html->closeForm();?>

<script language="javascript">

$("#butback").click( function(){
  window.location.href='/account.html';
});

$(function(){
	$("#refreshimg").click(function(){
		$.post('captchanewsession.php');
		$("#captchaimage").load('captchaimage_req.php');
		return false;
	});
});
$().ready(function() {
$("#frmchange").validate({
            debug: false,
            errorElement: "em",
            success: function(label) {
    				label.text("").addClass("success");
    		},
    		rules: {
              oldpassword:
              {
                required: true
              },
              newpassword:
              {
                required: true,
                minlength: 6

              },
              confirmpassword:
              {
                required: true,
                equalTo: "#newpassword"
              },

              captcha:
              {
                required: true,
                remote: "captchaprocess.php"
              }
    		},
            messages:
            {

              oldpassword:
              {
                required: "Nhập mật khẩu cũ"
              },
              newpassword:
              {
                required: "Nhập mật khẩu mới",
                minlength: "Ký tự phải nhiều hơn 6"
              },
              confirmpassword:
              {
                required: "Nhập lại mật khẩu mới",
                equalTo: "Mật khẩu không trùng khớp"
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


