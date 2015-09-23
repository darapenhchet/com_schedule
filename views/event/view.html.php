<?php
// No direct access.
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class ScheduleViewEvent extends JView
{
	protected $item;

	public function edit($id){
		// Build the toolbar for the edit function
		JToolBarHelper::title(JText::_('Schedule').': [<small>Edit</small>]');
		//JToolBarHelper::save('edit','Update');
		JToolBarHelper::custom( 'update', 'save.png', 'save_f2.png', 'Update', false );
		JToolBarHelper::cancel('cancel', 'Close');
		// Get the event
		$model =& $this->getModel();
		$event = $model->getEvent($id);
		$eventtype = $model->getEventType();
		//var_dump($event);
		$this->assignRef('event', $event);
		$this->assignRef('eventtype', $eventtype);
		parent::display();
	}

	public function add(){
		JToolBarHelper::title(JText::_('Schedule').': [<small>Add</small>]');
		JToolBarHelper::save();
		JToolBarHelper::cancel('cancel', 'Close');

		$model =& $this->getModel();
		$event = $model->getNewEvent();
		$eventtype = $model->getEventType();
		//var_dump($event);
		$this->assignRef('event', $event);
		$this->assignRef('eventtype', $eventtype);
		parent::display();
	}
}

?>
