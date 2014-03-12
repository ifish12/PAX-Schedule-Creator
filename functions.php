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
	<div class="container-fluid">
		<div class="row">
			<div id="sidebar" class="col-sm-3 col-md-2 sidebar">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#Friday">
								Friday
							</a>
						</h4>
					</div>
					<div id="Friday" class="panel-collapse collapse">
						<div class="panel-body">
							<label><input type="checkbox" name="10" value="10">10:00-11:00</label>
							<label><input type="checkbox" name="11" value="11">11:00-12:00</label>
							<label><input type="checkbox" name="12" value="12">12:00-13:00</label>
							<label><input type="checkbox" name="13" value="13">13:00-14:00</label>
							<label><input type="checkbox" name="14" value="14">14:00-15:00</label>
							<label><input type="checkbox" name="15" value="15">15:00-16:00</label>
							<label><input type="checkbox" name="16" value="16">16:00-17:00</label>
							<label><input type="checkbox" name="17" value="17">17:00-18:00</label>
							<label><input type="checkbox" name="18" value="18">18:00-19:00</label>
							<label><input type="checkbox" name="19" value="19">19:00-20:00</label>
							<label><input type="checkbox" name="20" value="20">20:00-21:00</label>
							<label><input type="checkbox" name="21" value="21">21:00-22:00</label>
							<label><input type="checkbox" name="22" value="22">22:00-23:00</label>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#Saturday">
								Saturday
							</a>
						</h4>
					</div>
					<div id="Saturday" class="panel-collapse collapse">
						<div class="panel-body">
							<label><input type="checkbox" name="10" value="10">10:00-11:00</label>
							<label><input type="checkbox" name="11" value="11">11:00-12:00</label>
							<label><input type="checkbox" name="12" value="12">12:00-13:00</label>
							<label><input type="checkbox" name="13" value="13">13:00-14:00</label>
							<label><input type="checkbox" name="14" value="14">14:00-15:00</label>
							<label><input type="checkbox" name="15" value="15">15:00-16:00</label>
							<label><input type="checkbox" name="16" value="16">16:00-17:00</label>
							<label><input type="checkbox" name="17" value="17">17:00-18:00</label>
							<label><input type="checkbox" name="18" value="18">18:00-19:00</label>
							<label><input type="checkbox" name="19" value="19">19:00-20:00</label>
							<label><input type="checkbox" name="20" value="20">20:00-21:00</label>
							<label><input type="checkbox" name="21" value="21">21:00-22:00</label>
							<label><input type="checkbox" name="22" value="22">22:00-23:00</label>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#Sunday">
								Sunday
							</a>
						</h4>
					</div>
					<div id="Sunday" class="panel-collapse collapse">
						<div class="panel-body">
							<label><input type="checkbox" name="10" value="10">10:00-11:00</label>
							<label><input type="checkbox" name="11" value="11">11:00-12:00</label>
							<label><input type="checkbox" name="12" value="12">12:00-13:00</label>
							<label><input type="checkbox" name="13" value="13">13:00-14:00</label>
							<label><input type="checkbox" name="14" value="14">14:00-15:00</label>
							<label><input type="checkbox" name="15" value="15">15:00-16:00</label>
							<label><input type="checkbox" name="16" value="16">16:00-17:00</label>
							<label><input type="checkbox" name="17" value="17">17:00-18:00</label>
							<label><input type="checkbox" name="18" value="18">18:00-19:00</label>
							<label><input type="checkbox" name="19" value="19">19:00-20:00</label>
							<label><input type="checkbox" name="20" value="20">20:00-21:00</label>
							<label><input type="checkbox" name="21" value="21">21:00-22:00</label>
							<label><input type="checkbox" name="22" value="22">22:00-23:00</label>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#Monday">
								Monday
							</a>
						</h4>
					</div>
					<div id="Monday" class="panel-collapse collapse">
						<div class="panel-body">
							<label><input type="checkbox" name="10" value="10">10:00-11:00</label>
							<label><input type="checkbox" name="11" value="11">11:00-12:00</label>
							<label><input type="checkbox" name="12" value="12">12:00-13:00</label>
							<label><input type="checkbox" name="13" value="13">13:00-14:00</label>
							<label><input type="checkbox" name="14" value="14">14:00-15:00</label>
							<label><input type="checkbox" name="15" value="15">15:00-16:00</label>
							<label><input type="checkbox" name="16" value="16">16:00-17:00</label>
							<label><input type="checkbox" name="17" value="17">17:00-18:00</label>
							<label><input type="checkbox" name="18" value="18">18:00-19:00</label>
							<label><input type="checkbox" name="19" value="19">19:00-20:00</label>
							<label><input type="checkbox" name="20" value="20">20:00-21:00</label>
							<label><input type="checkbox" name="21" value="21">21:00-22:00</label>
							<label><input type="checkbox" name="22" value="22">22:00-23:00</label>
						</div>
					</div>
				</div>

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
			<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
			<link href="css/css.css" rel="stylesheet">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-48072408-1', 'paxschedule.com');
  ga('send', 'pageview');

</script>
		</head>
		<body>
HEAD;
}
function footer(){
	return <<<FOOT
		<footer>
			<p>Lovingly handcrafted by <a href="http://twitter.com/ifish12">Geoff Shapiro</a> &amp; <a href="https://github.com/Scuzzball">Mark Furland</a></p>
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
			<script src="js/bootstrap.js" type="text/javascript"></script>
			<script src="js/filter.js" type="text/javascript"></script>
		</footer>
		</body>

	</html>
FOOT;
}

function formSubmit($AllEvents){
	$ids = $_POST["events"];
	$events = array();
	$events = array_intersect_key($AllEvents, array_flip($ids)); // This IS more efficient
	return $events;
}

function landing(){
	$out = headerHTML();

	$out .= <<<EOF
	<div class="jumbotron">
	<div class="container">
		<h1>PAX Schedule Creator</h1>
		<p>This tool lets you create an <a href="http://en.wikipedia.org/wiki/ICalendar">iCalendar file</a>(The standard calender file format) of the PAX schedule. This will be kept up to date with the most recent XML schedule we can get from PA, usually about a month before the convention. 
		<br>The source code can be found <a href="https://github.com/ifish12/PAX-Schedule-Creator">here</a></p>
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
				<p><a class="btn btn-success" href="?action=form">Choose what events go to iCalendar</a></p>
			</div>
		</div>

		<hr>

		

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