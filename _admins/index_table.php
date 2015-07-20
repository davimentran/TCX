<?php
	ob_start("zlib output compression");
	session_start();

    if(empty($_SESSION["user_login"])) {
        session_unregister("user_login");
		echo "<script>window.location.href='login.php'</script>";
        exit;
	}
    include str_replace('\\','/',dirname(__FILE__)).'/content_spaw/spaw.inc.php';
    include str_replace('\\','/',dirname(__FILE__)).'/class/class.DEFINE.php';
    include str_replace('\\','/',dirname(__FILE__)).'/class/class.HTML.php';
    include str_replace('\\','/',dirname(__FILE__)).'/class/class.JAVASCRIPT.php';
    include str_replace('\\','/',dirname(__FILE__)).'/class/class.UTILITIES.php';
    include str_replace('\\','/',dirname(__FILE__)).'/class/class.CSS.php';
    include str_replace('\\','/',dirname(__FILE__)).'/class/class.SINGLETON_MODEL.php';
    include str_replace('\\','/',dirname(__FILE__)).'/class/simple_html_dom.php';
    include str_replace('\\','/',dirname(__FILE__)).'/class/class.BUSINESSLOGIC.php';
    include str_replace('\\','/',dirname(__FILE__)).'/class/template.php';
	include str_replace('\\','/',dirname(__FILE__)).'/Cache_Lite/Lite/Function.php';

    $html=SINGLETON_MODEL::getInstance("HTML");
	$js=SINGLETON_MODEL::getInstance("JAVASCRIPT");
	$css=SINGLETON_MODEL::getInstance("CSS");
    $utl=SINGLETON_MODEL::getInstance("UTILITIES");
    $dbf=SINGLETON_MODEL::getInstance("BUSINESSLOGIC");
	$html->docType();

	$CONFIG = $dbf->loadSetting();
	if($_GET['table_name'])
		$_SESSION['table_name'] = $_GET['table_name'];

	if($_SESSION['table_name']!='')
    {
    	$arrayTitle=$dbf->getArray("sys_table","table_name='".$_SESSION['table_name']."'","","stdObject");
    	if(is_array($arrayTitle))
    			foreach($arrayTitle as $value) {
    					$arrayHeader["Page"]=stripslashes($value->title);
    					$arrayHeader["title"]=str_replace("{PAGE_NAME}",$utl->stripUnicode($arrayHeader["Page"]),$arrayHeader["title"]);
    					$arrayHeader["title"]=str_replace("{SESSION_USER}",$utl->stripUnicode($_SESSION['user_login']['fullname']),$arrayHeader["title"]);
    	}
    }
	$options = array(
    'cacheDir' => 'tmp/',
    'lifeTime' => 3600
	);
	$cache = new Cache_Lite_Function($options);
	$html->openHTML();
	$html->openHead();
	$html->displayHead($arrayHeader["utf8"],$arrayHeader["refresh"],$arrayHeader["title"],$arrayHeader["keywords"],$arrayHeader["description"],$arrayHeader["copyright"],$arrayHeader["icon"]);
    $arrayCSS=array(pathTheme."/style/style.pack.css","css/ui.all.css","style/jquery.Slidemenu.css"); foreach($arrayCSS as $value) $css->linkCSS($value);
	$html->closeHead();
	$html->openBody(array("div" => "divSwap"));
	$arrayJS=array("js/jquery-1.3.2.min.js","js/jquery.validate.pack.js","js/adminLib.js","js/ui.datepicker.js","js/jquery.Slidemenu.js","js/jquery.query.js"); foreach($arrayJS as $value) $js->linkJS($value);
    $html->normalForm("frm",array("action"=>"","method"=>"post"));
    $dbf->showAdminHome($CURRENT_PAGE);
	$dbf->huy($CURRENT_PAGE."?".QUERY_STRING);
?>