<?php 
/**
Copyright 2012 Marina Ibrishimova and Byron Matus | Contact: admin@ibrius.net

This file is part of AppIgniter.

    AppIgniter is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    AppIgniter is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with AppIgniter.  If not, see <http://www.gnu.org/licenses/>.
**/

$this->load->view('tab/partial/header');?>

<div id="bg">
 
 	<div id="val_errors"><?php echo validation_errors(); ?></div>
	<div id="form">
    	
    	<?php echo form_open('tab/edit_tab');?>

	  <h1><?php echo ($this->lang->line('common_welcome_header')); ?></h1>
	
	
	  <p>
	    <?php echo $this->lang->line('common_currency'); ?>
	</p>
	
	<?php echo form_dropdown('currency', $currency_options, $currency); ?>
	
	<p>
	  <?php echo $this->lang->line('common_email'); ?>
	</p>
	
	<?php echo form_input(array(
		'name'=>'email', 
		'class'=>'pretty',
		'value'=>$db['email']
	)); ?>
	
	<p>
	  <?php echo $this->lang->line('common_org_name'); ?>
	</p>

	<?php echo form_input(array(
		'name'=>'page_name', 
		'class'=>'pretty',
		'value'=>$db['page_name']
	)); ?>
		
	<p>
	  <?php echo $this->lang->line('common_tab_headline'); ?>
	</p>

	<?php echo form_input(array(
		'name'=>'page_heading', 
		'class'=>'pretty',
		'value'=>$db['page_heading']
	)); ?>
	
	<p>
	  <?php echo $this->lang->line('common_message'); ?>
	</p>	
	
	<?php echo form_textarea(array(
		'name'=>'message', 
		'size'=>'6',
		'value'=>$db['message']
	)); ?>

	<?php echo form_submit(array(
		'value' => $this->lang->line('common_update'),
		'class' => 'submit'
	)); ?>
	

    <?php echo form_close(); ?>
	</div>

	<div id="val_errors"><?php echo validation_errors(); ?></div>

</div>
<?php $this->load->view('tab/partial/footer');