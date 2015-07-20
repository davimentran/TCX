<?php
ob_start();
session_start();
echo '<a id="refreshimg" href="javascript:void(0);"  title="Click to refresh image"><img border="0" src="captchaimages/image.php?' . time() . '" height="50" alt="Captcha image" /></a>';
?>
<script language="javascript">
    $(function(){
    	$("#refreshimg").click(function(){
    		$.post('captchanewsession.php');
    		$("#captchaimage").load('captchaimage_req.php');
    		return false;
    	});
    });
</script>
<?php
    ob_end_flush();
?>