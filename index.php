<?php

include_once "Agent.php";
include_once "Event.php";
include_once "Trigger.php";
include_once "Scenario.php";

session_start();

?>

<html>
<head>
	<title>PTSD Simulation</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" href="main.css" />
	<link rel="stylesheet" type="text/css" href="//jsxgraph.uni-bayreuth.de/distrib/jsxgraph.css" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
	<script type="text/javascript" src="//jsxgraph.uni-bayreuth.de/distrib/jsxgraphcore.js"></script>
	<script type="text/javascript" src="//jsxgraph.uni-bayreuth.de/distrib/prototype.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
</head>
<body>
	<div class='load'>
		<h3>PTSD Simulation</h3>
		<fieldset class='fieldset'>
			<legend>Load Scenario</legend>
			<form method='post' action=''>
				Agent:
				<select name='agent'>
				<?php
					$arrAgents = Agent::loadAgents();
					foreach($arrAgents as $key => $value){
						echo "<option value='" . $key . "' " . (($_POST['agent'] == $key) ? 'selected' : '') . ">" . $value . "</option>";
					}
				?>
				</select>
				<br/>
				Event:
				<select name='event'>
				<?php
					$arrEvents = Event::loadEvents();
					foreach($arrEvents as $key => $value){
						echo "<option value='" . $key . "' " . (($_POST['event'] == $key) ? 'selected' : '') . ">" . $value . "</option>";
					}
				?>
				</select>
				<br/>
				<input type='submit' value='Load'/>
			</form>
		</fieldset>
	</div>
	<div class='scenario'>
		<fieldset class='fieldsetsmall'>
			<legend>Agent Info</legend>
			<?php
				echo "<ul>";
				if(isset($_POST['agent'])){
					$objAgent = new Agent($_POST['agent']);
					echo "<li>Last Name: " . $objAgent->getLastname() . "</li>";
					echo "<li>First Name: " . $objAgent->getFirstname() . "</li>";
					echo "<li>Age: " . $objAgent->getAge() . "</li>";
					echo "<li>Country: " . $objAgent->getCountry() . "</li>";
					echo "<li>Race: " . $objAgent->getRace() . "</li>";
					echo "<li>Gender: " . $objAgent->getGender() . "</li>";
				}
				echo "</ul>";
			?>
		</fieldset>
		<fieldset class='fieldsetsmall'>
			<legend>Event Info</legend>
			<?php
				echo "<ul>";
				if(isset($_POST['event'])){
					$objEvent = new Event($_POST['event']);
					echo "<li>Name: " . $objEvent->getName() . "</li>";
				}
				echo "</ul>";
			?>
		</fieldset>
	</div>
	<?php if(isset($objAgent) && isset($objEvent)){ 
				$_SESSION['agent'] = $objAgent;
				$_SESSION['event'] = $objEvent;
	?>
	<div class='scenario'>
		<fieldset class='fieldsetsmall'>
			<legend>Scenario Info</legend>
			<?php
				echo "<ul>";
				$objScenario = new Scenario($objAgent, $objEvent);
				echo "<li>Heartrate Increase: " . ($objScenario->heartrate() ? 'Yes' : 'No') . "</li>";
				echo "</ul>";
			?>
		</fieldset>
	</div>
	<?php } ?>
	<div id="jxgbox" class="jxgbox" style="width:500px; height:500px;"></div>
	<script>
		var brd, g, 
		xdata = [], ydata = [],
		turt,i;
		 
		brd = JXG.JSXGraph.initBoard('jxgbox', {axis:true, boundingbox:[0,20,30,-2]});
		 
		// Draw the additional lines
		turt = brd.create('turtle',[],{strokecolor:'#999999'});
		turt.hideTurtle().right(90);
		for (i=5;i<=15;i+=5) {
			turt.penUp().moveTo([0,i]).penDown().forward(30);
		}
		 
		 
		fetchData = function() {
			new Ajax.Request('load_timeline.php', {
				onComplete: function(transport) {
					var t, a;
					if (200 == transport.status) {
						t = transport.responseText;
						a = parseFloat(t);
						if (xdata.length<30) {          
							xdata.push(xdata.length); // add data to the x-coordinates, if the right border has not been reached, yet
						} else {
							ydata.splice(0,1);        // remove the oldest entry of the y-coordinates, to make the graph move.
						}
						ydata.push(a);
						if (!g) {                   // If the curve does not exist yet, create it.
							g = brd.create('curve', [xdata,ydata],{strokeWidth:3, strokeColor:'yellow'}); 
						} 
						brd.update();
					};
			}});
		};
		setInterval(fetchData,1000);  // Start the periodical update
	</script>
</body>
</html>