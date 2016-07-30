<?php
require '/var/www/vhosts/api.p1n.in/httpdocs/sdk/core/p1n-sdk.php';

/*$user = 'admin@pinstorm.com';
$pass = 'admin';*/
$error="";
// $_POST['submit'] = "" ;

/*setcookie('username', 'tanuj', time()-60*60*24*365, "/"); exit ;
*/

/*if (isset($_COOKIE['username'])) {
  if (($_COOKIE['username'] != $user) || ($_COOKIE['password'] != md5($pass))) {

  } 
  else {
      header('Location: index.php');
  }
}*/

if (isset($_POST['submit']) && !empty($_POST['submit'])) {
  if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        $txtUserName = trim(stripslashes($_POST['username']));
        $txtPassword = trim(stripslashes($_POST['password']));
        
        $pinstorm = new Pinstorm(array(
                'appId'  => 'oqC3GKO3kcevvuB7BaXujOovDSw8HRU5hw9XhX1Caf7FJJMl',
                'secret' => 'MXgx8egNTpTkO5JyLWUyuUQXzewLNVDAST718oP1NJlCO5aA'
        ));

        try{  
          $loginData = json_decode($pinstorm->api('/hrms/cms-auth', 'post', array(
          'username' => $txtUserName,
          'password' => $txtPassword  
          )),true);

        } catch (PinstormApiException $e) {
          error_log($e);
        }
        echo "<pre>";
        print_r($loginData);exit;

        /*if (($_POST['username'] == $user) && ($_POST['password'] == $pass)) {    
          if (isset($_POST['rememberme'])) {
              setcookie('username', $_POST['username'], time()+60*60*24*365, "/");
              setcookie('password', md5($_POST['password']), time()+60*60*24*365, "/");        
          } 
          else{
              setcookie('username', $_POST['username'], false, '/');
              setcookie('password', md5($_POST['password']), false, '/');
          }
          header('Location: index.php');
          
      } 
      else{
          $error = 'Wrong username or password';
      }*/
  } 
  else{
    $error='You must supply a username as well as a password.';
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Whip List</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Loading Bootstrap -->
  <link href="css/bootstrap.css" rel="stylesheet">

  <!-- Loading Stylesheets -->    
  <link href="css/style.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">
  <link href="css/mystyle.css" rel="stylesheet">
  <!-- Loading Custom Stylesheets -->    
  <link href="css/custom.css" rel="stylesheet">

  <link rel="shortcut icon" href="images/favicon.ico">

    </head>
    <body >
   
<section id="register">
  <div class="row animated fadeILeftBig">
   <div class="login-holder col-md-6 col-md-offset-3">
     <h2 class="page-header text-center text-primary"> Welcome to Whip List </h2>
     <h5>
     <?php 
     if(isset($error) && !empty($error)) 
            {
              echo $error ;  
              }
                 ?>
       
     </h5>
     <form role="form" action="" method="post">
      <div class="form-group">
        <input type="email" class="form-control" id="username" placeholder="Enter username" name="username">
      </div>
      <div class="form-group">
        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
      </div>
      <div class="form-footer">

      <input type="checkbox" name="rememberme" value="1" style="margin-left:-18px;">Remember Me: <br>

        <input type="submit" class="button_login" id="login_submit" name="submit">
      </div>
    </form>
  </div>
</div>
</section>

<!-- Load JS here for Faster site load =============================-->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/jquery.ui.touch-punch.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.js"></script>
<script src="js/bootstrap-switch.js"></script>
<script src="js/jquery.tagsinput.js"></script>
<script src="js/jquery.placeholder.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/application.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/jquery.sortable.js"></script>
<script type="text/javascript" src="js/jquery.gritter.js"></script>
<script src="js/jquery.nicescroll.min.js"></script>
<script src="js/skylo.js"></script>
<script src="js/prettify.min.js"></script>
<script src="js/jquery.noty.js"></script>
<script src="js/scroll.js"></script>
<script src="js/jquery.panelSnap.js"></script>
<script src="js/login.js"></script>





</body>
</html>