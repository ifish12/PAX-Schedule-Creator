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
	echo $ical;
}


/**
 * form creates a form to choose from the given events
 * @param events
 * @return string to display
 **/
function form($events){
	$out = headerHTML();
	$out .= "\t<form action=\"?action=formSubmit\" method=\"POST\">\n";
	foreach($events as $event){
		$out .= $event->formOut();
	}
	$out .= "\t<input type=\"submit\" class=\"btn btn-danger\" value=\"Submit\">";
	$out .= "\t</form>";
	$out .= footer();
	return $out;
}

function headerHTML(){
	$out = "";
	$out .= "<!DOCTYPE html>\n";
	$out .= "<html>\n";
	$out .= "\t<head>\n";
	$out .= "\t\t<meta charset=\"UTF-8\">\n";
	$out .= "\t\t<title>iCal Parser</title>\n";
	$out .= "\t\t<link href=\"css/bootstrap.css\" rel=\"stylesheet\">\n";
	$out .= "\t\t<link href=\"css/css.css\" rel=\"stylesheet\">\n";
	$out .= "\t</head>\n";
	$out .= "\t<body>\n";
	return $out;
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
			<p>Lovingly hand crafted by <a href="http://twitter.com/ifish12">Geoff Shapiro</a> &amp; <a href="https://twitter.com/Scuzzball">Mark Furland</a></p>
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