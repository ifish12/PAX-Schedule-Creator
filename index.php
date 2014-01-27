<?PHP
include("Event.php");
include("functions.php");

$action = isset($_GET["action"]) ? $_GET["action"] : null;

switch($action){
	case "allEvents":
		echo iCalOut(parseEvents());
		break;
	case "form":
		echo form(parseEvents());
		break;
	case "formSubmit":
		$selectedEvents = formSubmit(parseEvents());
		iCalOut($selectedEvents);
		break;
	default:
		echo landing();
}
?>