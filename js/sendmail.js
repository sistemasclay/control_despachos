// Turn off the alert pop up
wf.showAlertOnError = false;

// Tap into the validation routine and do our Ajax stuff
wf.functionName_formValidation = "myCustomValidation";

function myCustomValidation (evt) 
{
	if(wf.formValidation(evt)) new Ajax.Updater('result', 'registroContactosProyecto.php',{onLoading:function(request){sendmail()},onComplete:function(request){handelrequest()},parameters:Form.serialize(document.forms['contact']), insertion:Insertion.Bottom, asynchronous:true});
	return wf.utilities.XBrowserPreventEventDefault(evt);
}

function sendmail() 
{
	//Make the Progress Bar Appear
	//new Effect.Appear('progress');
	alert('llego');

	document.forms['contact'].submitbutton.disabled = true
}

function handelrequest() 
{
	// Fade the Progress Bar
	//new Effect.Fade('progress');
	// Make the form itsef wipe up
	//new Effect.BlindUp('form');
	// Show the result!
	//new Effect.Appear('result');
}