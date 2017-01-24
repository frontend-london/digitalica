<?php

        define( "_27MMmPsKneKT6sWaOA33dqklg0OuF6sHzwV", 1);
	
	session_start();
	
 	require('include/_data.php');
        require('include/config.php');
 	require('include/functions.php');

	polacz_z_baza($link);

        $t['title'] = '';
        $t['description'] = '';
	
 	mysql_query("SET NAMES utf8");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET SESSION collation_connection='utf8_general_ci'");
	
	$directory = substr($_SERVER["SCRIPT_NAME"], 0, -strlen('index.php'));

	$path = explode('/',$directory);
	unset($path[sizeof($path)-1]);
	$dirname = implode('/', $path);
	
	$full_url = trim(substr($_SERVER["REQUEST_URI"], strlen($directory)), '/');
        $url = $full_url;
        $second_url = substr(strstr($url, '/'), 1);
        if(strpos($second_url, '/')>0) {
            $third_url = substr($second_url, strpos($second_url,'/')+1);
            $second_url = substr($second_url,0,strpos($second_url,'/'));
        }
        
        if(strpos($url, '/')) $url = substr($url, 0, strpos($url, '/'));

	if($url=='') {
		$url = 'home';
	}
        


	$filename = 'controllers/'.$url.'.php';
	if(!file_exists($filename)) {
		$url = '404';
		$filename = 'controllers/'.$url.'.php';
	}

        include('controllers/include/rightside.php');
	include($filename);

	rozlacz_z_baza($link);
?>