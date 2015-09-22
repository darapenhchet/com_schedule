<?php
// No direct access.
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class ScheduleModelEvents extends JModel
{
	var $_events;

	var $_total;

	var $_pagination;

	function __construct()
	{
		global $mainframe;
		parent::__construct();
		// Get the pagination request variables
		$limit = $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'));
		$limitstart = $mainframe->getUserStateFromRequest($option.'limitstart', 'limitstart', 0);
		// Set the state pagination variables
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	function _buildQuery(){
		$query = " SELECT s.*, u.name ".
				 " FROM #__schedule_ci s ".
				 " LEFT JOIN #__users u ON s.userid = u.id ".
				 $this->_buildWhereQuery().
				 " ORDER BY s.datecreate DESC";

		return $query;
	}

	function _buildWhereQuery(){
		global $mainframe, $option;
		$filter_search = $mainframe->getUserStateFromRequest($option.'filter_search','filter_search');
		// Prepare the WHERE clause
		$where = array();
		// Determine search terms
		if ($filter_search = trim($filter_search))
		{
			$filter_search = JString::strtolower($filter_search);
			$db =& $this->_db;
			$filter_search = $db->getEscaped($filter_search);
			$where[] = ' (LOWER(s.title) LIKE "%'.$filter_search.'%"'
					 . ' OR LOWER(s.description) LIKE "%'.$filter_search.'%"'
					 . ' OR LOWER(s.place) LIKE "%'.$filter_search.'%"'
					 . ' OR LOWER(s.eventstart) LIKE "%'.$filter_search.'%"'
					 . ' OR LOWER(s.eventend) LIKE "%'.$filter_search.'%"'
					 . ' OR LOWER(s.datecreate) LIKE "%'.$filter_search.'%"'
					 . ' OR LOWER(u.name) LIKE "%'.$filter_search.'%")';
		}
		// return the WHERE clause
		return (count($where)) ? ' WHERE '.implode(' AND ', $where): '';
	}
	public function getEvents(){
		$db =& JFactory::getDBO();
		//$db->setQuery( $this->_buildQuery() );
		if( empty($this->_events) )
		{
			// Build query and get the limits from current state
			$query = $this->_buildQuery();
			$limitstart = $this->getState('limitstart');
			$limit = $this->getState('limit');
			$this->_events = $this->_getList($query, $limitstart, $limit);
		}
		//$this->_events = $db->loadObjectList();
		// Return the events data
		return $this->_events;
	}

	function getPagination()
	{
		if (empty($this->_pagination))
		{
			// Import the pagination library
			jimport('joomla.html.pagination');
			// Prepare the pagination values
			$total = $this->getTotal();
			$limitstart = $this->getState('limitstart');
			$limit = $this->getState('limit');
			// Create the pagination object
			$this->_pagination = new JPagination($total,$limitstart,$limit);
		}
		return $this->_pagination;
	}

	function getTotal()
	{
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}

	public function getEvent($id){
		$db = $this->getDBO();
		$query = " SELECT s.*, u.name ".
			     " FROM #__schedule_ci s" .
			     " LEFT JOIN #__users u ON s.userid = u.id WHERE s.id = " . $id;
		$db->setQuery($query);
		$event = $db->loadObject();
		if($event === null)
		{
			JError::raiseError(500, 'Event ['.$id.'] not found.');
		}
		else
		{
			// Return the Event data
			return $event;
		}
	}

	public function getEventType(){
		$db = $this->getDBO();
		$query = " SELECT * FROM #__schedule_ci_type ";
		$db->setQuery($query);
		$event = $db->loadObjectList();
		if($event === null)
		{
			JError::raiseError(500, 'Event not found.');
		}
		else
		{
			// Return the Event data
			return $event;
		}
	}

	function getNewEvent()
	{
		$newEvent =& $this->getTable( 'event' );
		$newEvent->id = 0;
		return $newEvent;
	}

	public function saveschedulepro($data){
		// Get a db connection.
	// 	$db = $this->getDBO();
		 
	// 	// Create a new query object.
	// 	$query = $db->getQuery(true);
		 
	// 	// Insert columns.
	// 	$columns = array('title', 'description', 'place', 'eventstart', 'eventend', 'userid', 'imageurl', 'url', 'type');
		 
	// 	// Insert values.
	// //	$values = array($data["title"], $data["description"], $data["place"], $data["eventstart"], $data["eventend"], $data["userid"], $data["imageurl"], $data["url"], $data["type"] );
	// 	 $values = array($data["title"], $data["description"], 'pp', '2015-02-03 00:00:00', '2015-02-03 00:00:00', 1107, '','', '' );
	// 	// Prepare the insert query.
	// 	$query
	// 	    ->insert($db->quoteName('#dbsc_schedule_ci'))
	// 	    ->columns($db->quoteName($columns))
	// 	    ->values(implode(',', $values));
		 
	// 	// Set the query using our newly populated query object and execute it.
	// 	$db->setQuery($query);
	// 	$db->execute();
		$title = $data["title"];
		$description = $data["description"];
		$place = $data["place"];
		$eventstart = $data["eventstart"];
		$eventend= $data["eventend"];
		$userid= $data["userid"];
		$imageurl = $data["imageurl"];
		$url = $data["url"];
		$type= $data["type"];
		$db =& JFactory::getDBO();
		//echo $title;
		//$query = "INSERT INTO '#__schedule_ci' ('title', 'description', 'place', 'eventstart', 'eventend', 'userid', 'imageurl', 'url', 'type') VALUES ('".$title."', '". $description. "', '".$place."', '".$eventstart."', '".$eventend."', '".$userid."', '".$imageurl."', '".$url."', '".$type."')";\
		$query = "INSERT INTO #__schedule_ci (title, description, place, eventstart, eventend, userid, imageurl, url, type) VALUES ('".$title."', '". $description. "', '".$place."', '".$eventstart."', '".$eventend."', '".$userid."', '".$imageurl."', '".$url."', '".$type."')";
		$db->setQuery($query);
		$db->query();
		$event_id = $db->getAffectedRows();
		//echo $event_id;


	}
	public function editschedulepro($data){
		$id = $data["id"];
		$title = $data["title"];
		$description = $data["description"];
		$place = $data["place"];
		$eventstart = $data["eventstart"];
		$eventend= $data["eventend"];
		$userid= $data["userid"];
		$imageurl = $data["imageurl"];
		$url = $data["url"];
		$type= $data["type"];
		$db =& JFactory::getDBO();
		$query = "INSERT INTO #__schedule_ci (title, description, place, eventstart, eventend, userid, imageurl, url, type) VALUES ('".$title."', '". $description. "', '".$place."', '".$eventstart."', '".$eventend."', '".$userid."', '".$imageurl."', '".$url."', '".$type."')";
		$query = "UPDATE #__schedule_ci SET title='".$title."', description='".$description."', place='".$place."', eventstart='".$eventstart."', ".
				   "eventend='".$eventend."', userid='".$userid."', imageurl='".$imageurl."', url='".$url."', type='".$type."' where id=".$id."";
		$db->setQuery($query);
		$db->query();
		$event_id = $db->getAffectedRows();
		//echo $event_id;


	}
	public function store(){
		// Get the table
		$table =& $this->getTable("event");
		//$table->load(JRequest::get('id','','post');
		$event = JRequest::get('post');
		// Convert the date to a form that the database can understand
		jimport('joomla.utilities.date');
		$eventstart = new JDate( JRequest::getVar( 'eventstart', '', 'post' ));
		$event['eventstart'] = $eventstart->toMySQL();
		$eventend = new JDate( JRequest::getVar( 'eventend', '', 'post' ));
		$event['eventend'] = $eventend->toMySQL();
		// Make sure the table buffer is empty
		$table->reset();
		// Close order gaps
		$table->reorder();
		// Determine the next order position for the revue
		$table->set( 'ordering', $table->getNextOrder());
		// Bind the data to the table
		if( !$table->bind($event))
		{
			$this->setError( $this->_db->getErrorMsg());
			return false;
		}
		// Validate the data
		if( !$table->check())
		{
			$this->setError( $this->_db->getErrorMsg());
			return false;
		}
		// Store the event
		if( !$table->store())
		{
			// An error occurred, update the model error message
			$this->setError( $table->getErrorMsg());
			return false;
		}
		// Checkin the event
		if( !$table->checkin())
		{
			// An error occurred, update the model error message
			$this->setError( $table->getErrorMsg());
			return false;
		}
		return true;
	}

	public function update(){
		$table =& $this->getTable("event");	
	}

	function delete( $cids )
	{
		$db = $this->getDBO();
		$table = $db->nameQuote('#__schedule_ci');
		$id = $db->nameQuote('id');
		$query = ' DELETE FROM ' . $table
	     	   . ' WHERE ' . $id
			   . ' IN (' . implode( ',', $cids ) . ') ';
		$db->setQuery( $query );
		if( !$db->query() )
		{
			$errorMessage = $this->getDBO()->getErrorMsg();
			JError::raiseError(500, 'Error deleting revues: '. $errorMessage );
		}
	}
}

?>