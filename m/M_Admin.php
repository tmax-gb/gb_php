<?php

require_once 'DataBase.php';

class M_Admin {
    function addGood($goodVal) {
        return DataBase::insert(
            'INSERT INTO goods (good_name, good_price, good_description, id_good_img_path, in_catalog) VALUES (:goodName, :price, :descr, :imgPath, :inCatalog)', 
            ['goodName' => $goodVal[1], 'price' => $goodVal[2], 'descr' => $goodVal[3], 'imgPath' => 1, 'inCatalog' => true]
        );
    }

    function returnGood($productId) {
        DataBase::update('UPDATE goods SET in_catalog = true WHERE id_good = :productId', 
        ['productId' => $productId]
        );
    }

    function changeGood($productId, $goodVal) {
        DataBase::update('UPDATE goods SET good_name = :goodName, good_price = :price, good_description = :descr WHERE id_good = :productId', 
        ['goodName' => $goodVal[1], 'price' => $goodVal[2], 'descr' => $goodVal[3], 'productId' => $productId]
        );
    }

    function removeGood($productId) {
        DataBase::update('UPDATE goods SET in_catalog = false WHERE id_good = :productId', 
        ['productId' => $productId]
        );
    }

    function deleteGood($productId) {
        DataBase::delete(
            'DELETE FROM goods WHERE id_good = :productId', 
            ['productId' => $productId]
        );
    }

    function changeStatus($idOrder, $orderStatus) {
        DataBase::update('UPDATE orders SET id_order_status = :orderStatus WHERE id_order = :idOrder', 
        ['orderStatus' => $orderStatus, 'idOrder' => $idOrder]
        );
      
    }

    function getGood($productId) {
        return $good = DataBase::getRow(
                                    'SELECT * FROM goods INNER JOIN good_img_path ON id_good_img_path = id WHERE id_good = :productId',
                                    ['productId' => $productId]
                                );
    }

    function getStatus($idOrder) {
        return $status = DataBase::getRow(
                                     'SELECT order_status FROM orders INNER JOIN order_status 
                                     ON orders.id_order_status = order_status.id_order_status WHERE id_order = :idOrder', 
                                     ['idOrder' => $idOrder]
                                 );
     }
}