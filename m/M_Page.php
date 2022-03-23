<?php

require_once 'DataBase.php';

class M_Page {

    function getGoods($countGoods) {
        return $goods = DataBase::getRows(
                            'SELECT * FROM goods INNER JOIN good_img_path ON id_good_img_path = id WHERE id_good <= :countGoods AND in_catalog = :inCatalog',
                            ['countGoods' => $countGoods, 'inCatalog' => 1]
                        );
    }

    function getMoreGoods($countGoods) {
        return $goods = DataBase::getRows(
			                'SELECT * FROM goods INNER JOIN good_img_path ON id_good_img_path = id WHERE id_good > :countGood AND id_good <= :countMore AND in_catalog = :inCatalog',
			                ['countGood' => $countGoods, 'countMore' => $countGoods + 16, 'inCatalog' => 1]
		                );
    }

    

    function getOrders($idUser) {
        
        $userOrders = DataBase::getRows(
                        'SELECT * FROM orders INNER JOIN order_status ON orders.id_order_status = order_status.id_order_status
                         WHERE id_user = :idUser ORDER BY id_order DESC',
                        ['idUser' => $idUser]
                    );
        if (count($userOrders) != 0)
            return $userOrders;
        
            return false;
    }

    function getBasket($idUser) {
        return $userBasket = DataBase::getRows(
                                'SELECT *, good_price * quantity AS total_price FROM basket INNER JOIN goods ON basket.id_good = goods.id_good 
                                INNER JOIN good_img_path ON goods.id_good_img_path = good_img_path.id
                                WHERE id_user = :idUser AND id_order = :idOrder ORDER BY id_basket DESC', 
                                ['idUser' => $idUser, 'idOrder' => 0]
                            );
    }

    

    function getArchive() {
        return $goods = DataBase::getRows(
            'SELECT * FROM goods INNER JOIN good_img_path ON id_good_img_path = id WHERE in_catalog = :inCatalog',
            ['inCatalog' => false]
        );
    }

    function getUseOrders() {
        return $orders = DataBase::getRows(
                'SELECT * FROM orders INNER JOIN user ON orders.id_user = user.id_user
                INNER JOIN order_status ON orders.id_order_status = order_status.id_order_status'
                );
    }

    
}