<?php

require_once  'include/common.php';	
/*ini_set("error_reporting", E_ALL);
ini_set("display_errors", 1);*/

if(isset($_REQUEST["action"]) && !empty($_REQUEST["action"])){
	extract($_REQUEST);

	switch ($action) {


		case 'getPartner':	
			
			if($partner_type=='approved')
				$type=1;
			elseif($partner_type=='rejected')
				$type=2;
			elseif($partner_type=='pending')
			 	$type=3;
			else 
				$type="";

			 $partnerData=$anshin->getPartner("","",$type);
				
			echo json_encode($partnerData);
			
		break;

		case 'approve':	
		case 'reject':
		case 'pending':


			if($action == 'approve'){
				$part_status=1;
				$status="Approved";
				$status_class="label-success";
				$message='Approved Successfully';
			}elseif ($action == 'reject') {
				$part_status=2;	
				$status="Rejected";
				$status_class="label-danger";
				$message='Disapproved Successfully';
			}elseif ($action == 'pending'){
				$part_status=3;
				$status="Pending";
				$status_class="label-warning";
				$message='pending Successfully';
			}	

			$update_fields = array(
									'usr_user_type' => $part_status,
								  );

			$updateStatus="";
			$output="";
			$mysqli->where("usr_id", $usr_id);
			$updateStatus=$mysqli->update(TBL_USER, $update_fields);

			if($updateStatus){
				$output['code']=1;		
				$output['action']=$action;	
				$output['usr_id']=$usr_id;	
				$output['msg']=$message;	
				$output['status']=$status;	
				$output['updateStatus']=((isset($updateStatus) && !empty($updateStatus)) ? "success" : "warning");	
				$output['status_class']=$status_class;	
			}else{
				$output['code']=0;
				$output['msg']="OopS Something Went Wrong...!";	
				$output['updateStatus']='warning';
			}	
			echo json_encode($output);
			
		break;


		case 'delete':			
				
			$mysqli->where('usr_id', $usr_id);
			$response = $mysqli->delete(TBL_USER);
			$output['code']=1;	
			$output['action']=$action;	
			$output['usr_id']=$usr_id;		
			$output['msg']="Deleted Successfully";
			echo json_encode($output);
		break;

		case 'getCategory':	
			$cats="111";
			$cats=$anshin->getCategory();
			echo json_encode($cats);
		break;

		case 'add-partner':	
				
			$v = new Validator($_REQUEST);	
			$v->rule('required', ['usr_fname','usr_lname','usr_company','usr_email','usr_contactNo','usr_country','usr_state','usr_city','usr_pincode','usr_password']);
			$v->rule('email', 'usr_email');	
			$v->rule('integer', 'usr_contactNo');	
			$v->rule('integer', 'usr_altcontactNo');	
			$v->rule('integer', 'usr_pincode');	
			$v->rule('lengthMax', 'usr_contactNo', 11);	
			$v->rule('lengthMin', 'usr_contactNo', 10);	
			$v->rule('lengthMax', 'usr_altcontactNo', 11);	
			$v->rule('lengthMin', 'usr_altcontactNo', 10);	
			
			$v->labels(array(	          
	          'usr_fname' => 'First Name',
	          'usr_lname' => 'Last Name',
	          'usr_company' => 'Company',
	          'usr_email' => 'Email address',
	          'usr_contactNo' => 'Contact No.',
	          'usr_altcontactNo' => 'Alt. Contact No.',
	          'usr_country' => 'Country',
	          'usr_state' => 'State',
	          'usr_city' => 'City',
	          'usr_pincode' => 'Pincode',
	          'usr_password' => 'Password'
	        ));



	        if($v->validate()) {
	        	
				$data="";
				$password="";
				$password = $crypt->encrypt(ENCRYPT_KEY, $usr_password, ENCRYPT_PASSWORD_LENGTH);

				$data['usr_fname']=(isset($usr_fname) && !empty($usr_fname) ? $usr_fname : "");
				$data['usr_lname']=(isset($usr_lname) && !empty($usr_lname) ? $usr_lname : "");
				$data['usr_company']= (isset($usr_company) && !empty($usr_company) ? $usr_company : ""); 
				$data['usr_email']=(isset($usr_email) && !empty($usr_email) ? $usr_email : "");
				$data['usr_password']=$password;
				$data['usr_contactNo']=(isset($usr_contactNo) && !empty($usr_contactNo) ? $usr_contactNo : "");
				$data['usr_altcontactNo']=(isset($usr_altcontactNo) && !empty($usr_altcontactNo) ? $usr_altcontactNo : "");
				$data['usr_address']=(isset($usr_address) && !empty($usr_address) ? $usr_address : "");
				$data['country_id']=$usr_country;	
				$data['geo_id']=$usr_state;	
				$data['city_id']=$usr_city;	
				$data['usr_pincode']=(isset($usr_pincode) && !empty($usr_pincode) ? $usr_pincode : "");
				$data['usr_remarks']=(isset($usr_remarks) && !empty($usr_remarks) ? $usr_remarks : "");
				$data['usr_user_type']=(isset($usr_user_type) && !empty($usr_user_type) ? $usr_user_type : "");
				$data['usr_status']=1;
				$data['usr_insert_time']= strtotime("now");

				$partnerId="";
				$op="";
				$userType="";
				$partnerId = $mysqli->insert(TBL_USER,$data);

				if($usr_user_type == 5 )
					  $userType="Admin";
				elseif ($usr_user_type == 4 ) 
					  $userType="End User";	
				else
					$userType="Partner";

				if(isset($partnerId) && !empty($partnerId)){
					$op['code']=1;
					$op['status']="success";
					$op['msg']=$userType." Added SuccessFully.";
					
				}else{
						$op['code']=0;
						$op['status']="warning";
						$op['msg']="OopS Something Went Wrong...!";
						
					}

				echo json_encode($op);	

			}else {
			    // Errors
			    $error=$errorMsg = "";
		        foreach($v->errors() as $key => $value){
		        	$errorMsg.=implode("<br />",$value);
		        	$errorMsg.="<br />";
		        } 

		        $error['msg']=$errorMsg;	
		        $error['code']=0;	
		        $error['status']="warning";	
		        echo json_encode($error);
			}

		break;



		case 'edit-partner':
			$v = new Validator($_REQUEST);	
			$v->rule('required', ['usr_fname','usr_lname','usr_company','usr_email','usr_contactNo','usr_country','usr_state','usr_city','usr_pincode','usr_password']);
			$v->rule('email', 'usr_email');	
			$v->rule('integer', 'usr_contactNo');	
			$v->rule('integer', 'usr_altcontactNo');	
			$v->rule('integer', 'usr_pincode');	
			$v->rule('lengthMax', 'usr_contactNo', 11);	
			$v->rule('lengthMin', 'usr_contactNo', 10);	
			$v->rule('lengthMax', 'usr_altcontactNo', 11);	
			$v->rule('lengthMin', 'usr_altcontactNo', 10);	
			
			$v->labels(array(	          
	          'usr_fname' => 'First Name',
	          'usr_lname' => 'Last Name',
	          'usr_company' => 'Company',
	          'usr_email' => 'Email address',
	          'usr_contactNo' => 'Contact No.',
	          'usr_altcontactNo' => 'Alt. Contact No.',
	          'usr_country' => 'Country',
	          'usr_state' => 'State',
	          'usr_city' => 'City',
	          'usr_pincode' => 'Pincode',
	          'usr_password' => 'Password'
	        ));



	        if($v->validate()) {
	        	
				$data="";
				$password="";
				if($usr_password_changed == 1) {
					$password = $crypt->encrypt(ENCRYPT_KEY, $usr_password, ENCRYPT_PASSWORD_LENGTH); 
				}else{
					$password = $usr_password; 
				}	
				$data['usr_fname']=(isset($usr_fname) && !empty($usr_fname) ? $usr_fname : "");
				$data['usr_lname']=(isset($usr_lname) && !empty($usr_lname) ? $usr_lname : "");
				$data['usr_company']= (isset($usr_company) && !empty($usr_company) ? $usr_company : ""); 
				$data['usr_email']=(isset($usr_email) && !empty($usr_email) ? $usr_email : "");
				$data['usr_password']=$password;
				$data['usr_contactNo']=(isset($usr_contactNo) && !empty($usr_contactNo) ? $usr_contactNo : "");
				$data['usr_altcontactNo']=(isset($usr_altcontactNo) && !empty($usr_altcontactNo) ? $usr_altcontactNo : "");
				$data['usr_address']=(isset($usr_address) && !empty($usr_address) ? $usr_address : "");
				$data['country_id']=$usr_country;	
				$data['geo_id']=$usr_state;	
				$data['city_id']=$usr_city;	
				$data['usr_pincode']=(isset($usr_pincode) && !empty($usr_pincode) ? $usr_pincode : "");
				$data['usr_remarks']=(isset($usr_remarks) && !empty($usr_remarks) ? $usr_remarks : "");
				$data['usr_user_type']=(isset($usr_user_type) && !empty($usr_user_type) ? $usr_user_type : "");
				$data['usr_status']=1;
				$data['usr_insert_time']= strtotime("now");

				$partnerId="";
				$op="";
				$userType="";
				$updateStatus="";
				
				$mysqli->where("usr_id", $user_id);
				$updateStatus=$mysqli->update(TBL_USER, $data);
				
				if($usr_user_type == 5 )
					  $userType="Admin";
				elseif ($usr_user_type == 4 ) 
					  $userType="End User";	
				else
					$userType="Partner";

				if(isset($updateStatus) && !empty($updateStatus)){
					$op['code']=1;
					$op['status']="success";
					$op['msg']="User Updated SuccessFully.";
					
				}else{
						$op['code']=0;
						$op['status']="warning";
						$op['msg']="OopS Something Went Wrong...!";
						
					}

				echo json_encode($op);	

			}else {
			    // Errors
			    $error=$errorMsg = "";
		        foreach($v->errors() as $key => $value){
		        	$errorMsg.=implode("<br />",$value);
		        	$errorMsg.="<br />";
		        } 

		        $error['msg']=$errorMsg;	
		        $error['code']=0;	
		        $error['status']="warning";	
		        echo json_encode($error);
			}	


		break;

		case 'changedCountry':
			  $stateData="";
			  $stateData=$anshin->getState("","",$usr_country_id);

			  if($stateData)
			   {	 	
			  	echo json_encode($stateData);	
			   }else{
			   	echo json_encode("");
			   }
			   
		break;

		case 'changedState':
			  $cityData="";
			  $cityData=$anshin->getCity("","",$usr_state_id);

			  if($cityData)
			   {	 	
			  	echo json_encode($cityData);	
			   }else{
			   	echo json_encode("");
			   }
			   
		break;

	}
}

?>