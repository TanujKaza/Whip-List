<?php
/* These are our valid username and passwords */
$user = 'admin@pinstorm.com';
$pass = 'admin';

if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
  if (($_COOKIE['username'] != $user) || ($_COOKIE['password'] != md5($pass))) {    	
      header('Location: login.html');
  } 
  else {
      echo header('Location: index.php');
  }
} 
else {
    header('Location: login.html');
}

?>
