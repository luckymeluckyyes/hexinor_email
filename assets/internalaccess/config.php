<?php
//error_reporting(E_ERROR | E_PARSE);
error_reporting(0);
header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Europe/Rome');

//...........Database Constants.................

	define ("HOST","localhost");

	define ("USER","root");

	define ("PASSWORD","");

	define ("DATABASE","hexinor_demo");

//..........database connection............

	
	function mysqlConncet(){
		//return $db = mysql_connect(HOST, USER, PASSWORD,DATABASE);
		$db = mysql_connect(HOST,USER,PASSWORD);
		$kss= mysql_select_db(DATABASE,$db);  

		if($kss)
		{
			echo "connection";
		}
		
		
	}

	function mysqlQuery($connection,$query){
		return $query_res = mysql_query($query);
	}

	function myasqlNumRow($result){
		return $res_row = mysql_num_rows($result);
	}
	
	function mysqlFetchArray($array_res){
		return $res_array = mysql_fetch_array($array_res);
	}
	
	function mysqlLastId($qry){
		//return mysql_insert_id($qry);
		return mysql_insert_id();
	}
	
	function mysqlRealescapestring($connection,$value){
		return mysql_real_escape_string($value);
	}
	
	$conn = mysqlConncet();
	$admin_detail_qry_var = "SELECT aa_username, aa_password, aa_email FROM aq_admin WHERE aa_id='1'";
	$admin_detail_qry = mysqlQuery($conn,$admin_detail_qry_var);
	$admin_detail = mysqlFetchArray($admin_detail_qry);
	
	
	
     mysql_set_charset("UTF8", $db);
	 mysql_query("SET @@session.time_zone = '+5:30'") or die(mysql_error());
	 
	define("SITE_URL","webz7/appquiz/");
	define("ADMIN_URL",SITE_URL.'admin/');
	define("ADMIN_USERNAME",$admin_detail['aa_username']);
	define("ADMIN_EMAIL",$admin_detail['aa_email']);
	
?>
