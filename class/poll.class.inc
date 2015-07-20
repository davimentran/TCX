<?php
include_once ("../Class/class.DBFUNCTION.php");
/**
* Class for the poll
**/
class poll extends DBFUNCTION
{
	var $ID;
	var $pollerTitle_vn;
	var $pollerTitle_en;
	
	function poll()
	{
		$this->ID = "";
		$this->pollerTitle_vn = "";
		$this->pollerTitle_en = "";
	}
	function setId($id)
	{
		$this->ID = $id;
	}
    function getId()
	{
		return $this->ID;
	}
	function getDataById($id)
	{
		$res = $this->getDynamic(prefixTable."poller","ID='$id'","");
		if($inf = $this->nextData($res)){
			$this->ID = $inf["ID"];
			$this->pollerTitle_vn = $inf["pollerTitle_vn"];
			$this->pollerTitle_en = $inf["pollerTitle_en"];
		}
	}
	/* This method returns poller options as an associative array */
	function getOptionsAsArray()
	{
		$retArray = array();
        $res=$this->getDynamic(prefixTable."poller_option","pollerID='".$this->ID."'","pollerOrder");
		while($inf = $this->nextData($res)){
			$retArray[$inf["ID"]] = array($inf["optionText_vn"],$inf["optionText_en"],$inf["pollerOrder"]);
		}	
		return $retArray;
	}
	/* This method returns number of votes as an associative array */
	function getVotesAsArray()
	{
		$retArray = array();
		$res = $this->doSQL("select v.optionID,count(v.ID) as countVotes from ".prefixTable."poller_vote v,".prefixTable."poller_option o where v.optionID = o.ID and o.pollerID = '".$this->ID."' group by v.optionID");
		while($inf = $this->nextData($res)){
			$retArray[$inf["optionID"]] = $inf["countVotes"];
		}		
		return $retArray;
	}
	/* Create new poller and return ID of new poller */
	function createNewPoller($pollerTitle_vn,$pollerTitle_en)
	{
		global $db;
        $arrayCol=array("pollerTitle_vn"=>$pollerTitle_vn,"pollerTitle_en"=>$pollerTitle_en);
        $res=$this->insertTable(prefixTable."poller",$arrayCol);
		$this->ID = $res[1];
		return $this->ID;
	}
	/* Add poller options */
	function addPollerOption($optionText_vn,$optionText_en,$pollerOrder)
	{
        $arrayCol=array("pollerID"=>$this->ID,"optionText_vn"=>$optionText_vn,"optionText_en"=>$optionText_en,"pollerOrder"=>$pollerOrder);
        $res=$this->insertTable(prefixTable."poller_option",$arrayCol);
		return $res[1];
	}
	/* Delete a poll, options in the poll and votes */
	function deletePoll($pollId)
	{
        $this->deleteDynamic(prefixTable."poller","ID='".$pollId."'");
        $res=$this->getDynamic(prefixTable."poller_option","pollerID='".$pollId."'","");
		while($inf = $this->nextData($res)){
            $this->deleteDynamic(prefixTable."poller_vote","optionID='".$inf["ID"]."'");
            $this->deleteDynamic(prefixTable."poller_option","ID='".$inf["ID"]."'");
		}
	}
    function deletePollOption($pollerid,$poller_optionid)
    {
        $this->deleteDynamic(prefixTable."poller_option","pollerID=$pollerid and ID='".$poller_optionid."'");
    }
	/* Updating poll title */
	function setPollerTitle($pollerTitle_vn,$pollerTitle_en)
	{
        $arrayCol=array("pollerTitle_vn"=>$pollerTitle_vn,"pollerTitle_en"=>$pollerTitle_en);
        $res=$this->updateTable(prefixTable."poller",$arrayCol,"ID='".$this->ID."'");
	}
	/* Update option label */
	function setOptionData($newText_vn,$newText_en,$order,$optionId)
	{
        $arrayCol=array("optionText_vn"=>$newText_vn,"optionText_en"=>$newText_en,"pollerOrder"=>$order);
        $res=$this->updateTable(prefixTable."poller_option",$arrayCol,"id='".$optionId."'");
	}
	/* Get position of the last option, i.e. to append a new option at the bottom of the list */
	function getMaxOptionOrder()
	{
		$res = $this->doSQL("select max(pollerOrder) as maxOrder from ".prefixTable."poller_option where pollerID='".$this->ID."'") or die(mysql_error());
		if($inf = $this->nextData($res)){
			return $inf["maxOrder"];
		}
		return 0;		
	}
	/* Return order of poller options as array */
}
?>