<?php
// No direct access.
defined('_JEXEC') or die('Restricted access'); ?>

	<form action="index.php" method="post"	name="adminForm" id="adminForm">
		<div class="col100">
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'Details' ); ?></legend>
			<table class="admintable">
				<tr>
					<td width="100" align="right" class="key">
						<label for="title">
							<?php echo JText::_( 'Schedule Title' ); ?>:
						</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="title" id="title" size="60" value="<?php echo $this->event->title;?>" />
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="description">
							<?php echo JText::_( 'Description' ); ?>:
						</label>
					</td>
					<td>
						<textarea class="inputbox" type="text" name="description" style="width:318px;" id="description"
							   ><?php echo $this->event->description;?></textarea>
					</td>
				</tr>	
				<tr>
					<td width="100" align="right" class="key">
						<label for="place">
							<?php echo JText::_( 'Place' ); ?>:
						</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="place" size="60" id="place"
							   value="<?php echo $this->event->place;?>" />
					</td>
				</tr>	
				<tr>
					<td width="100" align="right" class="key">
						<label for="type">
							<?php echo JText::_( 'Type' ); ?>:
						</label>
					</td>
					<td>
						
						<select class="inputbox" name="type" id="type">
							<?php foreach( $this->eventtype as $row )
								{  ?>
								<option value="<?php echo $row->id;?>" 
									<?php if($row->id == $this->event->type ){?>selected
									<?php }?>
								><?php echo $row->title;?></option>

							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="shift">
							<?php echo JText::_( 'Shift' ); ?>:
						</label>
					</td>
					<td>
						<select class="inputbox" name="shift" id="shift">
							<option value="morning" selected>Morning</option>
							<option value="afternoon">Afternoon</option>
							<option value="evening">Evening</option>
							<option value="fullday">Full Day</option>

						</select>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="eventstart">
							<?php echo JText::_( 'Event Start' ); ?>:
						</label>
					</td>
					<td>
						<?php echo JHTML::_( 'calendar'
											, JHTML::_('date'
												      , $this->event->eventstart
												      , JText::_('%Y-%m-%d %H:%M:%S'))
											, 'eventstart'
											, 'eventstart'
											, JText::_('%Y-%m-%d %H:%M:%S')
											, array( 'class'=>'inputbox'
													,'size'=>'25'
													,'maxlength'=>'19' ) ); ?>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="eventend">
							<?php echo JText::_( 'Event End' ); ?>:
						</label>
					</td>
					<td>
						<?php echo JHTML::_( 'calendar'
											, JHTML::_('date'
												      , $this->event->eventend
												      , JText::_('%Y-%m-%d %H:%M:%S'))
											, 'eventend'
											, 'eventend'
											, JText::_('%Y-%m-%d %I:%M:%S')
											, array( 'class'=>'inputbox'
													,'size'=>'25'
													,'maxlength'=>'19' ) ); ?>
					</td>
				</tr>
			</table>
			</fieldset>
		</div>
		<input type="hidden" name="eventid" value="<?php echo $this->event->id; ?>" />
		<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="version" value="<?php echo $row->version; ?>" />
		<input type="hidden" name="mask" value="0" />
		<input type="hidden" name="userid" value="<?php echo $this->event->userid;?>" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="<?php JRequest::getVar('task')=="edit" ? "update":"save"?>" />
	</form>