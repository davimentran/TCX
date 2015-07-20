<?php
	include str_replace('\\','/',dirname(__FILE__)).'/config.DATABASE.php';
	class DBFUNCTION {
			private $connect=null;
			function __construct()
			{
               $this->connect=mysql_connect(HOSTADDRESS,DBACCOUNT,DBPASSWORD);
               mysql_select_db(DBNAME,$this->connect);
               mysql_query("SET NAMES utf8");
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
							$this->connect=mysql_connect(HOSTADDRESS,DBACCOUNT,DBPASSWORD);
							return mysql_select_db(DBNAME,$this->connect);
                            mysql_query("SET NAMES utf8");
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
            function getValueOfQuery($sql){
				$rst =  $this->doSQL($sql);
				$row = @mysql_fetch_array($rst);
				return $row[0];
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
			/* Get data dynamic
			-----------------------------------------------------------------*/
			function getDynamic($tbName,$condition,$orderby) {
				try {
						$this->dbConnect();
						$orderby=(!empty($orderby))?' ORDER BY '.$orderby:'';
						$condition=(!empty($condition))?' WHERE '.$condition:'';
						$sql='SELECT * FROM '.$tbName.'  '.$condition.'  '.$orderby;
                        //echo $sql;

                           $rst=$this->doSQL($sql);

						return $rst;
				}catch (Exception $ex)
				{

						return null;
				}
			}
			/* Insert into table
			-----------------------------------------------------------------*/
			function insertTable($tbName,$arrayValue) {
				try {
						$array=array(2);
						$this->dbConnect();
                           if(count($arrayValue)>0)
                           {
                               foreach($arrayValue as &$value)$value=$this->removeSQLInjection($value);
   							$sql="INSERT INTO ".$tbName."(".implode(",",array_keys($arrayValue)).") VALUES('".implode("','",array_values($arrayValue))."')";
                               $affect=$this->doNoSQL($sql);
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

                        //echo $sql."\n";

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

                        //echo"delect". $sql."\n";
                           $affect=$this->doNoSQL($sql);

                           unset($condition);
                           unset($sql);
						return $affect;
				}catch (Exception $ex) {

						return 0;
				}
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
				return mysql_fetch_array($result);
			}
			/* Next record using index
			-----------------------------------------------------------------*/
			function nextRow($result) {
				return mysql_fetch_row($result);
			}
			/* Next record using Object
			-----------------------------------------------------------------*/
			function nextObject($result) {
				return mysql_fetch_object($result);
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
						$this->dbConnect();
						if(DEBUG_MODE)
						$rst=mysql_query($sql) or die(mysql_error().": ".$sql);
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
							   while($row=$this->nextObject($rst))$array_row[]=$row;
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

            function arrayToSelect_C($array,$match='',$idName,$Options=null) {
				try {
						$str='<select name="'.$idName.'" id="'.$idName.'" size="'.$Options["size"].'"  class="'.$Options["class"].'" style="'.$Options["style"].'"  onchange="'.$Options["onchange"].'">';
						if(!empty($Options["firstText"])) $str.='<option value="">'.$Options["firstText"].'</option>';
						if(count($array)>0)foreach($array as $key => $value) $str.='<option value="'.$value.'"'.(($match==$value)?" selected ":"").'>'.$value.'</option>';
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

							$fname=$field->Field;
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
							}
							$arrayComment[$fname]=$field->Comment;
							if(($field->Key)=="PRI"&&!$flag) {
									$array4["pk"]=$fname;
									$flag=true;
							}
							++$i;
						}
						$array4["table"]=$tableName;
						$array []=$array1;					//column name
						$array []=$array2; 					//data type
						$array []=$array3;        			//length field
						$array []=$array4;  				//extension(primary key, tablename)
						$array["Comment"]=$arrayComment; 	//get comment of field
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
	}
?>