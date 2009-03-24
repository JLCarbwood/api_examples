<?php
	ini_set("include_path", ".:../:./include:../include:/Users/motske/src/PEAR");
	require_once 'Crypt/HMAC.php';
	
	function __autoload($class_name) {
	    require_once $class_name . '.php';
	}

	$fields = array();
	$fields['api_key'] = '3jaZJQjVmPw87zMFdUNP';
	$fields['username'] = 'kevin_test #1_xjZ2f6m7';
	$fields['target_gateway'] = '2';
	
	$fields['account_number'] = '5454545454545454';
	$fields['expiration_month'] = '10';
	$fields['expiration_year'] = '2010';
	
	$fields['bill_address1'] = '123 First St.';
	$fields['bill_city'] = 'Farmington';	
	$fields['bill_country'] = 'USA';
	$fields['bill_first_name'] = 'Bob';
	$fields['bill_last_name'] = 'Smith';		
	$fields['bill_phone'] = '8015551212';
	$fields['bill_state'] = 'Utah';
	$fields['bill_zip'] = '84103';
	$fields['email'] = 'test@test.com';

	# Optional shipping address
	$fields['ship_address1'] = '123 First St.';
	$fields['ship_city'] = 'Farmington';	
	$fields['ship_country'] = 'USA';
	$fields['ship_first_name'] = 'Bob';
	$fields['ship_last_name'] = 'Smith';		
	$fields['ship_phone'] = '8015551212';
	$fields['ship_state'] = 'Utah';
	$fields['ship_zip'] = '84103';
	
	$fields['order_items'] = array();
	$fields['order_items'][0] = array();
	$fields['order_items'][0]['description'] = "Item 1";
	$fields['order_items'][0]['cost'] = "1.00";
	$fields['order_items'][0]['qty'] = "1";	
	$fields['order_items'][1] = array();
	$fields['order_items'][1]['description'] = "Item 2";
	$fields['order_items'][1]['cost'] = "2.00";
	$fields['order_items'][1]['qty'] = "2";

	$fields['email_text'] = array();
	$fields['email_text'][0] = "Email Text 1";
	$fields['email_text'][1] = "Email Text 1";
	
	$fields['send_customer_email'] = "TRUE";
	$fields['send_merchant_email'] = "TRUE";
	$fields['test_mode'] = "FALSE";
	
	$xml_request = new CardAuthRequest($fields);
	$xml = $xml_request->toXML();
	
	echo "XML Request=" . $xml . "\n\n";
	
	$response = $xml_request->submit("https://dev.itransact.com/cgi-bin/rc/xmltrans2.cgi", $xml);

	echo "XML Response=" . $response->responseXML . "\n\n";
	
	if(stristr($response->status(), 'fail')) {
		echo "Response Failed:\n";
		echo "  ErrorCategory:" . $response->errorCategory() . "\n";
		echo "  ErrorMessage:" . $response->errorMessage() . "\n";		
	} else if ($response->status() == "ERROR") {
		echo "Response Error:\n";
		echo "  ErrorCategory:" . $response->errorCategory() . "\n";
		echo "  ErrorMessage:" . $response->errorMessage() . "\n";		
	} else if (stristr($response->status(), 'ok')) {
		echo "Response OK:\n";
		echo "  AuthCode:" . $response->authCode() . "\n";
		echo "  AVSCategory:" . $response->avsCategory() . "\n";
		echo "  AVSResponse:" . $response->avsResponse() . "\n";
		echo "  CVV2Response:" . $response->cvv2Response() . "\n";
		echo "  XID:" . $response->xid() . "\n";
	}

?>