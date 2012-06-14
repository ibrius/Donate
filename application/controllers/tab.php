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
class Tab extends CI_controller
{
	function __construct()
	{
		parent::__construct('tab');
		$this->load->model('Facebook_model');
		$this->load->model('Create');
		$this->load->helper(array('form', 'url', 'language'));
		$this->load->library('form_validation');
		$this->load->helper('htmlpurifier');
		  
	}
	function index()
	{	
		// This line is needed to stop IE from blocking our cookie as 3rd party.  
		// It is a compact privacy policy. See: http://www.p3pwriter.com/LRN_111.asp
		header('p3p: CP="NOI ADM DEV PSAi COM NAV OUR OTR STP IND DEM"');
		
		// Get the Facebook data array that is being stored in our session in the Facebook_model
		// Array: [me] [uid] [login_url] [logout_url] [signedRequest] [accessToken]
		$fb_data = $this->db_session->userdata('fb_data');		
								
		// Extract the page id, and isAdmin values from the Facebook Signed Request array		
		$signed_request = $fb_data['signedRequest'];				
		$page = $signed_request['page'];
		$page_id = $page['id'];		
		$admin = $page['admin'];
		$user_id = $fb_data['uid'];
		$app_id = $fb_data['app_id'];
		
		// Add some of this data back to the session in an easier format to retrieve later
		$this->db_session->set_userdata('page_id', $page_id);
		$this->db_session->set_userdata('is_admin', $admin);
		$this->db_session->set_userdata('app_id', $app_id);
		
		//$data is the information we will be passing to the view files 
		$data['id'] = $page_id;
   	    	$data['is_admin'] = $admin;
	
			
		if($page_id) //If we have this, then we know that the user is logged in and viewing the app through a Facebok page
		{	
			// If the user is a page administrator, display the admin view
			if($admin == '1')
			{
				$data ['currency_options'] = array('AUD' => 'AUD','BRL' => 'BRL','GBP' => 'GBP','CAD' => 'CAD','CZK' => 'CZK','DKK' => 'DKK',
		                  				'EUR' => 'EUR','HKD' => 'HKD','HUF' => 'HUF','ILS' => 'ILS','JPY' => 'JPY','MXN' => 'MXN',
	   					                'TWD' => 'TWD','NZD' => 'NZD','NOK' => 'NOK','PHP' => 'PHP','PLN' => 'PLN','SGD' => 'SGD',
								'SEK' => 'SEK','CHF' => 'CHF','THB' => 'THB','USD' => 'USD',
								);
				
			        //If the admin has already added used the app and been added to db, load the administrator view
			        if($this->Create->get_tab_data($page_id))
			        {
			        
			           $data['db'] = $this->Create->get_tab_data($page_id); // Get the data the user had previously entered
   	    			   $db = $data['db'];
   	    			   $data['currency'] = $db['currency'];
			           $this->load->view('tab/tab_admin', $data);
			        }			        
			        else //Add the admin's id and the page's id to the db and then load a setup app view
			        {
				   //put admin's info in db
				   $admin_data = array('page_id' => $page_id,'fb_id' => $user_id);
				   $this->Create->insert_admin($admin_data);
					  					  					 
				   //load admin view
				   $this->load->view('tab/tab_admin_create', $data);
			        }   						
			}
			
			
			else //Send everyone else to the public view of the tab
			{ 
				
				//Get the page's data from db
				$tab_data = $this->Create->get_tab_data($page_id);

				if($tab_data) //This app has been used by the page admin
				{
		    			$data['message'] = $tab_data['message']; //Message added by admin
		    			$data['admin'] = $admin;
		    			   				
					$this->load->view('tab/tab_public', $data);
				}
				else // Load a view saying the app is not set up yet
				{	
					$error = $this->lang->line('common_tab_not_set');
					$data = array(
							'error' => $error,
							'page_id' => $page_id,
							);
					$this->load->view('tab/tab_error', $data);
				}
			}
		}
		else //The user is not logged in. Show them an error page
		{
			$error = $this->lang->line('common_not_logged_in');
			$data = array(
					'error' => $error,
					'page_id' => $page_id,
					);
			$this->load->view('tab/tab_error', $data);
		}		
		


	}
	
