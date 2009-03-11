<?php


class Price
{

    var $products_id=null;
    var $customers_status=null;


    function Price($pid)
    {
        $this->products_id=$pid;
    }

    function setCustomerStatus($cs)
    {
        $this->customers_status=$cs;
    }


    function fetch()
    {
        global $db;

        $qr;    

        if($customers_status === null)
        {
            $qr=$db->prepare("select `price` from `prices` where `products_id`=?");
            $qr->execute(array($products_id));
        }
        else
        {
            $qr=$db->prepare("select `price` from `prices` where `customers_status`=? and  `products_id`=?");
            $qr->execute(array($customers_status,$products_id));
        }

        $qrr=$qr->fetchAll();

    }


};


?>
