<?php 

	include_once "Database.class";
	include_once "Agent.php";
	include_once "Event.php";
	include_once "Trigger.php";
	include_once "Lottery.php";
	
	class Scenario{
		
		private $_objAgent;
		private $_objEvent;
		private $_intTimer;
	
		public function Scenario($objAgent, $objEvent){
			$this->_objAgent = $objAgent;
			$this->_objEvent = $objEvent;
		}
		
		public function setTriggers(){
			$objDB = new Database();
			$strSQL = "SELECT agentid, triggerid FROM agenttriggers
						WHERE agentid = " . $objDB->quote($this->_objAgent->getId());
			$rsResult = $objDB->query($strSQL);
			while ($arrRow = $rsResult->fetch(PDO::FETCH_ASSOC)){
				$this->_objAgent->addTrigger(new Trigger($arrRow['triggerid']));
			}
			
			$strSQL = "SELECT eventid, triggerid FROM eventtriggers
						WHERE eventid = " . $objDB->quote($this->_objEvent->getId());
			$rsResult = $objDB->query($strSQL);
			while ($arrRow = $rsResult->fetch(PDO::FETCH_ASSOC)){
				$this->_objEvent->addTrigger(new Trigger($arrRow['triggerid']));
			}
		}
		
		public function heartrate(){
			$this->setTriggers();
			foreach($this->_objEvent->getTriggers() as $trigger){
				if($this->_objAgent->indexOfTrigger($trigger) != -1){
					return true;
				}
			}
		}
		
		public function setTimer($intTimer){
			$this->_intTimer = $intTimer;
		}
		
		public function getTimer(){
			return $this->_intTimer;
		}
		
		public function decrementTimer(){
			$this->_intTimer--;
		}
	
	}

?>