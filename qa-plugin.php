<?php
/*
	Plugin Name: Tag Experts
	Plugin URI: https://github.com/stanhuan/q2a-tag-experts
	Plugin Description: Displays the top users for a specific tag
	Plugin Version: 1.0
	Plugin Date: 2017-04-25
	Plugin Author: Stanley Huang
	Plugin Author URI: http://stanhuan.com
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.5
	Plugin Update Check URI: https://raw.githubusercontent.com/stanhuan/q2a-tag-experts/master/qa-plugin.php

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.gnu.org/licenses/gpl.html
	
*/

if ( !defined('QA_VERSION') )
{
	header('Location: ../../');
	exit;
}

// page
qa_register_plugin_module(
	'widget', // type of module
	'qa-tag-experts-widget.php', // PHP file containing module class
	'qa_tag_experts_widget', // module class name in that PHP file
	'Tag Experts' // human-readable name of module
);
qa_register_plugin_phrases(
	'qa-tag-experts-lang-*.php', 'tag_experts_lang');  
qa_register_plugin_module('module', 'qa-tag-experts-admin.php', 'qa_tag_experts_admin', 'Tag Experts');
qa_register_plugin_layer('qa-tag-experts-layer.php', 'Tag Experts Layer');

/*
	Omit PHP closing tag to help avoid accidental output
*/