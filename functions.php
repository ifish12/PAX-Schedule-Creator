<?PHP
/**
 * iCalOut creates the ical for the given events and outputs it
 * @param events Events to turn into ical
 **/
function iCalOut($events){
	$ical = "";
	$ical .= "BEGIN:VCALENDAR\r\n";
	$ical .= "VERSION:2.0\r\n";
	$ical .= "PRODID:-//Mark and Geoff//PAX ICAL PARSER//EN\r\n";
	foreach($events as $event){
		$ical .= $event->vEvent();
	}
	$ical .= "END:VCALENDAR";

	//set correct content-type-header
	header('Content-type: text/calendar; charset=utf-8');
	header('Content-Disposition: inline; filename=calendar.ics');
	return $ical;
}


/**
 * form creates a form to choose from the given events
 * @param events
 * @return string to display
 **/
function form($events){
	$out = headerHTML();
	$out .= <<<STUFF
	<script src="js/filter.js" type="text/javascript"></script><!--Maybe move this to headerHTML someday-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
				<div class="panel-group" id="days">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#days" href="#Friday">
									Friday
								</a>
							</h4>
						</div>
						<div id="Friday" class="panel-collapse collapse in">
							<div class="panel-body">
								<label><input id="bullshit" class="filterCheckbox" type="checkbox" name="1000" value="1000">10:00-11:00</label><br>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#days" href="#Saturday">
									Saturday
								</a>
							</h4>
						</div>
						<div id="Saturday" class="panel-collapse collapse">
							<div class="panel-body">
								Checkoxes Saturday
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#days" href="#Sunday">
									Sunday
								</a>
							</h4>
						</div>
						<div id="Sunday" class="panel-collapse collapse">
							<div class="panel-body">
								Checkoxes Sunday
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#days" href="#Monday">
									Monday
								</a>
							</h4>
						</div>
						<div id="Monday" class="panel-collapse collapse">
							<div class="panel-body">
								Checkoxes Monday
							</div>
						</div>
					</div>
				</div><!--end days-->


				<div class="panel panel-default"><!--Location-->
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#Location">
								Location
							</a>
						</h4>
					</div>
					<div id="Location" class="panel-collapse collapse">
						<div class="panel-body">
							Checkoxes Location
						</div>
					</div>
				</div><!--End Location-->


				<div class="panel panel-default"><!--Track-->
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#Track">
								Track
							</a>
						</h4>
					</div>
					<div id="Track" class="panel-collapse collapse">
						<div class="panel-body">
							Checkoxes Track
						</div>
					</div>
				</div><!--End Track-->

			</div><!--End sidebar-->
			<form id="form" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" action="?action=formSubmit" method="POST">
STUFF;
			foreach($events as $event){
				$out .= $event->formOut();
			}
			$out .= "\t<input type=\"submit\" class=\"btn btn-danger\" value=\"Submit\">";
			$out .= "\t</form>";
		$out .= "\t</div>";
	$out .= "\t</div>";
	$out .= footer();
	return $out;
}

function headerHTML(){
	return <<<HEAD
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8">
			<title>iCal Parser</title>
			<link href="css/bootstrap.css" rel="stylesheet">
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
			<script src="js/bootstrap.js" type="text/javascript"></script>
			<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
			<link href="css/css.css" rel="stylesheet">
		</head>
		<body>
HEAD;
}
function footer(){
	$out = "";
	$out .= "\t</body>\n";
	$out .= "</html>\n";
	return $out;
}

function formSubmit($AllEvents){
	$ids = $_POST["events"];
	$events = array();
	$events = array_intersect_key($AllEvents, array_flip($ids)); // This should be more efficient
	return $events;
}

function landing(){
	$out = headerHTML();

	$out .= <<<EOF
	<div class="jumbotron">
	<div class="container">
		<h1>PAX Schedule Creator</h1>
		<p>This small tool lets you create an <a href="http://en.wikipedia.org/wiki/ICalendar">iCalendar file</a> of the PAX schedule. This works for any PAX event that currently exists. We're going to keep this up to date with the most recent XML file PA gives us. After you have the file you can import it into your favourite calendar program. We've tested it with Calendar(OS X) and Google Calendar and it works flawlessly. The source code can be found <a href="https://github.com/ifish12/PAX-Schedule-Creator">here</a></p>
	</div>
	</div>

	<div class="container">
	
		<div class="row">
			<div class="col-md-6">
				<h2>All Events to iCalendar</h2>
				<p>This takes all the events on the PAX schedule and puts them into a iCalendar file</p>
				<p><a class="btn btn-primary" href="?action=allEvents">All events to iCalendar</a></p>
			</div>
			<div class="col-md-6">
				<h2>Choose what events go to iCalendar</h2>
				<p>This throws you to a list of check boxes which you can then pick and choose what events go into the iCalendar file if you don't want to import every single event into the iCalendar file</p>
				<p><a class="btn btn-danger" href="?action=form">Choose what events go to iCalendar</a></p>
			</div>
		</div>

		<hr>

		<footer>
			<p>Lovingly handcrafted by <a href="http://twitter.com/ifish12">Geoff Shapiro</a> &amp; <a href="https://twitter.com/Scuzzball">Mark Furland</a></p>
		</footer>
	</div> <!-- /container -->
EOF;

	$out .= footer();
	return $out;
}

function parseEvents(){ // This function is our temporary fix for a bigger issue. 
	$xmlLocation = "http://hw1.pa-cdn.com/pax/resources/guidebookschedule.xml";
	$scheduleData = new SimpleXMLElement($xmlLocation, NULL, TRUE);

	$events = array();
	foreach($scheduleData->panel as $event){
		$events[(int)$event->panelid] = new Event($event);
	}
	return $events;
}