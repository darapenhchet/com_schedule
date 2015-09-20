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
		$user = JFactory::getUser();
		$data = array(
							"id"				=> JRequest::getVar('eventid', '', 'post'),
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
		$model->editschedulepro($data);
		// $model =& $this->getModel( 'events' );
		// $model->store();
		 $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		 $this->setRedirect( $redirectTo, 'Schedule Saved Successfully.' );
	}

	function cancel()
	{
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		$this->setRedirect( $redirectTo, 'Cancelled' );
	}

	function remove()
	{
		// Retrieve the ids to be removed
		$cids = JRequest::getVar('cid', null, 'default', 'array');
		if( $cids === null )
		{
			// Make sure there were records to be removed
			JError::raiseError( 500, 'No schedule were selected for removal' );
		}
		$model =& $this->getModel( 'events');
		$model->delete( $cids);
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar( 'option' ).'&task=display');
		$this->setRedirect( $redirectTo, 'Schedules Deleted.' );
		
	}
}
?>