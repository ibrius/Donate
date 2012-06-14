<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| ------------------------------------------------------------------
|  Facebook App Setings
| ------------------------------------------------------------------
|
*/

$config['fb_config'] = array(
				'appId'  => 'YOUR_APP_ID',
				'secret' => 'YOUR_APP_SECRET',
				'url' => 'https://apps.facebook.com/YOUR_APP_NAMESPACE/', //With trailing slash "/" . Only needed for tab apps
				'fileUpload' => false, // Indicates if the CURL based @ syntax for file uploads is enabled.
				);
				
$config['fb_errors'] = TRUE; //Show graph api errors for calls made to the objects set here.


/*
|-------------------------------------------------------------------
| Use Access Token
|-------------------------------------------------------------------
| If you only need a couple of user objects that don't require an access token or special permissions, 
| then leave this set to false and specify what objects you want below to keep your session data smaller.
*/
$config['token_on'] = FALSE;
		
		
/**
|-------------------------------------------------------------------
| Facebook User Objects
|-------------------------------------------------------------------
|
| You can set any user object below and it will be included in your databse session so that it is always available.
| The objects will be stored in an array in $fb_data['profile']
|
| To include an object, make the value equal the key: Eg. 'name' => 'name' 
| To exclude an object, leave the value blank: Eg. 'name' => ''
|
| Most objects will be automatically returned without the need to set them if you set token_on to TRUE
|
| For more information about the structure of each of these object see:
| https://developers.facebook.com/docs/reference/api/user/
|
**/
$config['user_objects'] = array(
				'id'  => 'id',
				'name' => 'name',
				'link' => 'link',
				'first_name' => '',
				'middle_name' => '',
				'last_name' => '',
				'gender' => '',
				'locale' => '',
				'timezone' => '',
				'username' => '',
				'cover' => '',
				'picture' => '',
				'email' => '',	 				//Requires email permission
				'hometown' => '', 				//Requires user_hometown permission
				'birthday' => '',				//Requires user_birthday permission
				'bio' => '',					//Requires user_about_me permission
				'quotes' => '',					//Requires user_about_me permission
				'languages' => '',				//Requires user_likes permission
				'location' => '',				//Requires user_location permission
				'relationship_status' => '', 	//Requires user_relationships permission
				'significant_other' => '',		//Requires user_relationships permission
				'interested_in' => '',			//Requires user_relationship_details permission
				'political' => '',				//Requires user_religion_politics permission
				'religion' => '',				//Requires user_religion_politics permission
				'education' => '',				//Requires user_education_history permission
				'work' => '',					//Requires user_work_history permission
				'website' => '',				//Requires user_website permission
				'updated_time' => '',			//Requires that that you set token_on to TRUE above
				'verified' => '',				//Requires that that you set token_on to TRUE above
				'third_party_id' => '', 		//Requires that that you set token_on to TRUE above
				'video_upload_limits' => '',	//Requires that that you set token_on to TRUE above
				);