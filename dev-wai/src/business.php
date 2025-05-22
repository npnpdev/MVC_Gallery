<?php
use MongoDB\BSON\ObjectID;
use MongoDB\Driver\Exception\Exception as MongoDBException;

function get_db(){
    try {
        $mongo = new MongoDB\Client(
            "mongodb://localhost:27017/wai",
            [
                'username' => 'wai_web',
                'password' => 'w@i_w3b',
            ]);
        $db = $mongo->wai;
        return $db;
    } 
    catch (MongoDBException $e) {
        exit('Błąd połączenia z bazą danych: ' . $e->getMessage());
    }
}

function get_image($id){
    try {
        $db = get_db();
        return $db->images->findOne(['_id' => new ObjectID($id)]);
    } 
    catch (MongoDBException $e) {
        exit('Błąd pobierania obrazu: ' . $e->getMessage());
    }
}

function get_images(){
    try {
        $db = get_db();
        return $db->images->find()->toArray();
    } 
    catch (MongoDBException $e) {
        exit('Błąd pobierania obrazów: ' . $e->getMessage());
    }
}

function get_image_by_name($name){
    try {
        $db = get_db();
        return $db->images->findOne(['name' => $name]);
    } 
    catch (MongoDBException $e) {
        exit('Błąd pobierania obrazu po nazwie: ' . $e->getMessage());
    }
}

function get_image_name($id){
    try {
        $db = get_db();
        $image = $db->images->findOne(['_id' => new ObjectID($id)]);
        return $image['name'];
    } 
    catch (MongoDBException $e) {
        exit('Błąd pobierania nazwy obrazu: ' . $e->getMessage());
    }
}

function upload_image($image){
    try {
        $db = get_db();
        $db->images->insertOne($image);
    } 
    catch (MongoDBException $e) {
        exit('Błąd przesyłania obrazu: ' . $e->getMessage());
    }
}

function add_user($user){
    try {
        $db = get_db();
        $db->users->insertOne($user);
    } 
    catch (MongoDBException $e) {
        exit('Błąd dodawania nowego użytkownika: ' . $e->getMessage());
    }
}

function get_user_by_login($login){
    try {
        $db = get_db();
        $user = $db->users->findOne(['login' => $login]);
        return $user;
    } 
    catch (MongoDBException $e) {
        exit('Błąd pobierania użytkownika po loginie: ' . $e->getMessage());
    }
}

function get_user_name($id){
    try {
        $db = get_db();
        $objectID = new ObjectId($id);
        $user = $db->users->findOne(['_id' => $objectID]);
        return $user['login'];
    } 
    catch (MongoDBException $e) {
        exit('Błąd pobierania nazwy użytkownika: ' . $e->getMessage());
    }
}
?>