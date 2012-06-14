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

$this->load->view('tab/partial/header'); ?>

<div id="donate">
	<a href="https://www.facebook.com/pages/page_name/<?php echo $page_id; ?>?sk=app_<?php echo $app_id; ?>" target="_top">
		<?php echo $this->lang->line('common_go_back_admin'); ?> </a>

	<h1 id="donate_title"><?php echo $page_heading; ?></h1>
	
	<p><?php echo nl2br($message); ?></p>
	
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="paypal">
	<input type="hidden" name="cmd" value="_donations" />
	<input type="hidden" name="business" value="<?php echo $email; ?>" />
	<input type="hidden" name="lc" value="CA" />
	<input type="hidden" name="item_name" value="<?php echo $page_name; ?>" />
	<input type="hidden" name="no_note" value="0" />
	<input type="hidden" name="cn" value="Include a note with your donation." />
	<input type="hidden" name="no_shipping" value="0" />
	<input type="hidden" name="currency_code" value="<?php echo $currency; ?>" />
	<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted" />
	<input type="text" name="amount" value="00.00" /><br>
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" align="middle" alt="PayPal - The safer, easier way to pay online!" title="<?php echo $this->lang->line('common_donate_butt_title'); ?>" />
	<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1" />
      </form>
	
</div>


<?php $this->load->view('tab/partial/footer');
