$(function(){
	$("#refreshimg").click(function(){
		$.post('captchanewsession.php');
		$("#captchaimage").load('captchaimage_req.php');
		return false;
	});
});
$().ready(function() {

  $("#frmLogin").validate({
              debug: false,
              errorElement: "em",
              success: function(label) {
      				label.text("!ok").addClass("success");
      		},
      		rules: {
      		  username:
                {
                  required: true,
                  maxlength: 30
                },
                password:
                {
                  required: true,
                  maxlength: 30
                },
                capcha:
                {
                  required: true,
                  remote: "captchaprocess.php"
                }
      		},
              messages:
              {
                username:
                {
                  required: "Nhập username",
                  maxlength: "Tối đa 30 kí tự"
                },
                password:
                {
                  required: "Nhập mật khẩu",
                  maxlength: "Tối đa 30 kí tự"
                },
                capcha:
                {
                  required: "Nhập mã xác nhận",
                  remote: "Mã bảo vệ sai. Bạn có thể click lên captcha để refresh lại nếu hình không hiển thị"
                }
              }
  	});
});