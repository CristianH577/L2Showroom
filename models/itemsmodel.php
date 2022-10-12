<?php

class ItemsModel extends Model{

    private $id;
    private $name;
    private $img;
    private $type;
    private $description;

    public function __construct(){
        parent::__construct();

        $this->id = '';
        $this->name = '';
        $this->img = '';
        $this->type = '';
        $this->description = '';
    }


    //DB modify--------------------------------------------
    public function save(){
        //error_log('ItemsModel::save-> EJECUTO');

        $query = $this->prepare(
        'INSERT 
        INTO items (name_item, img_item, type, description) 
        VALUES(:name_item, :img, :type, :description)');

        try{
            $query->execute([
                'name_item'  => $this->name,
                'img'  => $this->img, 
                'type'  => $this->type,
                'description'   => $this->description
            ]);

            return true;
        }catch(PDOException $e){
            error_log('ItemsModel::save->PDOException ' . $e);
        }

        return false;
    }
    public function updateImg(){
        //error_log('ItemsModel::updateImg-> EJECUTO');

        $query = $this->prepare(
        'UPDATE items 
        SET img_item = :img 
        WHERE id_item = :id_item');

        try{
            $query->execute([
                'id_item'   => $this->id,
                'img'  => $this->img
                ]);

            return true;
        }catch(PDOException $e){
            error_log('ItemsModel::updateImg->PDOException ' . $e);
        }

        return false;
    }

    public function delete($id){
        //error_log('ItemsModel::delete-> EJECUTO ');

        $query = $this->prepare(
        'DELETE 
        FROM items 
        WHERE id_item = :id');

        try{
            $query->execute(['id' => $id]);

            return true;
        }catch(PDOException $e){
            error_log('ItemsModel::delete->PDOException ' . $e);
        }
        
        return false;
    }


    //DB get data-------------------------------------------------
    public function count(){
        //error_log('ItemsModel::count-> EJECUTO ');

        try{
            $query = $this->query(
            'SELECT COUNT(*) total 
            FROM items');
            
            $count = $query->fetch(PDO::FETCH_ASSOC)['total'];
            //error_log('ItemsModel::count-> '.$count);

            return $count;

        }catch(PDOException $e){
            error_log('ItemsModel::count->PDOException ' . $e);
        }
        
        return false;
    }

    public function countSearch($name, $type, $description){
        //error_log('ItemsModel::countSearch-> EJECUTO ');

        $query = $this->prepare(
        'SELECT COUNT(*) total 
        FROM items 
        WHERE name_item LIKE :name_item 
        AND type LIKE :type 
        AND description LIKE :description');

        try{
            $query->execute([
                'name_item' => '%'.$name.'%', 
                'type' => '%'.$type.'%', 
                'description' => '%'.$description.'%'
            ]);

            $count = $query->fetch(PDO::FETCH_ASSOC)['total'];
            //error_log('ItemsModel::countSearch-> '.$count);

            return $count;
        }catch(PDOException $e){
            error_log('ItemsModel::countSearch->PDOException ' . $e);
        }

        return false;
    }

    public function getItems($actualPage, $resultsPerPage){
        //error_log('ItemsModel::getItems-> EJECUTO ');

        $items_list = [];

        $query = $this->prepare(
        'SELECT * 
        FROM items 
        ORDER BY name_item
        LIMIT :rowActual, :resultsPerPage');

        $rowActual = ($actualPage - 1)*$resultsPerPage;

        try{
            $query->execute([
                'rowActual' => $rowActual, 
                'resultsPerPage' => $resultsPerPage
            ]);

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $items_list[] = $p;
            }

            return $items_list;
        }catch(PDOException $e){
            error_log('ItemsModel::getItems->PDOException ' . $e);
        }
        
        return false;
    }
    
    public function search($type, $name, $description, $orderBy, $actualPage, $resultsPerPage){
        //error_log('ItemsModel::search-> EJECUTO');
        
        $items_list = [];
        $rowActual = ($actualPage - 1)*$resultsPerPage;

        $query = $this->prepare(
        'SELECT * 
        FROM items 
        WHERE type LIKE :type 
        AND name_item LIKE :name_item 
        AND description LIKE :description 
        ORDER BY '.$orderBy.' 
        LIMIT :rowActual, :resultsPerPage');

        try{
            $query->execute([
            'type' => "%".$type."%", 
            'name_item' => "%".$name."%", 
            'description' => "%".$description."%", 
            'rowActual' => $rowActual, 
            'resultsPerPage' => $resultsPerPage
        ]);

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $items_list[] = $p;
            }

            return $items_list;
        }catch(PDOException $e){
            error_log('ItemsModel::search->PDOException ' . $e);
        }

        return false;
    }
    
    public function searchNames($name){
        //error_log('ItemsModel::searchNames-> EJECUTO');
        $list = "";

        $query = $this->prepare(
        'SELECT name_item 
        FROM items 
        WHERE name_item LIKE :name_item 
        LIMIT 30');

        try{
            $query->execute(['name_item' => "%".$name."%"]);

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $list = $list.$p['name_item'].",";
            }
            
            return rtrim($list, ",");
        }catch(PDOException $e){
            error_log('ItemsModel::searchNames->PDOException ' . $e);
        }

        return false;
    }
    
    public function searchIMG($name){
        //error_log('ItemsModel::searchID-> EJECUTO');

        $query = $this->prepare(
        'SELECT img_item 
        FROM items 
        WHERE name_item = :name_item');

        try{
            $query->execute(['name_item' => $name]);

            if($query->rowCount() > 0){
                $img = $query->fetch(PDO::FETCH_ASSOC)['img_item'];
                
                return $img;
            }
        }catch(PDOException $e){
            error_log('ItemsModel::searchIMG->PDOException ' . $e);
        }

        return false;
    }
    
    public function searchID($name){
        //error_log('ItemsModel::searchID-> EJECUTO');

        $query = $this->prepare(
        'SELECT id_item 
        FROM items 
        WHERE name_item = :name_item');

        try{
            $query->execute(['name_item' => $name]);

            if($query->rowCount() > 0){
                $id = $query->fetch(PDO::FETCH_ASSOC)['id_item'];
                
                return $id;
            }
        }catch(PDOException $e){
            error_log('ItemsModel::searchID->PDOException ' . $e);
        }

        return false;
    }


//tools--------------------------------------------------------
function deleteOldImg($id){
    //error_log('UserModel::deleteOldImg-> EJECUTO');
    $path = "assets/items/".$id.".";

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


//set-get----------------------------------------------------
public function setID($id){             $this->id = $id;}
public function setName($name){       $this->name = $name;}
public function setImg($img){       $this->img = $img;}
public function setType($type){       $this->type = $type;}
public function setDescription($description){ $this->description = $description;}

public function getID(){        return $this->id;}
public function getName(){     return    $this->name;}
public function getImg(){     return $this->img;}
public function getType(){     return $this->type;}
public function getDescription(){  return $this->description;}

}
?>