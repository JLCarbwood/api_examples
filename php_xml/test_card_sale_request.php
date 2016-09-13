<?php
	function __autoload($class_name) {
	    require_once $class_name . '.php';
	}

	# Search this file for the term 'FILL IN' and provide the 
	# requested information.  There are some additional comments
	# inline that show how to pass through recurring information 
	# as well as different ways to pass order items.

	$fields = array();
	$fields['api_key'] = 'FILL IN YOUR KEY';
	$fields['username'] = 'FILL IN YOUR USERNAME';
	$fields['target_gateway'] = 'FILL IN YOUR GATEWAY ID';
	
	$fields['account_number'] = '5454545454545454';
	$fields['expiration_month'] = '05';
	$fields['expiration_year'] = '2010';
	
	$fields['bill_address1'] = '123 First St.';
	$fields['bill_city'] = 'Farmington';	
	$fields['bill_country'] = 'USA';
	$fields['bill_first_name'] = 'Bob';
	$fields['bill_last_name'] = 'Smith';		
	$fields['bill_phone'] = '8015551212';
	$fields['bill_state'] = 'Utah';
	$fields['bill_zip'] = '84103';
	$fields['email'] = 'FILL IN SOME VALID EMAIL ADDRESS';
	$fields['customer_id'] = '12345';

	# Optional shipping address
	$fields['ship_address1'] = '123 First St.';
	$fields['ship_city'] = 'Farmington';	
	$fields['ship_country'] = 'USA';
	$fields['ship_first_name'] = 'Bob';
	$fields['ship_last_name'] = 'Smith';		
	$fields['ship_phone'] = '8015551212';
	$fields['ship_state'] = 'Utah';
	$fields['ship_zip'] = '84103';

	# You can either use a set of order items (like below)	
	$fields['order_items'] = array();
	$fields['order_items'][0] = array();
	$fields['order_items'][0]['description'] = "Item 1";
	$fields['order_items'][0]['cost'] = "1.00";
	$fields['order_items'][0]['qty'] = "1";	
	$fields['order_items'][1] = array();
	$fields['order_items'][1]['description'] = "Item 2";
	$fields['order_items'][1]['cost'] = "2.00";
	$fields['order_items'][1]['qty'] = "2";

	# Or just pass in a total and description	
	# $fields['total'] = "2.00";
	# $fields['description'] = "Order Description";

	# If you want to setup recurring transactions uncomment this section
	# $fields['recur_total'] = "1.00";
	# $fields['recur_description'] = "Recurring Description";
	# $fields['recur_recipe'] = "3months";
	# $fields['recur_reps'] = "9999";

	# You may provide up to 10 email text items.  These are not saved
	# permanently
	
	$fields['email_text'] = array();
	$fields['email_text'][0] = "Email Text 1";
	$fields['email_text'][1] = "Email Text 1";
	
	$fields['send_customer_email'] = "TRUE";
	$fields['send_merchant_email'] = "FALSE";
	$fields['test_mode'] = "TRUE";
	
	$xml_request = new CardAuthRequest($fields);
	$xml = $xml_request->toXML();
	
	echo "XML Request=" . $xml . "\n\n";
	
	$response = $xml_request->submit("https://secure.paymentclearing.com/cgi-bin/rc/xmltrans2.cgi", $xml);

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
