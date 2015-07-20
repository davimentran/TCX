<?php
    if(isset($_POST["submitlogin"]))
    {
      	$username=$_POST["username"];
        $password=$_POST["password"];
    	$username=$dbf->escapeStr($username);
        $password=$dbf->escapeStr($password);

        $MaID   = explode($info["MS"],$username);
        array_shift($MaID);
        if((int)$MaID[0] > 0 )
        {
          $MaID_Current = $MaID[0];

        }else
        {
           $MaID_Current="-1";
        }

        $password=md5($password);
  		$query=$dbf->getDynamic("member","(tendangnhap='".$username."' || id=".(int)$MaID_Current.") and password='".$password."'","");
  		if($dbf->totalRows($query)>0)
  		{
  		        $row=$dbf->nextData($query);
                  $_SESSION["member_id"]          = stripslashes($row["id"]);
                  $_SESSION["member_email"]       = $email;
                  $_SESSION["member_hovaten"]   = stripslashes($row["hovaten"]);
                  $_SESSION["Free"]=0;
                  $html->redirectURL("account.html");
  		}
  		else
  		{
  				$msg="Mã ID hoặc Mật khẩu sai. Vui lòng thực hiện lại";
  		}

    }
?>
<div class="logo" style="text-align: center;  margin-top: 150px; margin-bottom: 20px ">
    <img src="style/images/logo.png" alt="" />
</div>
<div class="post login">
<div class='title_header'>Đăng Nhập thành viên</div>
<div class="pro_c">
      <form name="frmLogin" id="frmLogin" action="/login.html" method="post">
      <div style="text-align:left">
            <div class="lblError"><?=$msg?></div>
            <div style="font-size:12px;text-align:left;width:260px;padding:5px"><span align="left" style="padding-left:0px;" id="lblError" class="saodo"></span></div>
            <div id="clear"></div>
            <div id="labelLogin">Username hoặc Mã ID</div>
            <div id="fieldLogin">
            <input type="text" onfocus="this.select();" class="username" id="username" name="username">
            <span class="lblError" id="lblemail"></span></div>

            <div class="clear" style="padding-top:2px"></div>
            <div id="labelLogin">Mật khẩu</div>
            <div id="fieldLogin">
            <input id="password" class="username" type="password" onfocus="this.select();" maxlength="30" name="password"><span class="lblError" id="lblpassword"></span>
            </div>
            <div id="clear" style="padding-top:2px"></div>
            <div id="labelLogin"></div>
            <div style="float:left">
                <input type="submit" name="submitlogin" id="submit" value="Đăng nhập" />
            </div>
            <div id="clear"></div>
            <div style="border-bottom:2px dotted #1a8aca;height:15px"></div>
            <div style="text-align:left;padding-top:8px">
                <a class="itempathhome" href="forgot-password.html">Quên mật khẩu</a>
                &nbsp;|&nbsp;
                <a class="itempathhome" href="register.html">Đăng ký</a>
            </div>

      </div>
      </form>
      <div id="clear"></div>
</div>
<div class='box_bottom_main'></div>
<script language="javascript">
jQuery().ready(function() {

  jQuery("#frmLogin").validate({
                  debug: false,
                  errorElement: "em",
                  success: function(label) {
          				label.text("").addClass("success");
          		},
          		rules: {
          		  username:
                    {
                      required: true
                    },
                    password:
                    {
                      required: true
                    }
          		},
                  messages:
                  {

                    username:
                    {
                      required: "Vui lòng nhập Username hoặc MãID"
                    },
                    password:
                    {
                      required: "Vui lòng nhập mật khẩu"
                    }
                  }
      	});
});
</script>
</div>

