<?PHP
/**
 * makeICal creates the ical for the given events
 * @param events Events to turn into ical
 **/
function makeICal($events){
	$ical = "";
	$ical .= "BEGIN:VCALENDAR\r\n";
	$ical .= "VERSION:2.0\r\n";
	$ical .= "PRODID:-//Mark and Geoff//PAX ICAL PARSER//EN\r\n";
	foreach($events as $event){
		$ical .= $event->vEvent();
	}
	$ical .= "END:VCALENDAR";
	return $ical;
}

function outputICal($ical){
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


function form($events,$paxID){
	global $DAYS;

	$out = headerHTML();
	$out .= <<<SIDEBAR
	<div class="container-fluid">
		<div class="row">
			<div id="sidebar" class="col-sm-3 col-md-2 sidebar">
SIDEBAR;
	foreach($DAYS as $day => $useDay){
		if($useDay){
			$out .= <<<DAY
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#$day">
								$day
							</a>
						</h4>
					</div>
					<div id="$day" class="panel-collapse collapse">
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
							<label><input type="checkbox" name="23" value="22">23:00-00:00</label>
						</div>
					</div>
				</div>
DAY;
		}
	}
	$out .= <<<SIDEBAR
			</div><!--End sidebar-->
			<form id="form" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" action="?action=formSubmit&amp;paxID=$paxID" method="POST">
SIDEBAR;
			foreach($events as $event){
				$out .= $event->formOut();
			}
			$out .= "\t<input onClick=\"_gaq.push(['_trackEvent', 'DownloadIcal', 'All']);\" type=\"submit\" class=\"btn btn-danger\" value=\"Submit\">";
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
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-48072408-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
		</head>
		<body>
HEAD;
}
function footer(){
	return <<<FOOT
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
			<script src="js/bootstrap.js" type="text/javascript"></script>
			<script src="js/filter.js" type="text/javascript"></script>
		</body>
	</html>
FOOT;
}

function footerText(){
	return <<<FOOT
		<footer>
			<p>Lovingly handcrafted by <a href="http://twitter.com/ifish12">Geoff Shapiro</a> &amp; <a href="https://github.com/Scuzzball">Mark Furland</a></p>
		</footer>
FOOT;
}

function formSubmit($AllEvents){
	if(!isset($_POST["events"])){
		echo "CHeck an event";
		die;
	}
	$ids = $_POST["events"];
	$events = array();
	$events = array_intersect_key($AllEvents, array_flip($ids)); // This IS more efficient
	return $events;
}

function landing(){
	global $PAXES;
	$out = headerHTML();

	$out .= <<<TEXT
	<div class="jumbotron">
		<div class="container">
			<h1>PAX Schedule Creator</h1>
			<p>This tool lets you create an <a href="http://en.wikipedia.org/wiki/ICalendar">iCalendar file</a>(The standard calendar file format) of the PAX schedule. This will be kept up to date with the most recent XML schedule we can get from Penny Arcade, usually about a month before the convention.
			<br>This tool is not affilaited with Penny Arcade or PAX, it is merely a community tool to help people keep track of events at PAX.
			<br>If you would like to know more about this project and the developers you can read about them <a href="http://paxschedule.com/?action=about">here</a>
			<br>The source code can be found <a href="https://github.com/ifish12/PAX-Schedule-Creator">here</a></p>
		</div>
	</div>

	<div class="container">

		<form class="row">
			<div class="col-md-12">
				<select name="paxID" class="form-control">
TEXT;

				foreach($PAXES as $key => $pax){
					$out .= "<option value=\"$key\">{$pax["name"]}</option>\n";
				}

	$out .= <<<TEXT
				</select>
			</div>
			<div class="col-md-6">
				<h2>All Events to iCalendar</h2>
				<p>This takes all the events on the PAX schedule and puts them into a iCalendar file</p>
				<p><button onClick="_gaq.push(['_trackEvent', 'DownloadIcal', 'All']);" type="submit" class="btn btn-primary" name="action" value="allEvents">All events to iCalendar</button></p>
			</div>
			<div class="col-md-6">
				<h2>Choose what events go to iCalendar</h2>
				<p>This throws you to a list of check boxes which you can then pick and choose what events go into the iCalendar file if you don't want to import every single event into the iCalendar file</p>
				<p><button type="submit" class="btn btn-success" name="action" value="form">Choose what events go to iCalendar</button></p>
			</div>
		</form>

		<hr>



TEXT;

	$out .= footerText();
	$out .= footer();
	return $out;
}

/**
 * parseEvents parses the reuired xml, and returns the array
 * $index is the index of the desired pax in the $PAXES array
 **/
function parseEvents($paxID){
	global $PAXES;
	$scheduleData = new SimpleXMLElement($PAXES[$paxID]['xml'], NULL, TRUE);

	$events = array();
	foreach($scheduleData->panel as $event){
		$events[(int)$event->panelid] = new Event($event,$paxID);
	}
	return $events;
}


function about(){
	$out = headerHTML();
	$out .= <<<ABOUT
		<div class="jumbotron">
			<div class="container">
				<h1>Want to know more about this project?</h1>
				<p>On this page you will read about the developement of this project, how this project all started, and even how Mark met Geoff.
				<br>It's a pretty interesting story so read on if you're interested</p>
			</div>
			</div>

			<div class="container">

				<div class="row">
					<div class="col-md-12">
						<h2>How Mark and Geoff met</h2>
						<p>This is actually a pretty cool story considering where this is being written.
						<br>So, Mark in March of 2013 made a similar thing to this, it was way simpler though, you can find it <a href="http://pastebin.com/Lerwg7wT">here</a>.
						<br>Geoff actually had the same exact idea and did a Google search before he started coding his own version, and he found the version Mark had made.
						<br>At the time, Mark's version had his full name on it, so Geoff found his Facebook and sent him a message, though Mark never checks Facebook so it went unnoticed until around summer of 2013
						<br>Geoff figured Mark wouldn't respond to the message and then made his own, which can be found <a href="https://github.com/ifish12/PaxSchedule-To-ICS">here</a>.
						<br>Anyway, so in summer 2013, Mark finally contacts Geoff back through Facebook and they exchange Skype contacts, and eventually they start to talk often and actually get pretty close
						</p>
					</div>
					<div class="col-md-12">
						<h2>How we got the idea to make this version.</h2>
						<p>You might be thinking something along the lines of "Wait, if you both already made your own versions of the same thing, why did you want to make this?" and that's a very good question!
						<br>Well, Geoff often hangs out in the #PAX IRC on the Slashnet network and <a href="https://twitter.com/h_e_e_l_s">Khahil White</a> approached Geoff saying he heard about the previous version he made and he was interested in Geoff making a faux-official one. Geoff doesn't really like working alone on projects,
						specailly not somewhat big ones, so he reached out to Mark to see if he'd want to help out. Geoff figured Mark would be great because he already knows how the iCalendar format works.
						<br>So that's how we got this idea for this project.
						<br>Also both versions Mark and Geoff both made kind of SUCKED in comparison to this anyway.
						<br>Khahil also approached Geoff a few days before PAX Prime 2013(if you care about keeping a timeline).</p>
					</div>
					<div class="col-md-12">
						<h2>How the actual developement went down and what we experienced</h2>
						<p>Anyway, in September of 2013 Khahil sent Mark and Geoff the XML file of the PAX schedule. So we started working on an actual prototype.
						<br>We actually finished the prototype in a span of two days. It didn't take very long at all. Though our design was awful and the functionality was pretty barebones.
						<br>We had the functions to export everything into an iCalendar file, or a big list like we do now, but instead of having filtering, it was just a big list. Nobody has time to scroll through all of that data.
						<br>So, for a few months we just let it sit there. Around November we decided to rehaul the design using <a href="http://getbootstrap.com/">Bootstrap</a> because the way it was before was just disgusting.
						<br>So in December of 2013 we got in touch with <a href="https://twitter.com/coffmandave">David Coffman</a> to talk about the XML we got from them because he maintained it.
						<br>David was actually a big influence and help with the entire project. Anyway, so after rehauling the entire design we were stumped for a few months. We kept thinking "What should we do now?"
						<br>This was Geoff's first "real" products and we wanted to use this as a time to learn things. We worked on optimization, made it as efficient as we possibly could. It was a huge learning experinece.
						<br>Then we implemented a caching mechanism. Mainly to help increase efficiency under high loads. After that, we did the hardest part which was arguably getting filtering to work.
						<br>Filtering was implemented fully in around March of 2014 and it was a challenge for both Mark and Geoff. A series of small dumb mistakes but eventually leading to success.
						<br>This entire project was a huge learning experience for both of us and we'd like to thank Khahil for giving us this idea and chance to do this.</p>
					</div>
				</div>
				<hr>
ABOUT;
	$out .= footerText();
	$out .= footer();
	return $out;
}
