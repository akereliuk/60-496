<?php
/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.23.0-66ee5e1 modeling language!*/

include_once "Database.class";

class Trigger
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //Trigger Attributes
  private $id;
  private $name;

  //Trigger Associations
  private $agent;
  private $event;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public function Trigger($id = null){
	  if($id){
		  $this->loadTriggerInfo($id);
	  }
  }
  
  private function populateVarFromRow($arrTriggerInfo){
	  $this->setId($arrTriggerInfo['id']);
	  $this->setName($arrTriggerInfo['name']);
  }
  
  private function loadTriggerInfo($id){
	  $objDB = new Database();
	  $arrTriggerInfo = array();
	  $strSQL = "SELECT * FROM `trigger`
					WHERE id = " . $objDB->quote($id);
	  $rsResult = $objDB->query($strSQL);
	  while($arrRow = $rsResult->fetch(PDO::FETCH_ASSOC)){
		  $arrTriggerInfo['id'] = $arrRow['id'];
		  $arrTriggerInfo['name'] = $arrRow['name'];
	  }
	  $this->populateVarFromRow($arrTriggerInfo);
  }

  //------------------------
  // INTERFACE
  //------------------------

  public function setId($aId)
  {
    $wasSet = false;
    $this->id = $aId;
    $wasSet = true;
    return $wasSet;
  }

  public function setName($aName)
  {
    $wasSet = false;
    $this->name = $aName;
    $wasSet = true;
    return $wasSet;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getAgent()
  {
    return $this->agent;
  }

  public function getEvent()
  {
    return $this->event;
  }

  public function setAgent($aAgent)
  {
    $wasSet = false;
    if ($aAgent == null)
    {
      return $wasSet;
    }
    
    $existingAgent = $this->agent;
    $this->agent = $aAgent;
    if ($existingAgent != null && $existingAgent != $aAgent)
    {
      $existingAgent->removeTrigger($this);
    }
    $this->agent->addTrigger($this);
    $wasSet = true;
    return $wasSet;
  }

  public function setEvent($aEvent)
  {
    $wasSet = false;
    if ($aEvent == null)
    {
      return $wasSet;
    }
    
    $existingEvent = $this->event;
    $this->event = $aEvent;
    if ($existingEvent != null && $existingEvent != $aEvent)
    {
      $existingEvent->removeTrigger($this);
    }
    $this->event->addTrigger($this);
    $wasSet = true;
    return $wasSet;
  }

  public function equals($compareTo)
  {
    return $this == $compareTo;
  }

  public function delete()
  {
    $placeholderAgent = $this->agent;
    $this->agent = null;
    $placeholderAgent->removeTrigger($this);
    $placeholderEvent = $this->event;
    $this->event = null;
    $placeholderEvent->removeTrigger($this);
  }

}
?>