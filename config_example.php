<?php
require_once 'vendor/autoload.php';

return [
	'enemy_repo_file' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'parts_example.json',
	'billboard'       => [
		'base'        => __DIR__ . DIRECTORY_SEPARATOR . 'base.png',
		'font'        => __DIR__ . DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR . 'OpenSans-ExtraBold.ttf',
		'color_title' => 'BE1B14',
		'color_enemy' => 'FFFFFF',
		'title'       => 'A mai ellenségünk:',
		'save_to'     => __DIR__ . DIRECTORY_SEPARATOR . 'image'
	],
	'spreadsheet' => [
		'app_secret' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'client_secret.json',
		'token_file' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'gat.json',
		'id'         => 'xyz',
		'range'      => 'Sheet1!A:C',
	],
	'facebook_app_id' => '111',
];