	function create() // Get the admin user's information and enter it into the database so that we can display their tab to the public
	{
		// Get the data was stored in our session in the index
		$admin = $this->db_session->userdata('is_admin');
		$page_id = $this->db_session->userdata('page_id');
		$app_id = $this->db_session->userdata('app_id');
	        $db = array(
	        	'email'=>'',
	        	'page_name'=>'',
	        	'page_heading'=>'',
	        	'message'=>''
	        );

		if($admin == 1 && $page_id) //Proceed knowing that we have a logged-in administrator viewing the app from a page
		{				
			 
			// Get the user's email, org name, currency, and tab message from a form in view->'create'
			$email = html_purify($this->input->post('email'));
			$currency = html_purify($this->input->post('currency'));
			$page_name = html_purify($this->input->post('page_name'));
			$page_heading = html_purify($this->input->post('page_heading'));
			$message = html_purify($this->input->post('message'));
			 
		
			// Put the admin's data into an array to be added to the database or reloaded in the view file
				$page_data = array(
					'page_id'=>$page_id,
					'email'=>$email,
					'currency'=>$currency,
					'page_name'=>$page_name,
					'page_heading'=>$page_heading,
					'message'=>$message,
					'app_id'=>$app_id,
					'db'=>$db		
				);
			$page_data ['currency_options'] = array('AUD' => 'AUD','BRL' => 'BRL','GBP' => 'GBP','CAD' => 'CAD','CZK' => 'CZK','DKK' => 'DKK',
		                  				'EUR' => 'EUR','HKD' => 'HKD','HUF' => 'HUF','ILS' => 'ILS','JPY' => 'JPY','MXN' => 'MXN',
	   					                'TWD' => 'TWD','NZD' => 'NZD','NOK' => 'NOK','PHP' => 'PHP','PLN' => 'PLN','SGD' => 'SGD',
								'SEK' => 'SEK','CHF' => 'CHF','THB' => 'THB','USD' => 'USD',
								);
			

		// Validate the user's input from a form in view->'create' ------------------------------------------
	
		   /// If there is a validation error, reload the form
			if($this->form_validation->run('create') == FALSE) //validation rules in validation config file
			{
			 $this->load->view("tab_admin_create", $page_data);			 			 
			}		    
			// Validation success! Insert the user's data into the database and load a success page			 
			else if($this->Create->insert_user($page_data))
 			{
			  $this->load->view('tab/tab_public_admin',$page_data);
			}			 
		 	  
		}
		else  // This user is not an admin or not logged in.  Show error page.
		{
			$data['error'] = $this->lang->line('common_error_general');
 			$this->load->view('tab/tab_error', $data);
		}
	}
	
	function edit_tab() // Updates database after admin makes changes
	{
		// Get the data was stored in our session in the index
		$admin = $this->db_session->userdata('is_admin');
		$page_id = $this->db_session->userdata('page_id');							
		$app_id = $this->db_session->userdata('app_id');
		
		// Get the data the user had previously entered
		$db = $this->Create->get_tab_data($page_id);						
		
		if($admin == 1 && $page_id)
		{
			// Get the user's email, org name, currency, and tab message from a form in view->tab_create
			$email = html_purify($this->input->post('email'));
			$currency = html_purify($this->input->post('currency'));
			$page_name = html_purify($this->input->post('page_name'));
			$page_heading = html_purify($this->input->post('page_heading'));
			$message = html_purify($this->input->post('message'));
			 
		
			// Put the admin's data into an array to be added to the database or reloaded in the view file
				$page_data = array(
					'page_id'=>$page_id,
					'email'=>$email,
					'page_name'=>$page_name,
					'page_heading'=>$page_heading,
					'message'=>$message,
					'app_id'=>$app_id,
					'currency'=>$db['currency'],
					'db'=>$db	
				);
			$page_data ['currency_options'] = array('AUD' => 'AUD','BRL' => 'BRL','GBP' => 'GBP','CAD' => 'CAD','CZK' => 'CZK','DKK' => 'DKK',
		                  				'EUR' => 'EUR','HKD' => 'HKD','HUF' => 'HUF','ILS' => 'ILS','JPY' => 'JPY','MXN' => 'MXN',
	   					                'TWD' => 'TWD','NZD' => 'NZD','NOK' => 'NOK','PHP' => 'PHP','PLN' => 'PLN','SGD' => 'SGD',
								'SEK' => 'SEK','CHF' => 'CHF','THB' => 'THB','USD' => 'USD',
								);	 
			
			// If there is a validation error, reload the form
			if($this->form_validation->run('create') == FALSE)
			{
			  $this->load->view('tab/tab_admin', $page_data);			 
			}
		        
			// Validation success! Insert the user's data into the database and load a success page
			else
			{
				if($this->Create->updater($page_data, $page_id))
			 	{  
				   $this->load->view('tab/tab_public_admin', $page_data);
			 	}
				else {echo "Sorry. Unable to save to database.";}
			}
 		}
   		else
 		{
 			$error = $this->lang->line('common_error_general');
			$data = array(
					'error' => $error,
					);
 			$this->load->view('tab/tab_error', $data);
 		}
    		 
		 
	}
	
}