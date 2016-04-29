<?php
	include_once "Scenario.php";
	include_once "Agent.php";
	include_once "Event.php";

	session_start();

	if(isset($_SESSION['agent']) && isset($_SESSION['event'])){
		$objScenario = new Scenario($_SESSION['agent'], $_SESSION['event']);
		$objScenario->setTimer(20);
		$_SESSION['objScenario'] = $objScenario;
		unset($_SESSION['agent']);
		unset($_SESSION['event']);
	}
	
	if(isset($_SESSION['objScenario'])){
		if($_SESSION['objScenario']->heartrate()){
			echo mt_rand(10, 20);
		}
		else{
			echo mt_rand(0, 5);
		}
		$_SESSION['objScenario']->decrementTimer();
		if($_SESSION['objScenario']->getTimer() == 0){
			unset($_SESSION['objScenario']);
		}
	}
	else{
		echo 0;
	}
	
?>