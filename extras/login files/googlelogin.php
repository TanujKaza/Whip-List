<?php
require_once('include/common.php') ;

/*$proj ="CREATE TABLE users(
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    oauth_provider VARCHAR(255) NOT NULL,
    oauth_uid VARCHAR(255) NOT NULL,
    fname VARCHAR(255) NOT NULL,
    lname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    locale VARCHAR(10) NOT NULL,
    gpluslink VARCHAR(255) NOT NULL,
    picture VARCHAR(255) NOT NULL,
    created DATETIME ,
    modified DATETIME 
) ";

if ($conn->query($proj) === TRUE){
    echo "Table users created successfully<br />" ;
}
else{
    echo "Table users not created <br />" . $conn->getLastError() ;
}*/

if(!$mysqli->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
    exit();
} else {
    printf("Current character set: %s\n", $mysqli->character_set_name());
}


?>