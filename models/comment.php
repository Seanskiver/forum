<?php 
require_once 'gateway.php';

class Comment {
    public function getComments($postId) {
        $sql = 'CALL get_comments_post(:id)';
        
        try {
            $gateway = Gateway::getInstance();
            $stmt = $gateway->dbh->prepare($sql);
            $stmt->bindParam(':id', $postId,  PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            return $result;
        } catch(PDOException $e) {
            echo "Error getting comments<br>";
            echo $e->getMessage();
        }
    } 
    
    public function getReplies($commentId) {
        $sql = 'CALL get_comment_replies(:id)';
        
        try {
            $gateway = Gateway::getInstance();
            $stmt = $gateway->dbh->prepare($sql);
            $stmt->bindParam(':id', $commentId,  PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            return $result;
        } catch(PDOException $e) {
            echo "Error getting comments<br>";
            echo $e->getMessage();
        }
    }
    
    public function addComment($postId, $userId, $body) {
        $sql = 'CALL create_comment(:postId, :userId, :body)';
        
        try{
            $gateway = Gateway::getInstance();
            $stmt = $gateway->dbh->prepare($sql);
            
            $stmt->bindParam(':postId', $postId,  PDO::PARAM_INT);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':body', $body, PDO::PARAM_STR);
            
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>