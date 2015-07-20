<?php
class BACKUP extends DBFUNCTION {
        var $zipFile=null;
        function __construct()
        {
          $zipFile=null;
        }
		function backup_tables($tables='*',$zip=0)
        {
		        $zipFile=SINGLETON_MODEL::getInstance("zipfile");
				$tmp=$tables;
                $return="";

				if($tables=='*')
                {
						$tables=array();
						$result=$this->doSQL('SHOW TABLES');
						while($row=$this->nextData($result)) $tables[]=$row[0];
				}
				else
                {
						$tables=is_array($tables)?$tables:explode(',',$tables);
						array_pop($tables);
				}
				foreach($tables as $table) {
						$result=$this->doSQL('SELECT * FROM '.$table);
						$num_fields=$this->totalFields($result);
						$return.="\n";
						$return.='DROP TABLE IF EXISTS '.$table.';';
						$row2=$this->nextData($this->doSQL('SHOW CREATE TABLE '.$table));
						$return.="\n\n".$row2[1].";\n\n";
						for($i=0; $i<$num_fields; $i++) {
								while($row=$this->nextData($result)) {
										$return.='INSERT INTO '.$table.' VALUES(';
										for($j=0; $j<$num_fields; $j++) {
												$row[$j]=addslashes($row[$j]);
												$row[$j]=ereg_replace("\n","\\n",$row[$j]);
												if(isset ($row[$j])) {
														$return.='"'.$row[$j].'"';
												}
												else{
														$return.='""';
												}
												if($j<($num_fields-1)) {
														$return.=',';
												}
										}
										$return.=");\n";
								}
						}
						$return.="\n\n\n";
				}
                $ext=".rar";
                $file="server_".DBNAME.date("_dmY_His").".sql";
                if($zip==1)
                {

                    $zipFile->add_file($return,$file);
                    header("Content-type: application/octet-stream");
                    header("Content-disposition: attachment; filename=$file$ext");
                    header('Content-Encoding: gzip') ;
                    echo $zipFile->file();
                    return true;

                }else
                {
                    Header("Content-type: application/octet-stream");
    				Header("Content-Disposition: attachment; filename=$file");
    				echo $return;
                    return true;
                }
		}
}
?>