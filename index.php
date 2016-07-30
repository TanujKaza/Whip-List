<?php
ob_start();
session_start();

   	if($_GET['action'] == 'logout')
   	{
   		setcookie('username', "", time()-60*60*24*365, "/");
        setcookie('access_token', "", time()-60*60*24*365, "/"); 
        header('Location:index.php'); exit;
   	}

    //***************Google Authentication starts*************

    require_once ('GoogleAuth/libraries/Google/autoload.php');


    //Insert your cient ID and secret 
    //You can get it from : https://console.developers.google.com/

    /*$client_id = '243653284497-pdrk0frhvtf1pkk93u4133cn3o3c4q32.apps.googleusercontent.com'; 
    $client_secret = 'DxPvh7Y4Stjbm4pw69PONT0T';*/
	$client_id = '243653284497-li33r3j9ihaibkq6se883a8sd3nft5u5.apps.googleusercontent.com'; 
    $client_secret = 'g0ASwDe4WcBtNC4zKK84C_ky';

    //$redirect_uri = 'http://login.pinstorm.com';
    $redirect_uri = 'http://tools.pinstorm.com/whiplist/index.php';

    //database
    $host_name = "52.35.237.104"; //Mysql Hostname
    $db_username = "cmsmanager"; //Database Username
    $db_password = "kUsaf2dey8"; //Database Password
    $db_name = 'campaigns'; //Database Name


    /************************************************
    Make an API request on behalf of a user. In
    this case we need to have a valid OAuth 2.0
    token for the user, so we need to send them
    through a login flow. To do this we need some
    information from our API console project.
    ************************************************/
    $client = new Google_Client();
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($redirect_uri);
    $client->addScope("email");
    $client->addScope("profile");

    /************************************************
    When we create the service here, we pass the
    client to it. The client then queries the service
    for the required scopes, and uses that when
    generating the authentication URL later.
    ************************************************/
    $service = new Google_Service_Oauth2($client);

    /************************************************
    If we have a code back from the OAuth 2.0 flow,
    we need to exchange that with the authenticate()
    function. We store the resultant access token
    bundle in the session, and redirect to ourself.
    */

     //echo '<pre>';
    // print_r($service);exit;

    // session_destroy();exit;

    // echo '<pre>hhh';
     //print_r($_COOKIE);exit;

    if (isset($_GET['code'])) {

        //*****Authenticated by google starts*****
        $client->authenticate($_GET['code']);
        //*****Authenticated by google ends*****

        //*****Authenticated by us from out db starts*****

        $user = $service->userinfo->get(); //get user info 
        $user_email =  $user->email;

        $con=mysqli_connect($host_name,$db_username,$db_password,$db_name);
        // Check connection
        if (mysqli_connect_errno())
          {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }
      

        $sql="SELECT * FROM campaigns.tblusers WHERE userName='$user_email' AND status>0 and status != 6";

        $result=mysqli_query($con,$sql);
        $row=mysqli_fetch_array($result);

        
	    if(count($row)>0){ 

            
            $logtype="Login Successful";
            /*include("ip2location.inc.php");
            $datetime=time();
            $date = mktime(0,0,0,date("m"),date("d"),date("Y"));
            $userID=$_SESSION["userIDCMS"];
            $insertLogs="INSERT INTO tbllogs VALUES ('','$userID','-1','$datetime','$date','$ip','$country','$city','$logtype')";
            mysqli_query($con,$insertLogs);*/

            /*$_SESSION["nameCMS"]=$row["name"];
            $_SESSION["userNameCMS"]=$row["userName"];
            $_SESSION["userIDCMS"]=$row["userID"];
            $_SESSION["statusCMS"]=$row["status"];
            $_SESSION["LastModifiedTimeCMS"]=$row["LastModifiedTime"];
            $_SESSION["passwordCMS"]=$_POST["password"];*/

            setcookie('username', $row["userName"], time()+60*60*24*365, "/");
            //setcookie('password', md5($_POST['password']), time()+60*60*24*365, "/"); 
            setcookie('access_token', $client->getAccessToken(), time()+60*60*24*365, "/"); 
          
            $redirect_uri='http://tools.pinstorm.com/whiplist/whiplist.php';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
            exit;
            

        }
       
        // Free result set
        mysqli_free_result($result);
        mysqli_close($con);
        
        //*****Authenticated by us from out db ends*****

    } //Code End



    /************************************************
      If we have an access token, we can make
      requests, else we generate an authentication URL.
     ************************************************/
    if (isset($_COOKIE['access_token']) && $_COOKIE['access_token']!='') {
        
        $client->setAccessToken($_COOKIE['access_token']);


    } else {
        
        $authUrl = $client->createAuthUrl();

    }

   /* echo "<pre>";
    print_r($_COOKIE);exit;*/

    $show_message='';

    if (isset($authUrl)){ 

        //show login url
    
        if($_GET['code']!=''){

            $show_message.='<h3 style="color:#000; padding:0px;">For pinstorm Use Only</h3><br/>';
            $show_message.='<a href="index.php?l=1">Logout</a>';
        }
        else{

            $show_message.='<h3 style="color:#000; padding:0px;">Login with<br>Pinstorm Gmail</h3>';
            $show_message.='<a class="login" href="' . $authUrl . '"><img src="GoogleAuth/images/google-login-button.png" /></a>';
            
        }
        
        
        
    } else {

        //If logged in then re-direct to dashboard
        $redirect_uri='http://tools.pinstorm.com/whiplist/whiplist.php';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        exit;

    }
    
    //***************Google Authentication ends*************

echo $show_message;


?>