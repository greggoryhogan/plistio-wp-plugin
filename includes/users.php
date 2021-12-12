<?php 
if ( ! defined( 'ABSPATH' ) ) {
	//exit;
}
include('../../../../wp-load.php');
require(PLISTIO_PLUGIN_DIR . '/includes/xmlapi.php');        //XMLAPI cpanel client class
$ip = "50.116.95.160";            // should be server IP address or 127.0.0.1 if local server
$email_domain ="plistio.com";
$email_user = "gregg";
$port =2083;    

//add_action('init',function() {
	if(isset($_GET['newemail'])) {
		
		
		              // cpanel secure authentication port unsecure port# 2082
		
		
		$email_pass ="greggspassword";
		$email_quota = 20;             // 0 is no quota, or set a number in mb

		$xmlapi = new xmlapi($ip);
		$xmlapi->set_port($port);     //set port number.
		$xmlapi->password_auth(CPUN, CPPW);
		$xmlapi->set_debug(0);        //output to error file  set to 1 to see error_log.
		$xmlapi->set_output('json');



		$call = array(domain=>$email_domain, email=>$email_user, password=>$email_pass, quota=>$email_quota);

		//$result = $xmlapi->api2_query(CPUN, "Email", "addpop", $call );

		print_r($result);            //show the result of your query

	}
	if(isset($_GET['remove'])) {
		$xmlapi = new xmlapi($ip);
		$xmlapi->password_auth(CPUN, CPPW);
		$xmlapi->set_port($port);
		//$xmlapi->set_debug(1);

		$args = array(
		'domain'=>$email_domain, 
		'email'=>$email_user
		);

		
		$xmlapi->set_debug(0);        //output to error file  set to 1 to see error_log.
		$xmlapi->set_output('json');

		//$result = $xmlapi->api2_query(CPUN, "Email", "delpop", $args);
		print_r($result); 
	}
//});
?>