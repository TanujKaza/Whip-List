<?php 
// You can easily build the menu with php predefined function written by me (@bootstrapguru). It is located in root folder with file name called menu-builder.php
include('menu-builder.php'); 
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
  <link href="css/font-awesome.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet" type="text/css"> 
  <link href="css/mystyle.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
   
  <?php 
    $pieces = explode('/',$_SERVER['REQUEST_URI']);  
    $page=end($pieces); 
    if(strpos($page,"extended-modals") !== false ) { 
  ?>

    <link href="css/bootstrap-modal-bs3fix.css" rel="stylesheet" type="text/css"> 

  <?php } 
  ?>

  <link href="less/style.less" rel="stylesheet"  title="lessCss" id="lessCss"> 
  
    </head>
    <body>
    <div class="site-holder">
      <nav class="navbar" role="navigation">

        <div class="navbar-header">
          <h2 style="margin-left:30px;">WHIP LIST </h2>
        </div>

        <div class="logout_option">
          <a href="logout.php" style="margin-left:1016px;font-size:18px;">LOG OUT</a>
        </div>
      </nav> <!-- /.navbar -->

      <!-- .box-holder -->
      <div class="box-holder">

        <!-- .left-sidebar -->
        <div class="left-sidebar">
          <div class="sidebar-holder">
            <ul class="nav  nav-list">

              <!-- sidebar to mini Sidebar toggle -->
              <li class="nav-toggle">
                <button class="btn  btn-nav-toggle text-primary"><i class="fa fa-angle-double-left toggle-left"></i> </button>
              </li>

              <?php buildMenu($menuList); ?>

            </ul>
          </div>
        </div> <!-- /.left-sidebar -->

    <!-- .content -->
    <div class="content">

