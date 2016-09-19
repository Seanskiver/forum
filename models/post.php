<?php
    require_once 'gateway.php';
    class Post {
        
        //---------------------------------------------- CRUD FUNCTIONS
        public function getPosts() {
            $sql = 'CALL get_posts_time()';
            try {
                $gateway = Gateway::GetInstance();
                
                $stmt = $gateway->dbh->prepare($sql);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                echo "error connecting to database<br>";
                echo $e->getMessage();
                return false;
            }
        }
        
        public function createPost($title, $body) {
            $title = filter_var($title, FILTER_SANITIZE_STRING);
            $body = filter_var($body, FILTER_SANITIZE_STRING);
            $sql = 'CALL create_post(:user_id, :title, :body)';
            
            if (!isset($_SESSION['user'])) {
                return false; 
            } 
            
            try {
                $gateway = Gateway::getInstance();
                $stmt = $gateway->dbh->prepare($sql);
                $stmt->bindParam(':user_id', $_SESSION['user'], PDO::PARAM_INT);
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                $stmt->bindParam(':body', $body, PDO::PARAM_STR);
                $stmt->execute();                
            } catch(PDOException $e) {
                echo "Failed to post <br>";
                echo $e->getMessage();
            }
        }
        
        public function editPost($id, $title, $body) {
            $title = filter_var($title, FILTER_SANITIZE_STRING);
            $body = filter_var($body, FILTER_SANITIZE_STRING);
            $sql = 'CALL edit_post(:id, :title, :body)';
            
            if (!isset($_SESSION['user'])) {
                return false; 
            } 
            
            try {
                $gateway = Gateway::getInstance();
                $stmt = $gateway->dbh->prepare($sql);
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                $stmt->bindParam(':body', $body, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();                
            } catch(PDOException $e) {
                echo "Failed to edit post <br>";
                echo $e->getMessage();
            }
        }
        
        public function deletePost($id) {
            $sql = 'CALL delete_post(:id)';
            
            if (!isset($_SESSION['user'])) {
                return false;
            }
            
            try {
                $gateway = Gateway::getInstance();
                $stmt = $gateway->dbh->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();                
            } catch(PDOException $e) {
                echo "Failed to delete post <br>";
                echo $e->getMessage();
            }
        }
    }

?>