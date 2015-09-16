<?php
// No direct access.
defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm">
	<table>
		<tr>
			<td align="left" width="100%"></td>
			<td nowrap="nowrap">
				<?php echo $this->lists['state']; ?>
			</td>
		</tr>
	</table>
	<table class="adminlist">
	<thead>
		<tr>
			<th width="10"><?php echo JText::_( 'ID' ); ?></th>
			<th width="10">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->schedules ); ?>);" />
			</th>
			<th>
				<?php //echo JText::_('Title'); 
					echo JHTML::_('grid.sort',   'Title', 's.title', @$lists['order_Dir'], @$lists['order'] );
				?>

				</th>
			<th><?php echo JText::_('Description'); ?></th>
			<th width="10%"><?php echo JText::_('Place'); ?></th>
			<th width="10%">
				<?php echo JText::_('Start Date'); ?>
			</th>
			<th width="10%" align="center">
				<?php echo JText::_('End Date'); ?>
			</th>
			<th width="10%" align="center"><?php echo JText::_('Author'); ?></th>
			<th width="10%" align="center"><?php echo JText::_('Created Date'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
			$k = 1;
			$i = 1;
			foreach( $this->events as $row )
			{
				$checked = JHTML::_('grid.id', $i, $row->id );
				$published = JHTML::_('grid.published', $row, $i );
				$link = JRoute::_('index.php?option='. JRequest::getVar( 'option' ). '&task=edit&cid[]='. $row->id
							. '&hidemainmenu=1' );
		?>
			<tr class="<?php echo "row $k"; ?>">
				<td><?php echo $i; ?></td>
				<td><?php echo $checked; ?></td>
				<td>
					<a href="<?php echo $link; ?>">
						<?php echo $row->title; ?>
					</a>
				</td>
				<td><?php echo $row->description; ?></td>
				<td align="center"><?php echo $row->place; ?></td>
				<td align="center"><?php echo $row->eventstart; ?></td>
				<td align="center"><?php echo $row->eventend ;	?></td>
				<td align="center"><?php echo $row->name; ?></td>
				<td align="center">
				<?php
					echo JHTML::_('date', $row->datecreate, JTEXT::_('%m/%d/%Y'));
				?>
				</td>
				<input type="hidden" name="userid" value="<?php echo $row->userid?> " />
			</tr>
		<?php
			$k = 1 - $k;
			$i++;
		} ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->page->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' ); ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="hidemainmenu" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="" />
</form>