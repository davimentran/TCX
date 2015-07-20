<?php
include("index_table.php");
$arrayConst["table_name"] = $_SESSION['table_name'];
if($arrayConst["table_name"]=='sys_table'){
	$dbf->update_sys_table();	
}else
if($arrayConst["table_name"]=='sys_field'){
	$dbf->update_sys_field($_GET['table_id']);	
}

$rules_script="";
$messages_script="";
$function_permission = $_SESSION['permission'][$dbf->getValueOfQuery('SELECT id FROM sys_table WHERE table_name="'.$arrayConst["table_name"].'"')];
//print_r($function_permission);

$arrayConst["titlePage"] = $dbf->getValueOfQuery('SELECT title FROM sys_table WHERE table_name="'.$arrayConst["table_name"].'"');
$arrayConst["page_name"] = $pageAdmin;
$arrayConst['isInsert'] = $isInsert ;
$arrayConst['isEdit'] = $isEdit ;
$arrayConst['url'] = $pageAdmin."?";
$arrayConst['filter_parameter'] = $dbf->SPLIT_ARRAY_QUERY_STRING(QUERY_STRING);
$arrayConst['url'] = $pageAdmin."?";
$arrayConst['statusAction'] = $statusAction ;
$arrayConst['statusActive'] = $statusActive ;

//echo $arrayConst['url'];

$arrayConst['urlstring'] = QUERY_STRING;

$Meta=$dbf->getMetaData_vlink($arrayConst["table_name"]);
/* Action performed ************************************************************/

//$msg=$dbf->actionPerformed($isDelete,$subInsert,$subUpdate,$isEdit,$arrayConst["table_name"],$_POST["arrayid"],$Meta['Col'],&$arrayValue,$Meta['pk'],"",$Meta['pk']."=".$_GET['edit']);
$msg=$dbf->actionPerformed($isDelete,$subInsert,$subUpdate,$isEdit,$arrayConst["table_name"],$_POST["arrayid"],
$Meta['Col'],$arrayValue,$Meta['pk'],"",$Meta['pk']."=".$_GET['edit']);

$arrayConst['arrayValue'] = $arrayValue ;
$arrayConst['Meta'] = $Meta ;

 if(isset($_POST["doiquyen_webmaster"]))
 {
  $_SESSION["user_login"]["role_id"]=$_POST["doiquyen_webmaster"];
  $_SESSION["permission"] = $dbf->getPermission($_POST["doiquyen_webmaster"]);
  $_SESSION["user_login"]["is_show_menu_left"]=$dbf->getValueOfQuery('SELECT is_show_menu_left FROM webmaster_roles WHERE id='.$_SESSION["user_login"]["role_id"]);
  echo "<script>window.location='index.php'</script>";
 }
/* Start Form ******************************************************************/
        if($isInsert || $isEdit ){

                if($isInsert)
            		$arrayConst['arrayValue'] = $_GET;
            	$dbf->generateForms_main($arrayConst);
        }/* End Form *******************************************************************/

if(!$isEdit && !$isInsert){ /* Gridview ****************************************/
    if($function_permission['is_list'])
    {
	$isCatURL = array();
	$cbo = array();
	foreach($arrayConst['Meta']['Field'] as $Field => $FieldInfo){
		if($FieldInfo['isFilter']){
			if($FieldInfo['Type']!='int'){

			    //echo $arrayConst["filter_parameter"][$Field];
				$arrayConst["filter_parameter"][$Field] = str_replace('+',' ',$arrayConst["filter_parameter"][$Field]);
                $cbo=$dbf->textFilter($Field,$arrayConst["filter_parameter"][$Field],$FieldInfo['Label'].' ',array("text"=>"Select","onchange"=>"updateCategory(this,$('#arrayid').attr('value'));","firstText"=>"Select"));
				$isCatURL[] = $Field." LIKE '%".$arrayConst["filter_parameter"][$Field]."%'";	
				$arrayConst["filter_parameter"][$Field] = "";				
			}else
			if(!$FieldInfo['fk_isMultiLevel']){		
				$cbo=$dbf->selectFilterNoRecursive($Field,$FieldInfo['fk_text'], $FieldInfo['fk_value'], $arrayConst["filter_parameter"][$Field], $FieldInfo['Label'].' ',$FieldInfo['fk_from'],$FieldInfo['fk_where'],$FieldInfo['fk_orderby'],array("text"=>"Select","onchange"=>"updateCategory(this,$('#arrayid').attr('value'));","firstText"=>"Select"));
				if($arrayConst["filter_parameter"][$Field]){
					$isCatURL[] = $Field." = '".$arrayConst["filter_parameter"][$Field]."'";
				}
			}else{

				$cbo=$dbf->selectFilter($Field,$FieldInfo['fk_text'], $FieldInfo['fk_value'], $arrayConst["filter_parameter"][$Field], $FieldInfo['Label'].' ',$FieldInfo['fk_from'],array("text"=>"Select","onchange"=>"updateCategory(this,$('#arrayid').attr('value'));","firstText"=>"Select"));
				if($arrayConst["filter_parameter"][$Field]){				
					$isCatURL[] = $Field." = '".$arrayConst["filter_parameter"][$Field]."'";					
				}
			}
			$combo[] = '<div '.(($_GET["table_name"]=="member")?"style='float:left'":"").'>'.$cbo.'</div>';
		}
	}?>

    <?php

    //echo $_SESSION["user_login"]["role_id"];
    echo $dbf->returnTitleMenuTable($arrayConst["titlePage"]);

    if($Meta['list_page_size']){
		$PageSize = $Meta['list_page_size'];
	}

	if($_GET['list_sortable_field']){
		if(!$_GET['list_sortable_direction']){
			$_GET['list_sortable_direction'] = 'ASC';
		}
		$Meta['list_orderby'] = $_GET['list_sortable_field'].' '.$_GET['list_sortable_direction'];
	}
    //exit();
	$mang=$dbf->paging_cursor_vlink('*',$arrayConst["table_name"],implode(' AND ',$isCatURL),$Meta['list_orderby'],'',$PageNo,$PageSize,$Pagenumber,$ModePaging);
    //phan quyen them
    //echo $function_permission['is_insert'];
    if($function_permission['is_insert'])
    {
      $flat = 'true';
    }
    else{
      $flat = 'false';
    }

    echo $dbf->panelAction($mang[1],null,null,array(0=>true,1=>$flat,2=>false,3=>false,5=>false,6=>false,7=>false,8=>false,9=>false),$arrayConst["table_name"]);
	echo $dbf->panelFilter(implode('',$combo));
    echo $dbf->showError($msg);
	$arrayConst['rst'] = $mang[0];
	$arrayConst['StartRow'] = $mang[5];
    echo $dbf->normalView_main($arrayConst);
  }
	
}/* End Gridview ***************************************************************/

 $dbf->Footer();


 ?>

<script language="javascript">
    jQuery(function() {

    var v = jQuery("#frm").validate({
                debug: false,
                errorElement: "em",
                success: function(label) {
        				label.text("!ok").addClass("success");
        		},
                rules: {
                 <?=$rules_script?>
        		},

                messages:
                {
                  <?=$messages_script?>
                }
        });
    });

function doiquyen(id)
{
  document.frm.submit();
}

</script>