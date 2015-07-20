<?php
	include str_replace('\\','/',dirname(dirname(__FILE__))).'/../class/config.DATABASE.php';
	class DBFUNCTION {
			private $connect=null;
			function __construct()
			{
               $this->dbConnect();
			}
			function getConnect()
			{
				return $this->connect;
			}
			function __destruct()
			{
				$this->connect=null;				
			}
			function dbConnect()
			{
				try {						
						if(empty($this->connect))
						{							
							$this->connect=mysql_pconnect(HOSTADDRESS,DBACCOUNT,DBPASSWORD);
							$result = mysql_select_db(DBNAME,$this->connect);
							mysql_query("SET NAMES utf8");

							return $result;
						}
						
				}catch (Exception $ex) {

						return false;
				}
			}
			function dbClose()
			{
				if($this->connect!=null)
				{
					mysql_close($this->connect);
					$this->connect=null;
				}
			}
			/* Remove SQLInjection
			-----------------------------------------------------------------*/
			function escapeStr($str)
			{
				return mysql_real_escape_string($str,$this->connect);
			}

			function removeSQLInjection($str) {
				return mysql_real_escape_string($str,$this->connect);
			}
			/*
			-----------------------------------------------------------------*/
			function getScale($tbName,$condition,$orderby,$arrayCol=null)
			{
				try {
						$this->dbConnect();
						$orderby=(!empty($orderby))?" ORDER BY ".$orderby:'';
						$condition=(!empty($condition))?' WHERE '.$condition:'';
						$sql="SELECT ".$type."(".$col.") FROM ".$tbName."  ".$condition."  ".$orderby;
						$rst=$this->doSQL($sql);
						if($row=$this->nextAssoc($rst))$count=(int)$row[0];

						return $count;
				}catch (Exception $ex) {

						return 0;
				}
			}
			
			function getValueOfQuery($sql){
				$rst =  $this->doSQL($sql);
				$row = @mysql_fetch_array($rst);
				return $row[0];
			}			
			/* Get data dynamic
			-----------------------------------------------------------------*/
			function getDynamic($tbName,$condition,$orderby) {
				try {
						$this->dbConnect();
						$orderby=(!empty($orderby))?' ORDER BY '.$orderby:'';
						$condition=(!empty($condition))?' WHERE '.$condition:'';
						$sql='SELECT * FROM '.$tbName.'  '.$condition.'  '.$orderby;
                          $rst=$this->doSQL($sql);
                          //echo $sql;
						return $rst;
				}catch (Exception $ex)
				{

						return null;
				}
			}
			
			/* Get data dynamic
			-----------------------------------------------------------------*/
			function getDynamic_cursor($select,$tbName,$condition,$orderby) {
				try {
						$this->dbConnect();
						$orderby=(!empty($orderby))?' ORDER BY '.$orderby:'';
						$condition=(!empty($condition))?' WHERE '.$condition:'';

                        $sql='SELECT '.$select.' FROM '.$tbName.'  '.$condition.'  '.$orderby;
                        if ($_REQUEST['debug']==1) echo $sql;
                         $rst=$this->doSQL($sql);
                        return $rst;

				}catch (Exception $ex)
				{

						return null;
				}
			}			

			function insertTable($tbName,$arrayValue) {
				try {
						$array=array(2);
						$this->dbConnect();
                           if(count($arrayValue)>0)
                           {
                               foreach($arrayValue as &$value)$value=$this->removeSQLInjection($value);
   							$sql="INSERT INTO ".$tbName."(".implode(",",array_keys($arrayValue)).") VALUES('".implode("','",array_values($arrayValue))."')";
                               $affect=$this->doNoSQL($sql);
   							if ($_REQUEST['debug']==1){
								echo $sql;
							}
							$id=mysql_insert_id($this->connect);

   							$array []=$affect;
   							$array []=$id;
                               unset($id);
                               unset($affect);
                               return $array;
                           }
				}catch (Exception $ex) {

						return null;
				}
			}
			/* Update table
			-----------------------------------------------------------------*/
			function updateTable($tbName,$arrayValue,$condition,$type="UPDATE") {
				try {
						$str='';
                        $type=strtoupper($type);
						$condition=(!empty($condition))?' WHERE '.$condition:'';
						$this->dbConnect();
						foreach($arrayValue as $key => $value) {
								if(strpos("$arrayValue[$key]","$key")===false)$str.="$key='".$this->removeSQLInjection($arrayValue[$key])."',";
								else $str.="$key=".$this->escapeStr($arrayValue[$key]).",";
						}
						$str=substr($str,0,strlen($str)-1);
						if($type=="INSERT")	$sql="INSERT INTO ".$tbName." SET ".$str;
						else $sql="UPDATE ".$tbName." SET ".$str." ".$condition;
					    $affect=$this->doNoSQL($sql);
                           unset($str);
                           unset($sql);

						return (int)$affect;
				}catch (Exception $ex) {

						return 0;
				}
			}
			/* Delete dynamic
			-----------------------------------------------------------------*/
			function deleteDynamic($tbName,$condition) {
				try {
						$this->dbConnect();
						$condition=(!empty($condition))?' WHERE '.$condition:'';
						$sql="DELETE FROM ".$tbName." ".$condition;
                           $affect=$this->doNoSQL($sql);

                           unset($condition);
                           unset($sql);
						return $affect;
				}catch (Exception $ex) {

						return 0;
				}
			}
			
			function delete_node_no_parent(){
				$rst = $this->doSQL('SELECT id FROM front_div fd WHERE (NOT EXISTS (SELECT t.id FROM front_div t WHERE t.id=fd.parentid))');
				while($rs=$this->nextData($rst)) {
				    $parentid = $rs['id']; 
					$affect+= $this->deleteDynamic('front_div',"id=$parentid");	
				}				
				echo $affect;exit;
			}
			

			function delete_parent($tbName,$parentid){
				if(!$parentid) return 0;
				$rst=$this->getDynamic($tbName,"parentid=$parentid","");
				while($rs=$this->nextData($rst)) {
					$affect+= $this->delete_parent($tbName,$rs['id']);	
				}
				$affect+= $this->deleteDynamic($tbName,"id=$parentid");							
				return $affect;
			}
			
			/* Return total rows
			-----------------------------------------------------------------*/
			function totalRows($result) {
				return mysql_num_rows($result);
			}
			/* Convert resultset to array with key and value array
			-----------------------------------------------------------------*/
			function RSTToArray($rst,$col_key,$arrayCol=null){
				try {
						$array=array();
                           $array_tmp=array();
						while($row=$this->nextAssoc($rst)){
							foreach($arrayCol as $key)
                               {
                                   $array_tmp[$key]=$row[$key];
                                   $array_tmp[0]=$array_tmp[$key];
                               }
							$array [$row[$col_key]]=$array_tmp;
						}
                           unset($array_tmp);
                           unset($row);
						return $array;
				}catch (Exception $ex) {

						return null;
				}
			}
			/* Return total fields
			-----------------------------------------------------------------*/
			function totalFields($result) {
				try {
						return mysql_num_fields($result);
				}catch (Exception $ex) {

						return 0;
				}
			}
			/* Next Record using Assoc
			-----------------------------------------------------------------*/
			function nextAssoc($result) {
				return mysql_fetch_assoc($result);
			}
			/* Next record using array
			-----------------------------------------------------------------*/
			function nextData($result) {
				return @mysql_fetch_array($result);
			}
			/* Next record using index
			-----------------------------------------------------------------*/
			function nextRow($result) {
				return mysql_fetch_row($result);
			}
			/* Next record using Object
			-----------------------------------------------------------------*/
			function nextObject($result) {
				return @mysql_fetch_object($result);
			}
			/* Next field
			-----------------------------------------------------------------*/
			function nextField($result,$offset=0) {
				return mysql_fetch_field($result,$offset);
			}
			/* Execute sqlcommand with select query
			-----------------------------------------------------------------*/
			function doSQL($sql) {

				try {
                       	if($_GET['debug']) 
							echo "<div style='text-align:left;color:blue'><PRE>".$sql."</PRE></div>";
						$this->dbConnect();
						if(DEBUG_MODE)
                        	$rst=mysql_query($sql);
						else  $rst=mysql_query($sql) or die("Query has error");
						return $rst;
				}catch (Exception $ex) {

						return null;
				}
			}
			/* Execute sqlcommand with insert, update, delete query
			-----------------------------------------------------------------*/
			function doNoSQL($sql) {
				try {
                       	if($_GET['debug']) 
							echo "<div style='text-align:left;color:blue'><PRE>".$sql."</PRE></div>";				
						$this->dbConnect();
						if(DEBUG_MODE)$affect=mysql_query($sql) or die(mysql_error().": ".$sql);
						else $affect=mysql_query($sql) or die("Query has error");
						return $affect;
				}catch (Exception $ex) {

						return 0;
				}
			}
			/* Reset structure and data table
			-----------------------------------------------------------------*/
			function truncateTable($table) {
				try {
						if(!empty($table)) {
								$this->dbConnect();
								$sql="TRUNCATE TABLE ".$table;
								$affect=$this->doNoSQL($sql);

                                   unset($sql);
								return $affect;
						}
				}catch (Exception $ex) {

						return 0;
				}
			}
			/* Return array from resultset
			-----------------------------------------------------------------*/
			function getArray($tbName,$condition,$orderby,$mode="",&$array_col=null) {
				try {
							$str='';
							$array_row=array();
							$this->dbConnect();
							$rst=$this->getDynamic($tbName,$condition,$orderby);
							if(is_array($array_col))$array_col = $this->getColumns($rst);
							switch($mode)
							{
							 case "stdObject":
							   while(@$row=@$this->nextObject($rst))$array_row[]=$row;
							   break;
                             case "Assoc":
							   while($row=$this->nextAssoc($rst))$array_row[]=$row;
							   break;
                             case "Row":
                                while($row=$this->nextRow($rst))$array_row[]=$row;
							    break;
							 default:
							   while($row=$this->nextData($rst))$array_row[]=$row;
							   break;
							}

                           unset($rst);unset($str);unset($row);
						return $array_row;
				}catch (Exception $ex) {

				}
			}
			/* Return all column informaiton
			-----------------------------------------------------------------*/
			function getColumns($rst=null) {
				try {
					while($field=$this->nextField($rst)) $array[]=$field->name;
     					unset($numfield);unset($field);
					return $array;
				}catch (Exception $ex) {
				}
			}
			/* Generate select tag and no recursive
			*******************************************************************/
			function generateSelect($tablename,$where,$orderby,$idName,$datatextfield,$datavaluefield,$matchSelected,$arrayOption=null) {
				try {
						$str="<select onchange=\"".$arrayOption["onchange"]."\" name='".$idName."' id='".$idName."' class=\"".$arrayOption["class"]."\">";
						if($arrayOption["firstText"]!='')
								$str.="<option value='0' > ".$arrayOption["firstText"]." </option>";
						$obj=$this->getArray($tablename,$where,$orderby);
						$array=$obj["arrayRow"];
						if(is_array($array))
								foreach($array as $rs)
										$str.="<option value='".$rs[$datavaluefield]."' ".(($rs[$datavaluefield]==$matchSelected)?"  selected='selected'":" ").'>&nbsp;'.$arrayOption["char"].'&nbsp;&nbsp;'.$rs[$datatextfield]."</option>";
						$str.="</select>";
                           unset($array);
                           unset($obj);
						return $str;
				}catch (Exception $ex) {
						return '';
				}
			}
			/* Generate select tag recursive
			******************************************************************/
			function generateSelectArray($array=null,$col=null,$parentid=0,$idName,$datatextfield,$datavaluefield,$matchSelected,$arrayOption=null)
			{
				try {
						$col[$datatextfield]=$datatextfield;
						$col[$datavaluefield]=$datavaluefield;
						$list=$this->recursiveArray($array,$parentid,$col);
						$str="<select onchange=\"".$arrayOption["onchange"]."\" name='".$idName."' id='".$idName."' style='".$arrayOption["style"]."'>";
						if($arrayOption["firstText"]!='')
								$str.="<option value='0' > ".$arrayOption["firstText"]." </option>";
						if(is_array($list))
								foreach($list as $key => $value) {
										$key_value=preg_replace("/[^0-9]/",'',$value[$datavaluefield]);
										$str.="<option ".(($matchSelected==$key_value)?"selected='selected'":'')." value=\"".$key_value."\">".$value[$datatextfield]."</option>";
						}
						$str.="</select>";
                           unset($list);
                           unset($key_value);
						return $str;
				}catch (Exception $ex) {
						return '';
				}
			}
			/* Generate Select tag
			******************************************************************/
			function arrayToSelect($array,$match='',$idName,$Options=null) {
				try {
						$str='<select name="'.$idName.'" id="'.$idName.'" size="'.$Options["size"].'"  class="'.$Options["class"].'" style="'.$Options["style"].'"  onchange="'.$Options["onchange"].'">';
						if(!empty($Options["firstText"])) $str.='<option value="">'.$Options["firstText"].'</option>';
						if(count($array)>0)foreach($array as $key => $value) $str.='<option value="'.$key.'"'.(($match==$key)?" selected ":"").'>'.$value.'</option>';
						$str.='</select>';
                           unset($key);unset($value);
						return $str;
				}catch (Exception $ex) {
						return '';
				}
			}
			/*Recursive array
			******************************************************************/
			function recursiveArray($array=null,$parentid,$col=null,$space='',$trees=null) {
				if(is_array($array))
						foreach($array as $row) {
								if($row['parentid']==$parentid) {
										$tmp=array();
										if(is_array($col))
												foreach($col as $key => $value) {
														$tmp[$value]=$space.stripslashes($row[$value]);
										}
										$trees[]=$tmp;
										$trees=$this->recursiveArray($array,$row[0],$col,$space.'&nbsp;&nbsp;=>&nbsp;',$trees);
								}
				}
				return $trees;
			}
			/* Get metadata information
			-----------------------------------------------------------------*/
			function getMetaData($tableName,$type='') {
				try {
						$result=$this->doSQL("show full fields from ".$tableName);
						$flag=false;
						$i=1;
						while($field=$this->nextObject($result,0))
						{
							$ListHide = "";
							$ArrComment = $field->Comment;
							$ArrComment = explode('|',$ArrComment);
							$fname=$field->Field;
							$ListHide = $ArrComment[1];
							$fFullType=$field->Type;
							$fFullType=str_replace("unsigned",'',$fFullType);
							$fFullType=str_replace("zerofill",'',$fFullType);
							$fType=preg_replace("/[^a-z]/i",'',$fFullType);
							$fType=strtolower($fType);
							if(strstr($fType,"int")!='') $fType="int";
							elseif($fType=="double"||$fType=="float"||$fType=="decimal")$fType="real";
							elseif($fType=="varchar")$fType="string";
							elseif($fType=="text")$fType="blob";
							$fLength=preg_replace("/[^0-9]/",'',$fFullType);
							if(strtolower($fname)!="id") {
									$array1[]=$fname;
									$array2[$fname]=$fType;
									$array3[$fname]=$fLength;
									if($ListHide)
										$array5[$fname]=1;									
							}
						
							$arrayComment[$fname]=$ArrComment[0];
							if(($field->Key)=="PRI"&&!$flag) {
									$array4["pk"]=$fname;
									$flag=true;
							}
							++$i;
						}
						$array4["table"]=$tableName;
						$array[]=$array1;					//column name
						$array[]=$array2; 					//data type
						$array[]=$array3;        			//length field
						$array[]=$array4;  				//extension(primary key, tablename)
						$array[]=$array5;  				//extension(primary key, tablename)						
						$array["Comment"]=$arrayComment;	//get comment of field
                           unset($array1);unset($array2);unset($array3);unset($array4);
                           unset($flag);
                           unset($result);
                           unset($field);
                           unset($fname);
                           unset($fType);
                           unset($fFullType);
						return $array;
				}catch (Exception $ex) {
				}
			}

			function getMetaData_vlink($tableName) {
				$result=$this->doSQL("show full fields from ".$tableName);
				$flag=false;
				$i=1;
				$list_orderby = array();
				while($field1=$this->nextObject($result,0))
				{
					$field = array();
					$field['Field'] = $field1->Field;
					$field['Type'] = $field1->Type;
					$field['Comment'] = $field1->Comment;
					$field['Default'] = $field1->Default;
					$field['Key'] = $field1->Key;																
					$field['Type']=str_replace("unsigned",'',$field['Type']);
					$field['Type']=str_replace("zerofill",'',$field['Type']);
					$field['Length']=preg_replace("/[^0-9]/",'',$field['Type']);							
					$field['Type']=strtolower(preg_replace("/[^a-z]/i",'',$field['Type']));							
												
					if(strstr($field['Type'],"int")!='') $field['Type']="int";
					elseif($field['Type']=="double"||$field['Type']=="float"||$field['Type']=="decimal")$field['Type']="real";
					elseif($field['Type']=="varchar")$field['Type']="string";
					elseif($field['Type']=="text")$field['Type']="blob";
					if($field1->Key=="PRI"&&!$flag) {
						$Meta["pk"]=$field['Field'];
						$flag=true;
					}
					++$i;							
					$fName = $field['Field'];
					
					$result_field=$this->doSQL("select * from sys_field where field_name= '".$fName."' AND table_id=(SELECT id from sys_table WHERE table_name ='".$tableName."')");
														
					$result_field=mysql_fetch_array($result_field);
					$field = array_merge($field,$result_field);
					//print_r($field);
					if(!$field['Label']){
						$field['Label'] = $fName;
					}
					
					if($field['list_default_orderby']){
						$list_orderby[] = $tableName.'.'.$fName.' '.$field['list_default_orderby'];
					}
										
					$Meta["Field"][$fName] = $field;
					$Meta["Col"][] = $fName;
				}
				$Meta["table_name"]=$tableName;
				if(!$list_orderby){
					$list_orderby[] = $tableName.'.'.$Meta["pk"].' ASC';
				}				
				$Meta["list_orderby"] = implode(',',$list_orderby);
				$Meta["list_page_size"] = $this->getValueOfQuery("SELECT list_page_size FROM sys_table WHERE table_name='$tableName'");
                $Meta["list_footer"] = $this->getValueOfQuery("SELECT list_footer FROM sys_table WHERE table_name='$tableName'");

                $arrayInfo=$this->getArray("sys_table","table_name='".$tableName."'","",null);
               $Meta['tableInfo'] =$arrayInfo[0];

				return $Meta;
			}	
	function update_sys_table(){
		$rst=$this->doSQL("SHOW FULL tables");
		while($row=$this->nextObject($rst,0))
		{	
			$database_name_field = "Tables_in_".DBNAME; 
			$table = $row->$database_name_field;
			$result = $this->getValueOfQuery("SELECT table_name FROM sys_table WHERE table_name='".$table."'");;
			if(!$result){
				$this->insertTable('sys_table',array('table_name'=>$table));			
			}
			if($table)
				$arrayTable[] = "'".$table."'";	
		}
		if($arrayTable)		
			$this->doSQL("DELETE FROM sys_table WHERE (custom_link IS NULL || custom_link='') AND (table_name not in (".implode(',',$arrayTable)."))");
	}
	
	
	function update_sys_field($table_id){
		$this->update_sys_table();
		$table_name = $this->getValueOfQuery("SELECT table_name FROM sys_table WHERE id=".$table_id);

		$rst=$this->doSQL("SHOW FULL fields FROM ".$table_name);
		while($row=$this->nextObject($rst,0))
		{	
			$field = $row->Field;
			$result = $this->getValueOfQuery("SELECT field_name FROM sys_field WHERE  (field_name='".$field."') AND (table_id=".$table_id.")");;
			if(!$result){
				$this->insertTable('sys_field',array('table_id'=>$table_id,'field_name'=>$field));			
			}
			if($field)
				$arrayField[] = "'".$field."'";	
		}
		//if($arrayField)
			//$this->doSQL("DELETE FROM sys_field WHERE (table_id=".$table_id.") AND (field_name not in (".implode(',',$arrayField)."))");
	}

    function getid_articaltype($table,$id){
       $result=$this->getDynamic($table,"id=".$id,"");
       if($this->totalRows($result))
       {
         $row=$this->nextData($result);
         return $row["type_id"];
       }
    }

	function getPermission($roleid){
		 $rs=$this->getArray('webmaster_permission','webmaster_role_id='.$roleid.'','','');
		 if($rs){
			foreach($rs as $key => $value){
				$permission[$value['table_id']] = $value;
			}
		 }
		 return $permission;
	}	

	function loadSetting(){
          $result = $this->getDynamic(prefixTable."setting", "", "");
          $info = array();
          while ($rowinfo = $this->nextData($result)) {
            $index = $rowinfo["key_name"];
            $info[$index] = stripslashes($rowinfo["value"]);
          }
      	  return $info;
	}

        

function processLogin($username,$password){
    $msg="fail";
	$username=$this->escapeStr($username);
	$password=$this->escapeStr($password);
	$password=md5($password);	
	$result=$this->getDynamic("webmaster","username='$username' and password='$password' and status=1","");
	if($this->totalRows($result)>0) {
			$row=$this->nextData($result);
			$_SESSION["user_login"]["username"]=stripslashes($username);
			$_SESSION["user_login"]["role_id"]=$row["roleid"];
			$_SESSION["user_login"]["role_name"]=$this->getValueOfQuery('SELECT title FROM webmaster_roles WHERE id='.$row["roleid"]);
            $_SESSION["user_login"]["is_show_menu_left"]=$this->getValueOfQuery('SELECT is_show_menu_left FROM webmaster_roles WHERE id='.$row["roleid"]);
			$_SESSION["user_login"]["fullname"]=$row["fullname"];
            $_SESSION["user_login"]["is_change_webmaster_permission"]=$row["is_change_webmaster_permission"];
            $_SESSION["user_login"]["is_view_tabledesign"]=$row["is_view_tabledesign"];
			$_SESSION["permission"] = $this->getPermission($row["roleid"]);

            $_SESSION['check_session_id'] = md5($_SESSION["user_login"]["username"].session_id());

	        $msg="success";

	}else{
		unset($_SESSION["user_login"]);
	}
	return $msg;
}
}	
?>