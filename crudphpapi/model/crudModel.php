<?php

interface Crudinterface{

    // Get all users
    public function GetAll();

    // Get single user based on ID
    public function GetSingle();

    //Insert single user
    public function Insert();

    //Update single user
    public function Update();

    // Delete single user
    public function Delete();
}

class CrudModel{

    protected $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function GetAll(){
        $sql = "SELECT * FROM users";
        try{
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute()){
                $data =  $stmt->fetchAll();
                if ($stmt->rowCount() > 0){
                    return $data;
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    } 

    public function GetSingle($data){
        $sql = "SELECT * FROM users WHERE id = ?";
        try{
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->id])){
                $data =  $stmt->fetchAll();
                if ($stmt->rowCount() > 0){
                    return $data;
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function Insert($data){
        $sql = 'INSERT INTO users(firstname, lastname, is_admin) VALUES(?, ?, Default)';

        if (!isset($data->firstname) || !isset($data->lastname)) {
            return 'Invalid input';
        }

        if (empty($data->firstname) || empty($data->lastname)) {
            return 'Invalid input';
        }

        try{
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->firstname, $data->lastname])){
                return 'Data has been successfully added.';
            }else{
                return 'Data addition unsuccessful.';
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function Update($data){
        $sql = "UPDATE users SET firstname = ?, lastname = ?, is_admin = ? WHERE id = ?";

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->firstname, $data->lastname, $data->is_admin, $data->id])) {
                return 'Data has been successfully updated';
            } else {
                return 'Data update unsuccessful';         
               }
        } catch (PDOException $e) {
            return $e->getMessage();  
        }
    } 

    public function Delete($data){
        $sql = "DELETE FROM users WHERE id = ?";
    
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->id])) {
                return 'Data has been successfully deleted.';
            } else {
                return 'Data deletetion unsuccessful';
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}