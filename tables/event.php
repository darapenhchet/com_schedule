<?php
	defined( '_JEXEC' ) or die( 'Restricted access' );
	class TableEvent extends JTable{
		var $id = 0;
		var $title = '';
		var $description = '';
		var $place = '';
		var $datestart = '';
		var $dataend = '';
		var $cratedate = '';
		var $userid = 0;
		var $imageurl = '';
		var $url = '';
		var $type = '';

		function __construct(&$db){
			parent::__construct('#__schedule_ci','id', $db);
		}
	}
?>