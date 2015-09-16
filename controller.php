<?php

// No direct access.
defined('_JEXEC') or die('Restricted access.');

jimport('joomla.application.component.controller');

class ScheduleController extends JController
{
	public function display($cachable = false, $urlparams = false)
	{
		//return parent::display($cachable, $urlparams);
		// Set the view and the model
		$view = JRequest::getVar( 'view', 'events' );
		$layout = JRequest::getVar( 'layout', 'default' );
		$view =& $this->getView( $view, 'html' );
		$model =& $this->getModel( 'events' );
		$view->setModel( $model, true );
		$view->setLayout( $layout );
		// Display the revue
		$view->display();
	}

	public function add()
	{
		// Set the view for a single revue
		$view =& $this->getView( JRequest::getVar( 'view', 'event' ), 'html' );
		$model =& $this->getModel( 'events' );
		$view->setModel( $model, true );
		$view->add();
	}

	public function edit()
	{
		//echo 'Hello';
		// Get the requested id(s) as an array of ids
		$cids = JRequest::getVar('cid', null, 'default', 'array');
		//var_dump($cids);	
		if( $cids === null )
		{
			// Report an error if there was no cid parameter in the request
			JError::raiseError( 500,'cid parameter missing from the request' );
		}
		// Get the first event to be edited
		//echo 'ON EVENT ID='.$eventId;
		$eventId = (int)$cids[0];
		//echo 'BELOW EVENT ID='.$eventId;
		// Set the view and model for a single event
		$view =& $this->getView( JRequest::getVar( 'view', 'event' ), 'html' );
		$model =& $this->getModel( 'events' );
		//var_dump($model);
		$view->setModel( $model, true );
		// Display the edit form for the requested event
		$view->edit( $eventId );
	}

	public function save()
	{
		//$jinput = JRequest::get('post');
		$user = JFactory::getUser();
		$data = array(
		  					"title"				=> JRequest::getVar('title', '', 'post'),
			  				"description"		=> JRequest::getVar('description', '', 'post'),
			  				"place"				=> JRequest::getVar('place', '', 'post'),
			  				"eventstart" 		=> JRequest::getVar('eventstart', '', 'post'),
			  				"eventend"			=> JRequest::getVar('eventend', '', 'post'),
			  				"userid"			=> $user->get('id'),
			  				"imageurl"      	=> JRequest::getVar('imageurl', '', 'post'),
			  				"url"				=> JRequest::getVar('url', '', 'post'),
			  				"type"				=> JRequest::getVar('type', '', 'post')
			  	);

		//echo $data["title"];
		$model =& $this->getModel( 'events' );
		$model->saveschedulepro($data);
		// $model =& $this->getModel( 'events' );
		// $model->store();
		 $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		 $this->setRedirect( $redirectTo, 'Schedule Saved Successfully.' );
	}

	function update(){
		echo "PUSH NOTIFICATION...";
		//BEGIN NOTIFICATION
		$message = 'This is alert from the APNS Server';
		$badge = 1;
		$sound = 'sub.caf';
		$development = true;
		echo '1';
		$payload = array();
		$payload['aps'] = array('alert' => $message, 'badge' => intval($badge), 'sound' => $sound);
		$payload = json_encode($payload);
		echo '2';
		$apns_url = NULL;
		$apns_cert = NULL;
		$apns_port = 2195;
		echo '3';
		if($development){	
			$apns_url = 'gateway.sandbox.push.apple.com';
			$apns_cert = 'ck.pem';
			echo '4';
		}else{
			$apns_url = 'gateway.push.apple.com';
			$apns_cert = 'ck.pem';
			echo '5';
		}

		$stream_context = stream_context_create();
		stream_context_set_option($stream_context, 'ssl', 'local_cert', $apns_cert);
		echo '6';
		$apns = stream_socket_client('ssl://' . $apns_url . ':' . $apns_port, $error, $error_string, 60, STREAM_CLIENT_CONNECT, $stream_context);
		if(!$apns){
			echo 'Error: ' . $error_string;
		}
		echo '7';
		$device_tokens = array();
		array_push($device_tokens,'481b973bbf4643bac5aea7d369dd180fe6e301a881ec764555144885c897422b');
		foreach($device_tokens as $device_token)
		{
			$apns_message = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $device_token)) . chr(0) . chr(strlen($payload)) . $payload;
			fwrite($apns, $apns_message);
		}
		echo '8';
		@socket_close($apns);
		@fclose($apns);
		echo '9';
		echo 'SUCCESSFULLY WITH PUSH NOTIFICATION';
		// END PUSH NOTIFICATION
	}

	function cancel()
	{
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		$this->setRedirect( $redirectTo, 'Cancelled' );
	}
}
?>