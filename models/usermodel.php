<?php

class UserModel extends Model{

    private $id;
    private $email;
    private $password;
    private $nick;
    private $role;
    private $img;
    private $discord;
    private $register;
    private $verify;
    private $active;

    public function __construct(){
        parent::__construct();

        $this->id = '';
        $this->email = '';
        $this->password = '';
        $this->nick = '';
        $this->role = '';
        $this->img = '';
        $this->discord = '';
        $this->register = '';
        $this->verify = '';
        $this->active = '';
    }


    //DB modify-----------------------------------------------
    public function save(){
        //error_log('UserModel::save-> EJECUTO');

        $query = $this->prepare(
        'INSERT 
        INTO users (email, password, nick, role, img_user, discord, register, verify, active) 
        VALUES(:email, :password, :nick, :role, :img, :discord, :register, :verify, :active)');

        try{
            $query->execute([
                'email'     => $this->email,
                'password'  => $this->password,
                'nick'     => $this->nick,
                'role'      => $this->role,
                'img'     => $this->img,
                'discord'     => $this->discord,
                'register'     => $this->register,
                'verify'     => $this->verify,
                'active'     => $this->active
            ]);

            return true;
        }catch(PDOException $e){
            error_log('UserModel::save->PDOException ' . $e);
        }

        return false;
    }

    public function delete($id){
        ('UserModel::delete-> EJECUTO');

        $query = $this->prepare(
        'DELETE 
        FROM users 
        WHERE id_user = :id');

        try{
            $query->execute(['id' => $id]);
            
            return true;
        }catch(PDOException $e){
            error_log('UserModel::delete->PDOException ' . $e);
        }

        return false;
    }

    public function update(){
        //error_log('UserModel::update-> EJECUTO');
        
        $query = $this->prepare(
        'UPDATE users 
        SET email = :email, password = :password, nick = :nick, discord = :discord 
        WHERE id_user = :id');

        try{
            $query->execute([
                'id'        => $this->id,
                'email' => $this->email, 
                'password' => $this->password,
                'nick' => $this->nick,
                'discord' => $this->discord
            ]);

            return true;
        }catch(PDOException $e){
            error_log('UserModel::update->PDOException ' . $e);
        }

        return false;
    }

    public function updateImg(){
        //error_log('UserModel::updateImg-> EJECUTO');

        $query = $this->prepare(
        'UPDATE users 
        SET img_user = :img 
        WHERE id_user = :id');

        try{
            $query->execute([
                'id'        => $this->id,
                'img' => $this->img 
            ]);

            return true;
        }catch(PDOException $e){
            error_log('UserModel::updateImg->PDOException ' . $e);
        }

        return false;
    }

    function activateAccount($email){
        
        $query = $this->prepare(
        'UPDATE users 
        SET active = 1 
        WHERE email = :email');

        try{
            $query->execute(['email' => $email]);

            return true;
        }catch(PDOException $e){
            error_log('UserModel::activateAccount->PDOException ' . $e);
        }

        return false;
    }


    //DB get data-------------------------------------------------
    public function count(){
        //error_log('UserModel::count-> EJECUTO ');

        try{
            $query = $this->query(
            'SELECT COUNT(*) total 
            FROM users
            WHERE role = "user"
            AND active = "1"');

            $count = $query->fetch(PDO::FETCH_ASSOC)['total'];

            return $count;
        }catch(PDOException $e){
            error_log('UserModel::count->PDOException ' . $e);
        }

        return false;
    }

    public function countSearch($id, $email, $nick){
        //error_log('UserModel::countSearch-> EJECUTO ');

        $query = $this->prepare(
        'SELECT COUNT(*) total 
        FROM users 
        WHERE role = "user" 
        AND active = "1"
        AND id_user LIKE :id 
        AND email LIKE :email 
        AND nick LIKE :nick');

        try{
            $query->execute([
            'id' => "%".$id."%", 
            'email' => "%".$email."%", 
            'nick' => "%".$nick."%" ]);

            $count = $query->fetch(PDO::FETCH_ASSOC)['total'];

            return $count;
        }catch(PDOException $e){
            error_log('UserModel::countSearch->PDOException ' . $e);
        }

        return false;
    }

    public function getUsers($actualPage, $resultsPerPage, $role){
        //error_log('UserModel::getUsers-> EJECUTO ');

        $users_list = [];
        $rowActual = ($actualPage - 1)*$resultsPerPage;

        if ($role == "admin") {
            $add = '';
        }else{
            $add = 'AND active = "1"';
        }

        $query = $this->prepare(
        'SELECT id_user, email, nick, img_user, discord, register, active 
        FROM users 
        WHERE role = "user" 
        '.$add.'
        LIMIT :rowActual, :resultsPerPage');

        try{
            $query->execute([
                'rowActual' => $rowActual, 
                'resultsPerPage' => $resultsPerPage
            ]);

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $users_list[] = $p;
            }
            return $users_list;

        }catch(PDOException $e){
            error_log('UserModel::getUsers->PDOException ' . $e);
        }

        return false;
    }

    public function search($id, $email, $nick, $orderBy, $actualPage, $resultsPerPage, $role){
        //error_log('UserModel::search-> EJECUTO');

        $users_list = [];
        $rowActual = ($actualPage - 1)*$resultsPerPage;

        if ($role == "admin") {
            $add = '';
        }else{
            $add = 'AND active = "1"';
        }
        
        $query = $this->prepare(
        'SELECT id_user, email, nick, img_user, discord, register, active 
        FROM users 
        WHERE role = "user" 
        AND id_user LIKE :id 
        AND email LIKE :email 
        AND nick LIKE :nick 
        '.$add.'
        ORDER BY '.$orderBy.' 
        LIMIT :rowActual, :resultsPerPage');

        try{
            $query->execute([
                'id' => "%".$id."%", 
                'email' => "%".$email."%", 
                'nick' => "%".$nick."%", 
                'rowActual' => $rowActual, 
                'resultsPerPage' => $resultsPerPage
            ]);

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $users_list[] = $p;
            }

            return $users_list;
        }catch(PDOException $e){
            error_log('UserModel::search->PDOException ' . $e);
        }
        
        return false;
    }

    public function getUser($id){
        //error_log('UserModel::getUser-> EJECUTO');
        
        $query = $this->prepare(
        'SELECT * 
        FROM users 
        WHERE id_user = :id');

        try{
            $query->execute(['id' => $id]);

            if($query->rowCount() > 0){
                $this->from($query->fetch(PDO::FETCH_ASSOC));

                $this->db = "";
                return $this;
            }
            
        }catch(PDOException $e){
            error_log('UserModel::getUser->PDOException ' . $e);
        }
        
        return false;
    }

    public function exist($param, $var, $id_user){
        //error_log('UserModel::exist-> EJECUTO');

        $query = $this->prepare(
        'SELECT * 
        FROM users 
        WHERE id_user != :id_user 
        AND '.$param.' = :var');

        try{
            $query->execute( [
                'id_user' => $id_user, 
                'var' => $var
            ]);
            
            if($query->rowCount() > 0){
                $user = new UserModel();
                $user->from($query->fetch(PDO::FETCH_ASSOC));

                return $user;
            }
        }catch(PDOException $e){
            error_log('UserModel::exist->PDOException ' . $e);
        }
        
        return false;
    }

    function comparePasswords($password_entry, $id){
        //error_log('UserModel::comparePasswords-> EJECUTO');

        $query = $this->prepare(
        'SELECT password 
        FROM users 
        WHERE id_user = :id');

        try{
            $query->execute( ['id' => $id] );

            $password = $query->fetch(PDO::FETCH_ASSOC)['password'];
    
            if (password_verify($password_entry, $password) === true) {
                return true;
            }
        }catch(PDOException $e){
            error_log('UserModel::comparePasswords->PDOException ' . $e);
        }

        return false;
    }
    
    function verifyEmail($email, $verify){
        //error_log('UserModel::verifyEmail-> EJECUTO');

        $query = $this->prepare('SELECT active,verify 
        FROM users 
        WHERE email = :email');

        try{
            $query->execute( ['email' => $email] );

            $active = $query->fetch(PDO::FETCH_ASSOC)['active'];
            $verify = $query->fetch(PDO::FETCH_ASSOC)['verify'];
        }catch(PDOException $e){
            error_log('UserModel::verifyEmail->PDOException ' . $e);
        }

        if ($active == 1) {
            return "already";
        }else{
            if ($verify == $verify) {
                return true;
            }
        }
        return false;
    }
    
    function resendVerify($email){
        //error_log('UserModel::resendVerify-> EJECUTO');

        $query = $this->prepare('SELECT verify 
        FROM users 
        WHERE email = :email');

        try{
            $query->execute( ['email' => $email] );
            $verify = $query->fetch(PDO::FETCH_ASSOC)['verify'];

            return $verify;
        }catch(PDOException $e){
            error_log('UserModel::resendVerify->PDOException ' . $e);
        }

        return false;
    }

//tools---------------------------------------------------------------
public function from($array){
    $this->id = $array['id_user'];
    $this->email = $array['email'];
    $this->nick = $array['nick'];
    $this->role = $array['role'];
    $this->img = $array['img_user'];
    $this->discord = $array['discord'];
    $this->active = $array['active'];
}

function deleteOldImg($id){
    //error_log('UserModel::deleteOldImg-> EJECUTO');
    
    $path = "assets/profiles/".$id.".";

    if (file_exists($path."jpg")) {
        if (unlink($path."jpg")) {
            return true;
        }else{
            return false;
        }
    }

    if (file_exists($path."jpeg")) {
        if (unlink($path."jpeg")) {
            return true;
        }else{
            return false;
        }
    }

    if (file_exists($path."png")) {
        if (unlink($path."png")) {
            return true;
        }else{
            return false;
        }
    }

    return true;
}

//set-get---------------------------------------------
public function setPassword($password, $hash){ 
    //error_log('UserModel::setPassword-> EJECUTO');

    if($hash){
        $this->password = $password;
    }else{
        $this->password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
    }
}

public function setID($id){             $this->id = $id;}
public function setEmail($email){       $this->email = $email;}
public function setNick($nick){       $this->nick = $nick;}
public function setRole($role){         $this->role = $role;}
public function setImg($img){$this->img = $img;
}
public function setDiscord($discord){ $this->discord = $discord;}
public function setDate($register){       $this->register = $register;}
public function setVerify($verify){       $this->verify = $verify;}
public function setActive($active){       $this->active = $active;}

public function getID(){        return $this->id;}
public function getEmail(){     return    $this->email;}
public function getPassword(){  return $this->password;}
public function getNick(){      return $this->nick;}
public function getRole(){      return $this->role;}
public function getImg(){     return $this->img;}
public function getDiscord(){  return $this->discord;}
public function getDate(){       return $this->register;}
public function getVerify(){       return $this->verify;}
public function getActive(){       return $this->active;}

}
?>