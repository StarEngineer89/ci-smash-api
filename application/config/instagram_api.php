<?php

/*
|--------------------------------------------------------------------------
| Instagram
|--------------------------------------------------------------------------
|
| Instagram client details
|
*/

$config['instagram_client_name']	= 'Smash-Tech Marketing';
$config['instagram_client_id']		= 'fc5331b46c3a4c44b3ca406dbfa0c4f8';
$config['instagram_client_secret']	= 'ff5359fde2a94f4cb32eb73a0df150e7';
$config['instagram_callback_url']	= 'http://thesmashapp.com/';//e.g. http://yourwebsite.com/authorize/get_code/
$config['instagram_website']		= '';//e.g. http://yourwebsite.com/
$config['instagram_description']	= '';
	
/**
 * Instagram provides the following scope permissions which can be combined as likes+comments
 * 
 * basic - to read any and all data related to a user (e.g. following/followed-by lists, photos, etc.) (granted by default)
 * comments - to create or delete comments on a user’s behalf
 * relationships - to follow and unfollow users on a user’s behalf
 * likes - to like and unlike items on a user’s behalf
 * 
 */
$config['instagram_scope'] = '';

// There was issues with some servers not being able to retrieve the data through https
// If you have this problem set the following to FALSE 

$config['instagram_ssl_verify']		= TRUE;
