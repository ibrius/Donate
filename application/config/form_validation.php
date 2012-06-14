<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
               
   'create' => array(                  
               array(
                     'field'   => 'email', 
                     'label'   => 'lang:common_email', 
                     'rules'   => 'required|valid_email|min_length[6]|max_length[30]|xss_clean|htmlspecialchars|strip_tags'
                  ),
               array(
                     'field'   => 'page_name', 
                     'label'   => 'lang:common_page_name', 
                     'rules'   => 'required|min_length[1]|max_length[30]|alpha_spaces|xss_clean|htmlspecialchars|strip_tags'
                  ),
                  array(
                     'field'   => 'message', 
                     'label'   => 'lang:common_message', 
                     'rules'   => 'required'
                  ),
                  array(
                     'field'   => 'currency', 
                     'label'   => 'lang:common_currency', 
                     'rules'   => 'required'
                  ),
                   array(
                     'field'   => 'page_heading', 
                     'label'   => 'lang:common_tab_headline', 
                     'rules'   => 'required|alpha_spaces'
                  )
               )
               
            );
            