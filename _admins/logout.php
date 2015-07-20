<?
//ob_start();
session_start();
    include str_replace('\\','/',dirname(__FILE__)).'/class/class.DEFINE.php';
	include str_replace('\\','/',dirname(__FILE__)).'/class/class.DBFUNCTION.php';
	include str_replace('\\','/',dirname(__FILE__)).'/class/class.SINGLETON_MODEL.php';
	$dbf=SINGLETON_MODEL :: getInstance("DBFUNCTION");

if(session_is_registered("user_login")){
	session_destroy();
	session_unregister("user_login");
	echo "<script>window.location.href='login.php'</script>";
		
}
else
{
    header( "Location: login.php" );
}
//ob_end_flush();

?>