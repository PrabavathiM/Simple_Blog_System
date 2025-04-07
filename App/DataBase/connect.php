<?php

$host='localhost';
$users ='root';
$Password ='';
$dbname='blog';

$conn = new mysqli($host,$users,$Password,$dbname);

//connectivity error handling
if($conn->connect_error){
    die('Connection failed:' . $conn->connect_error);
}

