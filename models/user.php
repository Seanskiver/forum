<?php 
    require_once 'gateway.php';
    class User {
        private $id;
        public $username;
        private $password;
        private $privilege;
        
        //---------------------------------------------- PUBLIC FUNCTIONS

        public function login($username, $password) {
            $sql = 'CALL get_user_by_username(:username)';
            
            try {
                $gateway = Gateway::getInstance();
                
                $stmt = $gateway->dbh->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetchAll()[0];
            } catch(PDOException $e) {
                echo "Database error. check back later";
            }
            
            if (!$result) {
                echo "No results";         
            }

            $inputHash = $this->genHash($result['salt'], $password);
            
            if ($inputHash == $result['password_hash']) {
                $this->id = $result['id'];
                $this->username = $result['username'];
                $this->privilege = $result['admin'];
                
                $_SESSION['user'] = $this->id;
            } else {
                return false;
            }
            
        }
        
        public function createUser($username, $password, $admin = 0) {
            $salt = $this->genSalt();
            $hash = $this->genHash($salt, $password);
            $id = $this->genId();
            $sql = 'CALL create_user(:id, :username, :hash, :salt, :admin)';
            
            
            try {
                $gateway = Gateway::getInstance();
                
                $stmt = $gateway->dbh->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
                $stmt->bindParam(':salt', $salt, PDO::PARAM_STR);
                $stmt->bindParam(':admin', $admin, PDO::PARAM_BOOL);
                $stmt->execute();
            } catch(PDOException $e) {
                echo "<b>Registration Failed!</b> <br>";
                $e->message;
            }
        }
        
        // Checks database to see if a username is already in use
        public function checkIfAvail($username) {
            $sql = 'CALL get_user_by_username(:username)';
            
            $gateway = Gateway::getInstance();
            $stmt = $gateway->dbh->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll()[0];
            
            if ($result === NULL) {
                return true;
            } else {
                return false;
            }
        }
        
        public function setPrivilege($id, $priv) {
            
        }
        
        public function updateUsername($id, $username) {
            $sql = 'CALL update_username(:id, :username)';
            
            try {
                $gateway = Gateway::getInstance();
                $stmt = $gateway->dbh->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();                
            } catch(PDOException $e) {
                echo "could not update username<br>";
                echo $e->getMessage();
            }

        }
        
        public function updatePassword($id, $password) {
            $user = $this->getUserById($id);
            $newhash = $this->genHash($user['salt'], $password);
            
            $sql = 'CALL update_password(:id, :password)';
            
            try {
                $gateway = Gateway::getInstance();
                $stmt = $gateway->dbh->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':password', $newhash, PDO::PARAM_STR);
                $stmt->execute();  
            } catch (PDOException $e) {
                echo "Failed to update password";
                echo $e->getMessage();
            }

        }
        
        public function deleteUser($id) {
            
        }
        
        
        //---------------------------------------------- PRIVATE FUNCTIONS
        private function getUserById($id) {
            $sql = 'CALL get_user_by_id(:id)';
            
            try {
                $gateway = Gateway::getInstance();
                
                $stmt = $gateway->dbh->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetchAll()[0];
                return $result;
            } catch(PDOException $e) {
                echo "Database error. check back later";
            }
        }
        
        private function genHash($salt, $pass) {
            return hash("sha256", $salt.$pass);
        }
        
        private function genSalt() {
            $strong;
            $base_salt = openssl_random_pseudo_bytes(20, $strong);
            $salt = bin2hex($base_salt);
            
            if ($strong == true) {
                return $salt;
            } else {
                return $this->genSalt();
            }
        } 
        
        private function genId() {
            $id = rand(1, 9999);
            $sql = 'SELECT * FROM user WHERE id = '.$id;
            $gateway = Gateway::getInstance();
            $result = $gateway->dbh->query($sql);
            $result = $result->fetchAll();
            
            if (count($result) == 0) {
                return $id;
            } else {
                return $this->genId();
            }
        }
        
        private function validateUser($username, $password) {
            
        }
    }
?>