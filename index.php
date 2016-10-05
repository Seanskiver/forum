<?php 
// MODEL INCLUDES
include 'models/user.php';
include 'models/post.php';
include 'models/comment.php';

include 'models/fields.php';
include 'models/validate.php';
// VALIDATION STUFF
$validate = new Validate();
$fields = $validate->getFields();
// LOGIN FIELDS FOR VALIDATION
$fields->addField('username');
$fields->addField('password');
$fields->addField('password_verify');
$fields->addField('userError');
$fields->addField('title');
$fields->addField('post_body');

//HEADER
include 'views/header.php';
// POST / USER / COMMENT INIT 
$user = new User();
$post = new Post();
$comment = new Comment();
// SET ACTION VARIABLE
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];
}


// ACTION ROUTING
switch ($action) {
    case 'view_post':
        $onePost = $post->getPost(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
        $comments = $comment->getComments(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
        
        include('views/single-post.php');
        break;
        
    case 'login-form': 
        include 'views/login-form.php';
        break;
        
    case 'login':
        $username = (string)filter_input(INPUT_POST, 'username');
        $password =  (string)filter_input(INPUT_POST, 'password');
        
        $validate->text('username', $username);
        $validate->text('password', $password);
        
        if ($fields->hasErrors()) {
            include 'views/login-form.php';
            break;
        }
        
        $validate->user('userError', $username, $password);
        
        if ($fields->hasErrors()) {
            include 'views/login-form.php';
        } else {
            $login = $user->login($username, $password);
            // return home
            header('Location: http://'.$_SERVER['SERVER_NAME']);            
        }
        
        break;

    case 'logout':
        $user->logout();
        $action = '';
        header('Location: http://'.$_SERVER['SERVER_NAME']);
        break;
        
    case 'signup-form':
        include 'views/signup-form.php';
        break;
        
    case 'signup':
        // INPUT SANITIZATION
        $username = (string)filter_input(INPUT_POST, 'username');
        $password =  (string)filter_input(INPUT_POST, 'password');
        $password_verify = (string)filter_input(INPUT_POST, 'password_verify');
        // VALIDATION
        $validate->text('username', $username);
        $validate->text('password', $password);
        $validate->text('password_verify', $password_verify);
        $validate->verify('password', $password, $password_verify);
        // CHECK IF USERNAME IS TAKEN
        $validate->userTaken('userError', $username);
        
        // CHECK FOR USERNAME TAKEN ERRORS
        if ($fields->hasErrors()) {
            include 'views/signup-form.php';
        } else {
            $user->createUser($username, $password);
            $user->login($username, $password);
            // return home
            header('Location: http://'.$_SERVER['SERVER_NAME']);            
        }
        
        break;
    
    case 'user-page':
        break;
    
    case 'add-post-form':
        include 'views/post-form.php';
        break;
        
    case 'add-post':
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $body = filter_input(INPUT_POST, 'post_body', FILTER_SANITIZE_STRING);
        // ADD FIELDS

        // VALIDATE FIELDS
        $validate->text('title', $title);
        $validate->text('post_body', $body);
        
        // CHECK FOR USERNAME TAKEN ERRORS
        if ($fields->hasErrors()) {
            include 'views/post-form.php';
            break;
        } else {
            // CREATE THE POST
            $success = $post->createPost($title, $body);
            // return home
            header('Location: http://'.$_SERVER['SERVER_NAME']);            
        }     
        
        break;
    
    case 'add-comment':
        $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING);
        $postId = filter_input(INPUT_POST, 'postId', FILTER_SANITIZE_NUMBER_INT);
        $comment->addComment($postId, intval($_SESSION['user_id']), $body);
        
        // RELOAD COMMENTS 
        $onePost = $post->getPost($postId);
        $comments = $comment->getComments($postId);
        
        include('views/single-post.php');
        break;
        
    case 'delete-comment':
        $commentId = filter_input(INPUT_GET, 'commentId', FILTER_SANITIZE_NUMBER_INT);
        $postId = filter_input(INPUT_GET, 'postId', FILTER_SANITIZE_NUMBER_INT);
        
        $comment->deleteComment($commentId);
    
        // RELOAD COMMENTS 
        $onePost = $post->getPost($postId);
        $comments = $comment->getComments($postId);
        include('views/single-post.php');
        break;
        
    case 'edit-comment':
        $postId = filter_input(INPUT_POST, 'postId', FILTER_SANITIZE_NUMBER_INT);
        $commentId = filter_input(INPUT_POST, 'commentId', FILTER_SANITIZE_NUMBER_INT);
        $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING);
        
        $comment->editComment($commentId, $body);

        //print_r($_POST);
        
        // RELOAD COMMENTS 
        $onePost = $post->getPost($postId);
        $comments = $comment->getComments($postId);
        include('views/single-post.php');
        break;
        
    case 'reply':
        $postId = filter_input(INPUT_POST, 'postId', FILTER_SANITIZE_NUMBER_INT);
        $parentId = filter_input(INPUT_POST, 'parentId', FILTER_SANITIZE_NUMBER_INT);
        $userId = intval($_SESSION['user_id']);
        $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING);

        
        $comment->addReply($postId, $parentId, $userId, $body);
        
        // RELOAD COMMENTS 
        $onePost = $post->getPost($postId);
        $comments = $comment->getComments($postId);
        include('views/single-post.php');
        break;
        
    // ADMIN ACTIONS
    case 'admin-controls': 
        if ($_SESSION['admin'] == 1) {
            $users = $user->getAllUsers();
            $posts = $post->getPosts();
            include  'views/admin/controls.php';
        } else {
            $action = '';
            header('Location: http://'.$_SERVER['SERVER_NAME']);
        }        
        break;
    case 'admin-list-users':
        if ($_SESSION['admin'] == 1) {
            $users = $user->getAllUsers(10);
            include  'views/admin/list-users.php';
        } else {
            $action = '';
            header('Location: http://'.$_SERVER['SERVER_NAME']);
        }
        break;
        
    case 'admin-delete-user':
        if ($_SESSION['admin'] == 1) {
            $userId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            echo $userId;
            $user->deleteUser($userId);
            
            // $users = $user->getAllUsers();
            // $posts = $post->getPosts();
            // include  'views/admin/controls.php';
        } else {
            $action = '';
            header('Location: http://'.$_SERVER['SERVER_NAME']);
        }
        break;
        
    case 'admin-delete-post':
        if ($_SESSION['admin'] == 1) {
            $postId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            $post->deletePost($postId);
            
        } else {
            $action = '';
            header('Location: http://'.$_SERVER['SERVER_NAME']);
        }
        break;
        
    case 'admin-create-user-form':
        break;
    case 'admin-create-user':
        break;

    
    default: 
        $allPosts = $post->getPosts();
        include 'views/posts.php';
        break;
    
    
}


include 'views/footer.php';

?>