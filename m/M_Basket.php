<?php

require_once 'DataBase.php';

class M_Basket {
    
    function getProduct($idUser, $productId) {
        return $product = DataBase::getRow(
                                    'SELECT *, good_price * quantity AS total_price FROM basket INNER JOIN goods ON basket.id_good = goods.id_good
                                     WHERE id_user = :idUser AND goods.id_good = :productId AND id_order = :idOrder', 
                                    ['idUser' => $idUser, 'productId' => $productId, 'idOrder' => 0]
                                    );
    }

    function addProduct($idUser, $productId) {
        if ($this->getProduct($idUser, $productId) != NULL) {
            DataBase::update(
                        'UPDATE basket SET quantity = quantity + 1 WHERE id_user = :idUser AND id_good = :productId', 
                        ['idUser' => $idUser, 'productId' => $productId]
                    );
        } else {
            DataBase::insert(
                        'INSERT INTO basket (id_user, id_good, quantity, id_order) VALUES (:idUser, :productId, :quantity, :idOrder)', 
                        ['idUser' => $idUser, 'productId' => $productId, 'quantity' => 1, 'idOrder' => 0]
                    );
        }
    }

    function removeProduct($idUser, $productId, $isRemove) {
        if ($this->getProduct($idUser, $productId)['quantity'] > 1 && !$isRemove) {
            DataBase::update(
                        'UPDATE basket SET quantity = quantity - 1 WHERE id_user = :idUser AND id_good = :productId', 
                        ['idUser' => $idUser, 'productId' => $productId]
                    );

        }else{
            DataBase::delete(
                        'DELETE FROM basket WHERE id_user = :idUser AND id_good = :productId', 
                        ['idUser' => $idUser, 'productId' => $productId]
                    );
        }        
    }

    function sendOrder($idUser, $userName, $userPhone) {
        if ($userName && $userPhone) {
            DataBase::update(
                    'UPDATE user SET user_name = :userName, user_phone = :userPhone WHERE id_user = :idUser',
                    ['userName' => $userName, 'userPhone' => $userPhone, 'idUser' => $idUser]
                );
        }
        $amountOrder = $this->amountOrder($idUser);

        $idOrder = DataBase::insert(
                                'INSERT INTO orders (id_user, amount_order, data_create_order, id_order_status) 
                                VALUES (:idUser, :amountOrder, :dataCreateOrder, :idOrderStatus)', 
                                ['idUser' => $idUser, 'amountOrder' => $amountOrder['amount_order'], 'dataCreateOrder' => date('d.m.Y H:i:s'), 'idOrderStatus' => 1]
                            );
        DataBase::update(
                    'UPDATE basket SET id_order = :idOrder WHERE id_user = :idUser AND is_in_order = :inOrder', 
                    ['idOrder' => $idOrder, 'idUser' => $idUser, 'inOrder' => 0]
                );
        DataBase::update(
                    'UPDATE basket SET is_in_order = :inOrder WHERE id_user = :idUser', 
                    ['inOrder' => 1, 'idUser' => $idUser]
                );
    }

    function getCount($idUser) {
        $basket = DataBase::getRow(
                    'SELECT sum(quantity) as count_basket FROM basket WHERE id_user = :idUser AND id_order = :idOrder',
                    ['idUser' => $idUser, 'idOrder' => 0]
                );
        if ($basket['count_basket'] == null) return 0;
        return $basket['count_basket'];
    }

    function amountOrder($idUser) {
        $amountOrder = DataBase::getRow(
			'SELECT *, sum(good_price * quantity) as amount_order FROM basket 
			INNER JOIN goods ON basket.id_good = goods.id_good WHERE id_user = :idUser AND id_order = :idOrder', 
			['idUser' => $idUser, 'idOrder' => 0]
		);
		return $amountOrder;
    }
}