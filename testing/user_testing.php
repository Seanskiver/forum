<?php 
    session_start();
    include 'user.php';
    
    $user = new User();
    
    //$user->updatePassword(121, 'changed');
    $user->login('changed', 'changed');
    print_r($_SESSION['user']);
    
?>