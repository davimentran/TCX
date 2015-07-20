<?php
  if ( extension_loaded('zlib') and !ini_get('zlib.output_compression') and ini_get('output_handler') != 'ob_gzhandler' and ((version_compare(phpversion(), '5.0', '>=') and ob_get_length() == false) or ob_get_length() === false) ) {
          ob_start('ob_gzhandler');
  }
  header("Cache-Control: public");
  header("Pragma: cache");
  $offset = 5184000; // 60 * 60 * 24 * 60
  $ExpStr = "Expires: ".gmdate("D, d M Y H:i:s", time() + $offset)." GMT";
  $LmStr = "Last-Modified: ".gmdate("D, d M Y H:i:s", filemtime($_SERVER['SCRIPT_FILENAME']))." GMT";
  header($ExpStr);
  header($LmStr);
  header('Content-Type: text/javascript; charset: UTF-8');
?>
function checkMember()
{
    try
    {
        if(document.frm.username.value.length<=5)
    	{
    		document.frm.username.focus();
    		return false;
    	}
        if(document.frm.password.value.length<=5)
      	{
      		document.frm.password.focus();
      		return false;
      	}
        if(document.frm.fullname.value=="")
    	{
    		document.frm.fullname.focus();
    		return false;
    	}
    	if(!isEmail(document.frm.email.value))
    	{
    		document.frm.email.focus();
    		return false;
    	}
        if(document.frm.tel.value!="")
    	{
            if(!validTel(document.frm.tel.value))
            {
    		    document.frm.tel.focus();
    		    return false;
            }
    	}
        if(document.frm.mobile.value!="")
    	{
            if(!validTel(document.frm.mobile.value))
            {
    		    document.frm.mobile.focus();
    		    return false;
            }
    	}
    }catch(ex)
    {
        if(confirm("Không hỗ trợ javascript kiểm tra dữ liệu cho những hành động nào tác động lên nhiều mẫu tin.\n"+
        "Bạn có muốn tiếp tục thực hiện mà không có kiểm tra dữ liệu thông qua javascript không?"))
        return true;
        else return false;
    }

}
/*
****************************************************/
function checklogin(){
    try
    {
        if(document.frmlogin.protectioncode.value=="")
        {
        	alert("Please enter protection code");
        	document.frmlogin.protectioncode.focus();
        	document.all['div'].style.visibility='visible';
        	return false;
        }else{document.all['div'].style.visibility='hidden';}
        if(document.frmlogin.username.value==""){
        	alert("Please enter your username");
        	document.frmlogin.username.focus();
        	document.all['lblusername'].style.visibility='visible';
        	return false;
        }else{document.all['lblusername'].style.visibility='hidden';}
        if(document.frmlogin.password.value==""){
        	alert("Please enter your password");
        	document.frmlogin.password.focus();
        	document.all['lblpassword'].style.visibility='visible';
        	return false;
        }else{document.all['lblpassword'].style.visibility='hidden';}
        return true;
    }catch(ex)
    {
        alert("Trình duyệt không hỗ trợ javascript");
        return false;
    }
}
/*
****************************************************/
function checkaccount(state)
{
    try
    {
        if(document.frm.username.value=="")
    	{
    		document.frm.username.focus();
    		return false;
    	}
        if((state=="1" && document.frm.chkupdate.checked)||(state=="0"))
        {
        	if(document.frm.password.value=="")
        	{
        		document.frm.password.focus();
        		return false;
        	}
        	if(document.frm.password.value.length<=5)
        	{
        		document.frm.password.focus();
        		return false;
        	}
        	if(document.frm.confirmpassword.value=="")
        	{
        		document.frm.confirmpassword.focus();
        		return false;
        	}
        	if(document.frm.confirmpassword.value!=document.frm.password.value)
        	{
        		alert("Mật khẩu không trùng khớp");
        		document.frm.confirmpassword.value="";
        		document.frm.confirmpassword.focus();
        		return false;
        	}
        }
    	if(document.frm.fullname.value=="")
    	{
    		document.frm.fullname.focus();
    		return false;
    	}
    	if(document.frm.email.value=="")
    	{
    		document.frm.email.focus();
    		return false;
    	}
    	if(!isEmail(document.frm.email.value))
    	{
    		document.frm.email.focus();
    		document.frm.email.select();
    		return false;
    	}
        if(document.frm.questionaire.value.length<=6)
        {
            document.frm.questionaire.focus();
            return false;
        }
    	return true;
    }catch(ex)
    {
        return;
    }
}