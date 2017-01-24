<?php
	define( "_29h9xwpHzQWKK6U3ov54noaKk1YASDBhrNPg", 1);
 	require('include/_data.php');
        require('include/config.php');

	if(basename($_SERVER["SCRIPT_NAME"])!='index.php') {
		$dir = $_SERVER["SCRIPT_NAME"];
		$dir = substr($dir, 0, -1);
	} else {
		$dir = dirname($_SERVER["SCRIPT_NAME"]);
	}	
	
	$path = explode('/',$dir);
	unset($path[sizeof($path)-1]);
	$dirname = implode('/', $path);
	define('ADRES', 'http://'.$_SERVER["HTTP_HOST"].$dirname.'/');

	
	session_start();
        require('include/functions.php');
        require_once('include/twitteroauth/twitteroauth.php');
        
        
        $lang = generate_lang(isset($_SESSION['lang'])?$_SESSION['lang']:'');
        require("languages/$lang.php");
 	
	polacz_z_baza($link);
	
 	mysql_query("SET NAMES utf8");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET SESSION collation_connection='utf8_general_ci'");
        
	if(!zalogowany()) {
                $category = 'cms';
	} else {
            if(isset($_GET['category'])) $category = $_GET['category']; else $category = '';
            if(empty($category) && isset($_POST['category'])) $category = $_POST['category'];
            if(empty($category) && isset($_SESSION['category'])) $category = $_SESSION['default_controller'];
	}
        
        if(!file_exists('controllers/'.$category.'.php')) {
            $category  = include_default(true);
        }

        
        $filename = 'controllers/'.$category.'.php';
        include($filename);

	
	rozlacz_z_baza($link);
?>