<?php

    class Session extends Model {
        
        protected $table = 'sessions';
        protected $dates = true;
        
        public function createSession($user){
            $session = 'noToken'.md5(substr(time(), -8));
            $created_at = date('Y-m-d H:i:s', time() );
            $sql = 'INSERT INTO `sessions`(`session`, `user`, created_at) VALUES (:session, :user, :tm)';
            
            $stmt = $this->database->prepare($sql);
            
            $stmt->bindParam(':session', $session, PDO::PARAM_STR);
            $stmt->bindParam(':user', $user, PDO::PARAM_INT);
            $stmt->bindParam(':tm', $created_at, PDO::PARAM_STR);
            
            $q = $stmt->execute();
            
            if(!$q){
                new Error(601, 'Could not create user session.');
                return false;
            }
            else {
                return true;
            }
            
            
        }
        
        public function setSession($user, $sessionToken) {
            
            $sql = 'UPDATE `sessions` SET `session` = :session WHERE `user` = :user';
            
            $stmt = $this->database->prepare($sql);
            
            $stmt->bindParam(':session', $sessionToken, PDO::PARAM_STR);
            $stmt->bindParam(':user', $user, PDO::PARAM_INT);
            
            $q = $stmt->execute();
            
            if(!$q){
                new Error(601, 'Could not create user session.');
                dbga($stmt->errorInfo());
                return false;
            }
            else {
                unset($_SESSION[APPNAME]);
                $_SESSION[APPNAME][SESSIONKEY] = $sessionToken;
                
                $User = new User;
                $profile = $User->profilePage($user);
                
                //dbga($profile);
                
                $_SESSION[APPNAME]['USR'] = $profile->name;
                return true;
            }
            
        }
        
        protected function getSession() {
            $session = $_SESSION[APPNAME][SESSIONKEY];
            
            
            $sql = 'SELECT users.idusers AS id, users.name, users.email, users.role FROM users
                    INNER JOIN sessions ON sessions.user = users.idusers
                    WHERE sessions.session = :session';
            
            $stmt = $this->database->prepare($sql);
            $stmt->bindParam(':session', $session, PDO::PARAM_STR);
            $q = $stmt->execute();
            
            
            if(!$q){
                new Error(602, 'Could not retrieve user profile.');
                return false;
            }
            else {
                $objectUser = $stmt->fetch(PDO::FETCH_OBJ);
                
                if(is_object($objectUser)){
                    $User = new User;
                    //$objectUser->permissions = $User->getRolePermissions($objectUser->role);
                    
                    $_SESSION[APPNAME]['USR'] = $objectUser->name;
                }
                return $objectUser;
            }
        }
        

        protected function destroySession($session, $user) { }
    }
    