<?php
// No direct access.
defined('_JEXEC') or die('Restricted access.');

//jimport('joomla.application.component.controller');
//$controller = JController::getInstance('Helloworld');

require_once( JPATH_COMPONENT.DS.'controller.php' );
// Create the controller
$controller = new ScheduleController();

$controller->execute(JRequest::getCmd('task', 'display'));
$controller->redirect();

?>