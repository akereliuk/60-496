<?php
/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.23.0-66ee5e1 modeling language!*/

include_once "Database.class";

class Event
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //Event Attributes
  private $id;
  private $name;

  //Event Associations
  private $triggers;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public function Event($id = null){
	  if($id){
		  $this->loadEventInfo($id);
	  }
  }
  
  private function populateVarFromRow($arrEventInfo){
	  $this->setId($arrEventInfo['id']);
	  $this->setName($arrEventInfo['name']);
  }
  
  private function loadEventInfo($id){
	  $objDB = new Database();
	  $arrEventInfo = array();
	  $strSQL = "SELECT * FROM event
					WHERE id = " . $objDB->quote($id);
	  $rsResult = $objDB->query($strSQL);
	  while($arrRow = $rsResult->fetch(PDO::FETCH_ASSOC)){
		  $arrEventInfo['id'] = $arrRow['id'];
		  $arrEventInfo['name'] = $arrRow['name'];
	  }
	  $this->populateVarFromRow($arrEventInfo);
	  $this->triggers = array();
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

  public function getTrigger_index($index)
  {
    $aTrigger = $this->triggers[$index];
    return $aTrigger;
  }

  public function getTriggers()
  {
    $newTriggers = $this->triggers;
    return $newTriggers;
  }

  public function numberOfTriggers()
  {
    $number = count($this->triggers);
    return $number;
  }

  public function hasTriggers()
  {
    $has = $this->numberOfTriggers() > 0;
    return $has;
  }

  public function indexOfTrigger($aTrigger)
  {
    $wasFound = false;
    $index = 0;
    foreach($this->triggers as $trigger)
    {
      if ($trigger->equals($aTrigger))
      {
        $wasFound = true;
        break;
      }
      $index += 1;
    }
    $index = $wasFound ? $index : -1;
    return $index;
  }

  public static function minimumNumberOfTriggers()
  {
    return 0;
  }

  public function addTriggerVia($aId, $aName, $aAgent)
  {
    return new Trigger($aId, $aName, $aAgent, $this);
  }

  public function addTrigger($aTrigger)
  {
    $wasAdded = false;
    if ($this->indexOfTrigger($aTrigger) !== -1) { return false; }
    $existingEvent = $aTrigger->getEvent();
    $isNewEvent = $existingEvent != null && $this !== $existingEvent;
    if ($isNewEvent)
    {
      $aTrigger->setEvent($this);
    }
    else
    {
      $this->triggers[] = $aTrigger;
    }
    $wasAdded = true;
    return $wasAdded;
  }

  public function removeTrigger($aTrigger)
  {
    $wasRemoved = false;
    //Unable to remove aTrigger, as it must always have a event
    if ($this !== $aTrigger->getEvent())
    {
      unset($this->triggers[$this->indexOfTrigger($aTrigger)]);
      $this->triggers = array_values($this->triggers);
      $wasRemoved = true;
    }
    return $wasRemoved;
  }

  public function addTriggerAt($aTrigger, $index)
  {  
    $wasAdded = false;
    if($this->addTrigger($aTrigger))
    {
      if($index < 0 ) { $index = 0; }
      if($index > $this->numberOfTriggers()) { $index = $this->numberOfTriggers() - 1; }
      array_splice($this->triggers, $this->indexOfTrigger($aTrigger), 1);
      array_splice($this->triggers, $index, 0, array($aTrigger));
      $wasAdded = true;
    }
    return $wasAdded;
  }

  public function addOrMoveTriggerAt($aTrigger, $index)
  {
    $wasAdded = false;
    if($this->indexOfTrigger($aTrigger) !== -1)
    {
      if($index < 0 ) { $index = 0; }
      if($index > $this->numberOfTriggers()) { $index = $this->numberOfTriggers() - 1; }
      array_splice($this->triggers, $this->indexOfTrigger($aTrigger), 1);
      array_splice($this->triggers, $index, 0, array($aTrigger));
      $wasAdded = true;
    } 
    else 
    {
      $wasAdded = $this->addTriggerAt($aTrigger, $index);
    }
    return $wasAdded;
  }

  public function equals($compareTo)
  {
    return $this == $compareTo;
  }

  public function delete()
  {
    foreach ($this->triggers as $aTrigger)
    {
      $aTrigger->delete();
    }
  }
  
  public static function loadEvents(){
	  $objDB = new Database();
	  $arrReturn = array();
	  $strSQL = "SELECT id, name FROM event ORDER BY name ASC";
	  $rsResult = $objDB->query($strSQL);
	  while($arrRow = $rsResult->fetch(PDO::FETCH_ASSOC)){
		  $arrReturn[$arrRow['id']] = $arrRow['name']; 
	  }
	  return $arrReturn;
  }

}
?>