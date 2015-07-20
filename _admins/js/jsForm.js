function checkMember(type)
{
    try
    {
      if(type=="insert")
      {
        if(document.frm.username.value.length<=5)
    	{
    		document.frm.username.focus();
    		return false;
    	}
      }
      if(type=="insert" || (type=="update" && document.frm.chk_password.checked))
      {
        if(document.frm.password.value.length<=5)
      	{
      		document.frm.password.focus();
      		return false;
      	}
        if(document.frm.confirmpassword.value.length<=5)
      	{
      		document.frm.confirmpassword.focus();
      		return false;
      	}
      }
        if(document.frm.confirmpassword.value!=document.frm.password.value)
      	{
      	    alert("Mật khẩu không trùng khớp");
      		document.frm.confirmpassword.focus();
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
function showPassword(pwd,confirmpwd,checked)
{
  document.getElementById(pwd).disabled=!checked;
  document.getElementById(confirmpwd).disabled=!checked;
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
