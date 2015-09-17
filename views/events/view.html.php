<?php
// No direct access.
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class ScheduleViewEvents extends JView
{
	protected $item;

	public function display($tpl = null){

		global $mainframe;

		JToolBarHelper::title(JText::_('Schedules'));
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		// Prepare list array
		$lists = array();
		// Get the user state
		$filter_order = $mainframe->getUserStateFromRequest(
											$option.'filter_order',
											'filter_order', 'published');
		$filter_order_Dir = $mainframe->getUserStateFromRequest(
											$option.'filter_order_Dir',
											'filter_order_Dir', 'ASC');
		
		// Build the list array for use in the layout
		$lists['order'] = $filter_order;
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['state'] = JHTML::_('grid.state', $filter_state);

		// Get the model
		$model =& $this->getModel("events");
		$events = $model->getEvents();
		$page = $model->getPagination();

		// Assign references for the layout to use
		$this->assignRef('lists', $lists);
		$this->assignRef('events', $events );
		$this->assignRef('page', $page);

		parent::display($tpl);
	}
}

?>