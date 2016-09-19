<?php 
include 'user.php';
include 'post.php';

$user = new User();
$post = new Post();

$user->login('changed', 'changed');
echo "<h3>Session data</h3>";
print_r($_SESSION);

echo "<h3>Posts</h3>";
$posts = $post->getPosts();
print_r($posts);
echo "<br>";



?>