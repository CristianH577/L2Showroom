<?php

class OrderModel extends Model{

    private $id_order;
    private $id_user;
    private $id_item;
    private $char_data;
    private $wt;
    private $price;
    private $quantity;
    private $char_imgs;
    private $register;

    public function __construct(){
        parent::__construct();

        $this->id_order = '';
        $this->id_user = '';
        $this->id_item = '';
        $this->char_data = '';
        $this->wt = '';
        $this->price = '';
        $this->quantity = '';
        $this->char_imgs = '';
        $this->register = '';
    }


    //DB modify--------------------------------------------
    public function save(){
        //error_log('OrderModel::save-> EJECUTO ');

        $query = $this->prepare(
        'INSERT 
        INTO orders (id_user, id_item, char_data, wt, price, quantity, char_imgs, register) 
        VALUES(:id_user, :id_item, :char_data, :wt, :price, :quantity, :char_imgs, :register)');
        
        try{
            $query->execute([
                'id_user'     => $this->id_user,
                'id_item'  => $this->id_item,
                'char_data'  => $this->char_data,  
                'wt'  => $this->wt,
                'price'      => $this->price,
                'quantity'     => $this->quantity,
                'char_imgs'  => $this->char_imgs, 
                'register'     => $this->register
            ]);

            return true;
        }catch(PDOException $e){
            error_log('OrderModel::save->PDOException ' . $e);
        }

        return false;
    }

    public function delete(){
        //error_log('OrderModel::delete-> EJECUTO ');

        $query = $this->prepare(
        'DELETE 
        FROM orders 
        WHERE id_order = :id_order');

        try{
            $query->execute(['id_order' => $this->id_order]);

            return true;
        }catch(PDOException $e){
            error_log('OrderModel::delete->PDOException ' . $e);
        }
        
        return false;
    }


    //DB get data--------------------------------------------
    public function count(){
        //error_log('OrderModel::count-> EJECUTO ');

        try{
            $query = $this->query(
                'SELECT COUNT(*) total 
                FROM orders');

            $count = $query->fetch(PDO::FETCH_ASSOC)['total'];
            //error_log('OrderModel::count-> '. $count);
            
            return $count;
        }catch(PDOException $e){
            error_log('OrderModel::count->PDOException ' . $e);
        }
        
        return false;
    }

    public function countSearch($id_user, $wt, $type, $name){
        //error_log('OrderModel::countSearch-> EJECUTO ');

        if (is_numeric($id_user) && $id_user != "") {
            $prepareAdd = 'O.id_user = :id_user ';
        }else{
            $prepareAdd = 'U.nick LIKE :id_user ';
            $id_user = "%".$id_user."%";
        }

        $query = $this->prepare(
            'SELECT COUNT(*) total 
            FROM orders O, users U, items I
            WHERE O.id_user = U.id_user 
            AND O.id_item = I.id_item
            AND O.wt LIKE :wt 
            AND I.name_item LIKE :name
            AND I.type LIKE :type
            AND '.$prepareAdd.'');

        try{
            $query->execute([
                'id_user' => $id_user,  
                'wt' => '%'.$wt.'%', 
                'name' => '%'.$name.'%', 
                'type' => '%'.$type.'%', 
            ]);

            $count = $query->fetch(PDO::FETCH_ASSOC)['total'];
            //error_log('OrderModel::countSearch-> '. $count);

            return $count;
        }catch(PDOException $e){
            error_log('OrderModel::countSearch->PDOException ' . $e);
        }

        return false;
    }
    
    function getOrders($actualPage, $resultsPerPage){
        //error_log('OrderModel::getOrders-> EJECUTO ');
        $orders_list = [];
        $rowActual = ($actualPage - 1)*$resultsPerPage;

        $query = $this->prepare(
            'SELECT O.*, I.*, U.nick, U.discord, U.img_user
            FROM orders O, items I, users U
            WHERE O.id_user = U.id_user 
            AND O.id_item = I.id_item 
            LIMIT :rowActual, :resultsPerPage');

        try{
            $query->execute([
                'rowActual' => $rowActual, 
                'resultsPerPage' => $resultsPerPage
            ]);

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $orders_list[] = $p;
            }

            return $orders_list;
        }catch(PDOException $e){
            error_log('OrderModel::getOrders->PDOException ' . $e);
        }

        return false;
    }

    public function search($id_user, $wt, $type, $name, $orderBy, $actualPage, $resultsPerPage){
        //error_log('OrderModel::search-> EJECUTO');

        $orders_list = [];
        $rowActual = ($actualPage - 1)*$resultsPerPage;

        if ($orderBy == "name_item") {
            $orderBy = "I.name_item";
        }

        if (is_numeric($id_user) && $id_user != "") {
            $prepareAdd = 'O.id_user = :id_user ';
        }else{
            $prepareAdd = 'U.nick LIKE :id_user ';
            $id_user = "%".$id_user."%";
        }

        $query = $this->prepare(
            'SELECT O.*, I.*, U.nick, U.discord, U.img_user
            FROM orders O, users U, items I
            WHERE O.id_user = U.id_user 
            AND O.id_item = I.id_item
            AND O.wt LIKE :wt 
            AND I.name_item LIKE :name
            AND I.type LIKE :type
            AND '.$prepareAdd.'
            ORDER BY '.$orderBy.'
            LIMIT :rowActual, :resultsPerPage');
        
        try{
            $query->execute([
                'id_user' => $id_user, 
                'wt' => '%'.$wt.'%',  
                'type' => '%'.$type.'%', 
                'name' => '%'.$name.'%',
                'rowActual' => $rowActual, 
                'resultsPerPage' => $resultsPerPage
            ]);

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $orders_list[] = $p;
            }

            return $orders_list;
        }catch(PDOException $e){
            error_log('OrderModel::search->PDOException ' . $e);
        }

        return false;
    }
    public function countUsers(){
        //error_log('OrderModel::countUsers-> EJECUTO ');

        try{
            $query = $this->query(
                'SELECT COUNT(DISTINCT id_user) total 
                FROM orders');

            $count = $query->fetch(PDO::FETCH_ASSOC)['total'];
            //error_log('OrderModel::countUsers-> '. $count);
            
            return $count;
        }catch(PDOException $e){
            error_log('OrderModel::countUsers->PDOException ' . $e);
        }
        
        return false;
    }

    public function countUsersSearch($nick, $discord){
        //error_log('OrderModel::countUsersSearch-> EJECUTO ');

        $query = $this->prepare(
            'SELECT COUNT(DISTINCT O.id_user) total 
            FROM orders O, users U
            WHERE O.id_user = U.id_user
            AND U.nick LIKE :nick
            AND U.discord LIKE :discord');

        try{
            $query->execute([
                'nick' => '%'.$nick.'%',
                'discord' => '%'.$discord.'%' 
            ]);

            $count = $query->fetch(PDO::FETCH_ASSOC)['total'];
            //error_log('OrderModel::countUsersSearch-> '. $count);

            return $count;
        }catch(PDOException $e){
            error_log('OrderModel::countUsersSearch->PDOException ' . $e);
        }

        return false;
    }
    
    function getUsers($orderBy, $actualPage, $resultsPerPage){
        //error_log('OrderModel::getUsers-> EJECUTO ');
        $new_users = [];
        $rowActual = ($actualPage - 1)*$resultsPerPage;

        $query = $this->prepare(
            'SELECT DISTINCT id_user
            FROM orders
            ORDER BY '.$orderBy.'
            LIMIT :rowActual, :resultsPerPage');

        try{
            $query->execute([
                'rowActual' => $rowActual, 
                'resultsPerPage' => $resultsPerPage
            ]);

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $new_users[] = $p['id_user'];
            }

            return $new_users;
        }catch(PDOException $e){
            error_log('OrderModel::getUsers->PDOException ' . $e);
        }

        return false;
    }
    
    function getUsersSearch($nick, $discord, $orderBy, $actualPage, $resultsPerPage){
        //error_log('OrderModel::getUsers-> EJECUTO ');
        
        $new_users = [];
        $rowActual = ($actualPage - 1)*$resultsPerPage;

        $query = $this->prepare(
            'SELECT DISTINCT O.id_user
            FROM orders O, users U
            WHERE O.id_user = U.id_user
            AND U.nick LIKE :nick
            AND U.discord LIKE :discord
            ORDER BY '.$orderBy.'
            LIMIT :rowActual, :resultsPerPage');

        try{
            $query->execute([
                'nick' => '%'.$nick.'%',
                'discord' => '%'.$discord.'%',
                'rowActual' => $rowActual, 
                'resultsPerPage' => $resultsPerPage
            ]);

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $new_users[] = $p['id_user'];
            }

            return $new_users;
        }catch(PDOException $e){
            error_log('OrderModel::getUsers->PDOException ' . $e);
        }

        return false;
    }
    
    function getOrder($id){
        //error_log('OrderModel::getOrders-> EJECUTO ');

        $query = $this->prepare(
            'SELECT *
            FROM orders
            WHERE id_order = :id_order');

        try{
            $query->execute([ 'id_order' => $id ]);

            if($query->rowCount() > 0){
                $this->from($query->fetch(PDO::FETCH_ASSOC));
                return $this;
            }
        }catch(PDOException $e){
            error_log('OrderModel::getOrders->PDOException ' . $e);
        }

        return false;
    }

    public function existOrder($id_user, $id_item){
        //error_log('OrderModel::existOrder-> EJECUTO ');

        $query = $this->prepare(
        'SELECT id_order 
        FROM orders 
        WHERE id_user = :id_user 
        AND id_item = :id_item');

        try{
            $query->execute([
                'id_user' => $id_user, 
                'id_item' => $id_item
            ]);
            
            if($query->rowCount() > 0){
                return true;
            }
        }catch(PDOException $e){
            error_log('OrderModel::existOrder->PDOException ' . $e);
        }
        
        return false;
    }

    public function existOrderChar($id_user, $data){
        //error_log('OrderModel::existOrderChar-> EJECUTO ');

        $query = $this->prepare(
        'SELECT id_order 
        FROM orders
        WHERE id_user = :id_user 
        AND char_data LIKE :char_data');

        try{
            $query->execute([
                'id_user' => $id_user, 
                'char_data' => '%'.$data.'%'
            ]);
            
            if($query->rowCount() > 0){
                return true;
            }
        }catch(PDOException $e){
            error_log('OrderModel::existOrderChar->PDOException ' . $e);
        }
        
        return false;
    }


    //tools---------------------------------------------------
    public function from($array){
        //$this->db = "";
        $this->id_order = $array['id_order'];
        $this->id_user = $array['id_user'];
        $this->id_item = $array['id_item'];
        $this->char_data = $array['char_data'];
        $this->wt = $array['wt'];
        $this->price = $array['price'];
        $this->quantity = $array['quantity'];
        $this->char_imgs = $array['char_imgs'];
        //$this->register = $array['register'];
    }

    public function toUser($data){
        $array = [];
        $array[0]['nick'] = $data[0]['nick'];
        $array[0]['discord'] = $data[0]['discord'];
        $array[0]['img_user'] = $data[0]['img_user'];

        return $array;
    }

    function deleteCharImgs(){
        //error_log('UserModel::deleteCharImgs-> EJECUTO');
        
        $char_imgs = explode(',', $this->char_imgs);
        $e = 0;

        for ($i=1; $i < 5; $i++) {
            if (isset($char_imgs[$i-1])) {
                $path[$i] = "assets/chars/".$char_imgs[$i-1];
    
                if (file_exists($path[$i])) {
                    if (!unlink($path[$i])) $e++;
                }
            }
        }

        if ($e != 0) {
            return false;
        }
        
        return true;
    }

    //set-get---------------------------------------------------------
    public function setID($id_order){             $this->id_order = $id_order;}
    public function setIDUser($id_user){       $this->id_user = $id_user;}
    public function setIDItem($id_item){ $this->id_item = $id_item;}
    public function setCharData($char_data){ $this->char_data = $char_data;}
    public function setWT($wt){         $this->wt = $wt;}
    public function setPrice($price){       $this->price = $price;}
    public function setQuantity($quantity){     $this->quantity = $quantity;}
    public function setCharImgs($char_imgs){       $this->char_imgs = $char_imgs;}
    public function setRegister($register){       $this->register = $register;}

    public function getID(){        return $this->id_order;}
    public function getIDUser(){     return    $this->id_user;}
    public function getIDItem(){  return $this->id_item;}
    public function getCharData(){  return $this->char_data;}
    public function getWT(){      return $this->wt;}
    public function getPrice(){      return $this->price;}
    public function getQuantity(){  return $this->quantity;}
    public function getCharImgs(){  return $this->char_imgs;}
    public function getRegister(){       return $this->register;}

}
?>