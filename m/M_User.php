<?php
require_once 'DataBase.php';

class M_User {

    function getUser($login) {
        return DataBase::getRow(
            'SELECT * FROM user WHERE user_login = :user_login', 
            ['user_login' => $login]
        );
    }

    function regUser($userName, $login, $password, $phone, $idUser ) {
        DataBase::insert(
            'UPDATE user SET user_name = :userName, user_login = :userLogin, user_password = :passwordHash, user_phone = :userPhone WHERE id_user = :idUser', 
            ['userName' => $userName, 'userLogin' => $login, 'passwordHash' => $password, 'userPhone' => $phone, 'idUser' => $idUser]
            // 'INSERT INTO user (user_name, user_login, user_password, user_phone, user_role) VALUES (:userName, :userLogin, :passwordHash, :userPhone, ::userRole)', ['userName' => $userName, 'userLogin' => $userLogin, 'passwordHash' => $passwordHash],
            // ['userName' => $userName, 'userLogin' => $login, 'passwordHash' => $password, 'userPhone' => $phone, 'user_role'=> $role, 'idUser' => $idUser]
        );
    }

    function changeName($userName, $idUser) {
        DataBase::update(
            'UPDATE user SET user_name = :userName WHERE id_user = :idUser', 
            ['userName' => $userName, 'idUser' => $idUser]
        );
    }
}