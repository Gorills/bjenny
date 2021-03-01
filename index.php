<?php
ini_set('display_errors', 1); ini_set('og_errors', 1); error_reporting(E_ALL);
ini_set("memory_limit", "512M");
// Version
define('VERSION', '3.0.2.0');

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('catalog');