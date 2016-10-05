<?php 
    include 'models/user.php';
    
    $user = new User();
    
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    
    $taken = $user->checkUserExists($username);
    
    if ($taken) {
        echo "Taken";
    } else {
        echo "Available";
    }
?>