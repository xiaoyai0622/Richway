<?php

$wp_root = dirname(__FILE__) .'/../../../../../../';

if(file_exists($wp_root . 'wp-load.php')) {
	require_once($wp_root . "wp-load.php");
} else if(file_exists($wp_root . 'wp-config.php')) {
	require_once($wp_root . "wp-config.php");
} else {
	exit;
}

if(!isset($_POST['company-post-type'])) exit(0);
$type = $_POST['company-post-type'];


header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=import_".$type.".csv");
header("Pragma: no-cache");
header("Expires: 0");

function outputCSV($data) {
	$outstream = fopen("php://output", 'w');
	function __outputCSV(&$vals, $key, $filehandler) {
		fputcsv($filehandler, $vals, ';', '"');
	}
	array_walk($data, '__outputCSV', $outstream);
	fclose($outstream);
}

unset($_POST['company-post-type']);
unset($_POST['company-metrodir-type']);

$data = array();
// ms office fix line
$data[0] = array('sep=;');
$data[1] = array_keys($_POST);

outputCSV($data);