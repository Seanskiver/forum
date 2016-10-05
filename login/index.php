<?php 

include $_SERVER['DOCUMENT_ROOT'].'/models/user.php';
include $_SERVER['DOCUMENT_ROOT'].'/models/post.php';

include $_SERVER['DOCUMENT_ROOT'].'/views/header.php';

$user = new User();

if (isset($_POST['action'])) {
    $action = $_POST['action'];
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];
}
echo $_SERVER['SERVER_NAME'];
switch ($action) {

        
    default: 
        include $_SERVER['DOCUMENT_ROOT'].'/views/login-form.php';
        break;
}


?>