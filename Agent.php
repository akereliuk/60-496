<?php
/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.23.0-66ee5e1 modeling language!*/

include_once "Database.class";

class Agent
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //Agent Attributes
  private $id;
  private $lastname;
  private $firstname;
  private $age;
  private $country;
  private $race;
  private $gender;

  //Agent Associations
  private $triggers;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public function Agent($id = null){
	  if($id){
		  $this->loadAgentInfo($id);
	  }
  }
  
  private function populateVarFromRow($arrAgentInfo){
	  $this->setId($arrAgentInfo['id']);
	  $this->setLastname($arrAgentInfo['lastname']);
	  $this->setFirstname($arrAgentInfo['firstname']);
	  $this->setAge($arrAgentInfo['age']);
	  $this->setCountry($arrAgentInfo['country']);
	  $this->setRace($arrAgentInfo['race']);
	  $this->setGender($arrAgentInfo['gender']);
  }
  
  private function loadAgentInfo($id){
	  $objDB = new Database();
	  $arrAgentInfo = array();
	  $strSQL = "SELECT * FROM agent
					WHERE id = " . $objDB->quote($id);
	  $rsResult = $objDB->query($strSQL);
	  while($arrRow = $rsResult->fetch(PDO::FETCH_ASSOC)){
		  $arrAgentInfo['id'] = $arrRow['id'];
		  $arrAgentInfo['lastname'] = $arrRow['lastname'];
		  $arrAgentInfo['firstname'] = $arrRow['firstname'];
		  $arrAgentInfo['age'] = $arrRow['age'];
		  $arrAgentInfo['country'] = $arrRow['country'];
		  $arrAgentInfo['race'] = $arrRow['race'];
		  $arrAgentInfo['gender'] = $arrRow['gender'];
	  }
	  $this->populateVarFromRow($arrAgentInfo);
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

  public function setLastname($aLastname)
  {
    $wasSet = false;
    $this->lastname = $aLastname;
    $wasSet = true;
    return $wasSet;
  }

  public function setFirstname($aFirstname)
  {
    $wasSet = false;
    $this->firstname = $aFirstname;
    $wasSet = true;
    return $wasSet;
  }

  public function setAge($aAge)
  {
    $wasSet = false;
    $this->age = $aAge;
    $wasSet = true;
    return $wasSet;
  }

  public function setCountry($aCountry)
  {
    $wasSet = false;
    $this->country = $aCountry;
    $wasSet = true;
    return $wasSet;
  }

  public function setRace($aRace)
  {
    $wasSet = false;
    $this->race = $aRace;
    $wasSet = true;
    return $wasSet;
  }

  public function setGender($aGender)
  {
    $wasSet = false;
    $this->gender = $aGender;
    $wasSet = true;
    return $wasSet;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getLastname()
  {
    return $this->lastname;
  }

  public function getFirstname()
  {
    return $this->firstname;
  }

  public function getAge()
  {
    return $this->age;
  }

  public function getCountry()
  {
    return $this->country;
  }

  public function getRace()
  {
    return $this->race;
  }

  public function getGender()
  {
    return $this->gender;
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

  public function addTriggerVia($aId, $aName, $aEvent)
  {
    return new Trigger($aId, $aName, $this, $aEvent);
  }

  public function addTrigger($aTrigger)
  {
    $wasAdded = false;
    if ($this->indexOfTrigger($aTrigger) !== -1) { return false; }
    $existingAgent = $aTrigger->getAgent();
    $isNewAgent = $existingAgent != null && $this !== $existingAgent;
    if ($isNewAgent)
    {
      $aTrigger->setAgent($this);
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
    //Unable to remove aTrigger, as it must always have a agent
    if ($this !== $aTrigger->getAgent())
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
  
  public static function loadAgents(){
	  $objDB = new Database();
	  $arrReturn = array();
	  $strSQL = "SELECT id, CONCAT_WS(', ', lastname, firstname) as name FROM agent ORDER BY lastname ASC";
	  $rsResult = $objDB->query($strSQL);
	  while($arrRow = $rsResult->fetch(PDO::FETCH_ASSOC)){
		  $arrReturn[$arrRow['id']] = $arrRow['name']; 
	  }
	  return $arrReturn;
  }

}
?>