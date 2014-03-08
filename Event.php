<?PHP
class Event {

    var $title;
	var $id;
	var $startDateTime;
	var $endDateTime;
	var $track;
	var $location;
	var $description;
	var $panelistHeader;
	var $panelists;

	/**
	 * Event constructor
	 * data is an XML object containing data for the event
	 **/
	function Event($data){
		$this->title = $this->replaceAmpersand((string)$data->paneltitle);
		$this->id = (int)$data->panelid;
		//Do date stuff$subject = "abcdef";
		preg_match('/(.+(?:am|pm)) - (.+(?:am|pm))/', $data->paneltime, $matches);
		$startTime = $matches[1];
		$endTime = $matches[2];
		
		$this->startDateTime = new DateTime("2013-08-30 " . $startTime);
		$this->endDateTime = new DateTime("2013-08-30 " . $endTime);
		
		
		if($data->panelday == "Saturday"){//If it's on saturday
			$this->startDateTime->modify("+1 days");
			$this->endDateTime->modify("+1 days");
		}elseif($data->panelday == "Sunday"){
			$this->startDateTime->modify("+2 days");
			$this->endDateTime->modify("+2 days");
		}elseif($data->panelday == "Monday"){
			$this->startDateTime->modify("+3 days");
			$this->endDateTime->modify("+3 days");
		}
		$this->track = (string)$data->scheduletrack;
		$this->location = (string)$data->paneltheatre;
		$this->description = $this->replaceAmpersand((string)$data->paneldescription);
		$this->panelistHeader = (string)$data->panelistheader;
		
		if(isset($data->panelpanelists)){//If there are panelists
			if(isset($data->panelpanelists[0])){//pannelists is an array
				foreach($data->panelpanelists as $panelist){
					$this->panelists[] = (string)$panelist;
				}
			}else{//pannelists is not an array
				$this->panelists = array((string)$data->panelpanelists);//Make it one
			}
		}else{//No pannelists
			$this->panelists = null;
		}
	}//End constructor
	
	/**
	 * checkID is for checking if an ID is the ID of this event
	 * @param id
	 * @return bool
	 **/
	function checkID($id){
		return $this->id == $id ? true : false;
	}

	/**
	 * replaceAmpersand
	 * Replace all instances of '~ampersand~' with '&'
	 **/
	function replaceAmpersand($string){
		$string = str_replace('~ampersand~', '&', $string);
		return $string;
	}
	
	/**
	 * escapeForICal
	 * Escapes characters for iCal
	 **/
	function escapeForICal($string){
		$string = str_replace('\\', '\\\\', $string);
		$string = str_replace(';', '\\;', $string);
		$string = str_replace(',', '\\,', $string);
		return $string;
	}
	
	/**
	 * vEvent
	 * returns the VEVENT part of an ical file.
	 **/
	function vEvent(){
		$out = "";
		$this->startDateTime->setTimezone(timezone_open("UTC"));
		$this->endDateTime->setTimezone(timezone_open("UTC"));
		$out .= "BEGIN:VEVENT\r\n";
		$out .= "UID:" . md5(uniqid(mt_rand(), true)) . "@yourhost.test\r\n";
		$out .= "DTSTAMP:" . gmdate("Ymd").'T'. gmdate("His") . "Z\r\n";
		$out .= "DTSTART:" . $this->startDateTime->format("Ymd") . "T" . $this->startDateTime->format("His") . "Z\r\n";
		$out .= "DTEND:" . $this->endDateTime->format("Ymd") . "T" . $this->endDateTime->format("His") . "Z\r\n";
		$out .= "SUMMARY:" . $this->escapeForICal($this->title) . "\r\n";
		$out .= "DESCRIPTION:" . $this->escapeForICal($this->description) . "\r\n";
		$out .= "LOCATION:" . $this->location . "\r\n";
		$out .= "CATEGORIES:" . $this->track . "\r\n";
		$out .= "END:VEVENT\r\n";
		return $out;
	}
	
	/**
	 * formOut
	 * returns part of a form for output
	 **/
	function formOut(){
		$out = "";
	$out .= "\t<div class=\"panel panel-default eventContainer\">";
		$out .= "\t<div class=\"hidden\">{\"day\":\"" . substr($this->startDateTime->format("l"),0,2) . "\",\"time\":\"" . $this->startDateTime->format("H") . "\",\"theatre\":\"" . htmlentities($this->location) . "\"}</div>";
			$out .= "\t<div class=\"panel-heading\">\n";
				$out .= "\t\t<label class=\"panel-title eventTitle\">\n";
				$out .= "\t\t\t<input type=\"checkbox\" id=\"" . $this->id . "\" class=\"checkbox\" name=\"events[]\" value=\"" . $this->id . "\">\n";
				$out .= "\t\t\t" . htmlentities($this->title) . "\n";
				$out .= "\t\t</label>\n";
			$out .= "\t</div>\n";
			$out .= "\t<div class=\"panel-body eventData\">\n";
				$out .= "\t\t<span class=\"infoTitle\">Time:</span> " . $this->startDateTime->format("Y-m-d") . ": " . $this->startDateTime->format("H:i") . " - " . $this->endDateTime->format("H:i") . "<br>\n";
				$out .= "\t\t<span class=\"infoTitle\">Theatre:</span> " . htmlentities($this->location) . "<br>\n";
				$out .= "\t\t<span class=\"infoTitle\">Description:</span> " . htmlentities($this->description) . "\n";
			$out .= "\t</div>";
		$out .= "</div>\n";
		return $out;
	}
}
?>