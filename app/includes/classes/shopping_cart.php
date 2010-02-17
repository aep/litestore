<?php

/* -----------------------------------------------------------------------------------------
   $Id: shopping_cart.php 1534 2006-08-20 19:39:22Z mz $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(shopping_cart.php,v 1.32 2003/02/11); www.oscommerce.com
   (c) 2003	 nextcommerce (shopping_cart.php,v 1.21 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:

   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once (DIR_FS_INC.'xtc_create_random_value.inc.php');
require_once (DIR_FS_INC.'xtc_get_prid.inc.php');
require_once (DIR_FS_INC.'xtc_draw_form.inc.php');
require_once (DIR_FS_INC.'xtc_draw_input_field.inc.php');
require_once (DIR_FS_INC.'xtc_get_tax_description.inc.php');

class shoppingCart {
    var $contents, $total, $weight, $cartID, $content_type;

	function shoppingCart() {
		$this->reset();
	}
    function attributes_price(){
        return 0;
    }
    function count_contents_virtual(){
        return 0;
    }

	function restore_contents() {
		if (!isset ($_SESSION['customer_id']))
			return false;

		// insert current cart contents in database
		if (is_array($this->contents)) {
			reset($this->contents);
            foreach($this->contents as $a){

                global $db;
                $q=$db->prepare("select count(*)  from customers_basket where customers_id=? and products_id=? and prices_id=?");
                $q->execute(array($_SESSION['customer_id'], $a['products_id'],$a['prices_id']));
                $q=$q->fetch();

				if (($q['count(*)']<1)) {
                    $q=$db->prepare("insert into customers_basket (customers_id, products_id, "
                                    ."customers_basket_quantity, customers_basket_date_added,prices_id) values (?,?,?,?,?)");
                    $q->execute(array($_SESSION['customer_id'],$a['products_id'],$a['quantity'],date('Ymd'),$a['prices_id']));
				} else {
                    $q=$db->prepare("update customers_basket_quantity = ? where customers_id = ? and products_id= ? and prices_id = ?");
                    $q->execute(array($a['quantity'],$_SESSION['customer_id'],$a['products_id'],$a['prices_id']));
				}
			}
		}
		// reset per-session cart contents, but not the database contents
		$this->reset(false);

		$products_query = xtc_db_query("select products_id,prices_id, customers_basket_quantity as quantity "
                                       ."from customers_basket where customers_id = '".$_SESSION['customer_id']."'");
		while ($products = xtc_db_fetch_array($products_query)) {
			$this->contents[$products['products_id'].' '.$products['prices_id']] = $products;
		}

		$this->cleanup();
	}

	function reset($reset_database = false) {

		$this->contents = array ();
		$this->total = 0;
		$this->weight = 0;
		$this->content_type = false;

		if (isset ($_SESSION['customer_id']) && ($reset_database == true)) {
			xtc_db_query("delete from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".$_SESSION['customer_id']."'");
		}

		unset ($this->cartID);
		if (isset ($_SESSION['cartID']))
			unset ($_SESSION['cartID']);
	}

	function add_cart($products_id,  $prices_id, $qty = '1', $attributes = '', $notify = true){
        global $new_products_id_in_cart;
        global $db;

        //make sure the TU is not compromised
        $q=$db->prepare("select quantity from prices where prices_id=?");
        $q->execute(array($prices_id));
        $q=$q->fetch();
        $q=$q["quantity"];
        if($q){
            $qty=round($qty  / $q) * $q;
        }

        $products_id = xtc_get_uprid($products_id, $attributes);
        if ($notify == true){
            $_SESSION['new_products_id_in_cart'] = $products_id;
        }

        if ($this->in_cart($products_id, $prices_id)){
            $this->update_quantity($products_id, $prices_id, $qty, $attributes);
        }
        else{
            $this->contents["$products_id $prices_id"] = array ('products_id'=>$products_id,'prices_id'=>$prices_id, 'quantity' => $qty);

			// insert into database
			if (isset ($_SESSION['customer_id'])){
                $q=$db->prepare('insert into customers_basket (customers_id, products_id, customers_basket_quantity, customers_basket_date_added,prices_id) values (?,?,?,?,?)');
                $q->execute(array($_SESSION['customer_id'],$products_id,$qty,date('Ymd'),$prices_id));
            }
		}
		$this->cleanup();
		// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
		$this->cartID = $this->generate_cart_id();
	}

	function update_quantity($products_id,$prices_id, $quantity = '', $attributes = '') {
		if (empty ($quantity))
			return true; // nothing needs to be updated if theres no quantity, so we return true..

        $this->contents["$products_id $prices_id"]['quantity'] = $qty;
		// update database
		if (isset ($_SESSION['customer_id'])){
            global $db;
            $q=$db->prepare('update customers_basket set customers_basket_quantity=? where customers_id=? and products_id=? and prices_id=?');
            $q->execute(array($quantity,$_SESSION['customer_id'],$products_id,$prices_id));
        }
	}

	function cleanup() {
		reset($this->contents);
		while (list ($key,) = each($this->contents)) {
			if ($this->contents[$key]['quantity'] < 1) {
                $a=$this->contents[$key];
				unset ($this->contents[$key]);
				// remove from database
				if (xtc_session_is_registered('customer_id')) {
                    global $db;
                    $q=$db->prepare('delete from customers_basket where customers_id = ?  and products_id = ? and prices_id = ? ');
                    $q->execute($_SESSION['customer_id'],$a['products_id'],$a['prices_id']);
				}
			}
		}
	}

	function count_contents() { // get total number of items in cart 
		$total_items = 0;
		if (is_array($this->contents)) {
			reset($this->contents);
            foreach($this->contents as $a){
				$total_items += $a['quantity'];
			}
		}
		return $total_items;
	}

	function get_quantity($products_id,$prices_id) {
		if (isset ($this->contents["$products_id $prices_id"])) {
			return $this->contents["$products_id $prices_id"]['quantity'];
		} else {
			return 0;
		}
	}

	function in_cart($products_id,$prices_id) {
		if (isset ($this->contents["$products_id $prices_id"])) {
			return true;
		} else {
			return false;
		}
	}

	function remove($products_id,$prices_id) {
		$this->contents["$products_id $prices_id"]= NULL;
		// remove from database
		if (xtc_session_is_registered('customer_id')) {
            global $db;
            $q=$db->prepare('delete from customers_basket where customers_id = ?  and products_id = ? and prices_id = ? ');
            $q->execute($_SESSION['customer_id'],$aproducts_id,$prices_id);
		}

		// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
		$this->cartID = $this->generate_cart_id();
	}

	function remove_all() {
		$this->reset();
	}

	function get_product_id_list() {
		$product_id_list = '';
		if (is_array($this->contents)) {
			reset($this->contents);
            foreach ($this->contents as $a){
				$product_id_list .= ', '.$a['products_id'];
			}
		}
		return substr($product_id_list, 2);
	}

	function calculate() {
		global $xtPrice;
		$this->total = 0;
		$this->weight = 0;
		$this->tax = array ();
		if (!is_array($this->contents))
			return 0;


        $stati=array();
        global $db;
        $q=$db->prepare("select products_id,products_status from products");
        $q->execute();
        while($x=$q->fetch()){
            $stati[$x['products_id']]=$x['products_status'];
        }

		reset($this->contents);
        foreach( $this->contents as $a) {

            $products_id=$a['products_id'];

            if(!$stati[$a['products_id']]){
                continue;
            }

			$qty = $a['quantity'];
			// products price
			$product_query = xtc_db_query("select products_id, products_price, products_discount_allowed, products_tax_class_id, products_weight from ".TABLE_PRODUCTS." where products_id='".xtc_get_prid($products_id)."'");
			if ($product = xtc_db_fetch_array($product_query)) {
				$products_price = $xtPrice->xtcGetPrice($product['products_id'], $format = false, $qty, $product['products_tax_class_id'], 0,0,0,$a['prices_id']);
				$this->total += $products_price * $qty;
				$this->weight += ($qty * $product['products_weight']);
							// attributes price
				$attribute_price = 0;
				if ($product['products_tax_class_id'] != 0) {
					if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
						$products_price_tax = $products_price - ($products_price / 100 * $_SESSION['customers_status']['customers_status_ot_discount']);
						$attribute_price_tax = $attribute_price - ($attribute_price / 100 * $_SESSION['customers_status']['customers_status_ot_discount']);
					}
					$products_tax = $xtPrice->TAX[$product['products_tax_class_id']];
					$products_tax_description = xtc_get_tax_description($product['products_tax_class_id']);

					// price incl tax
					if ($_SESSION['customers_status']['customers_status_show_price_tax'] == '1') {
						if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
							$this->tax[$product['products_tax_class_id']]['value'] += ((($products_price_tax+$attribute_price_tax) / (100 + $products_tax)) * $products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = TAX_ADD_TAX."$products_tax_description";
						} else {
							$this->tax[$product['products_tax_class_id']]['value'] += ((($products_price+$attribute_price) / (100 + $products_tax)) * $products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = TAX_ADD_TAX."$products_tax_description";
						}
					}
					// excl tax + tax at checkout
					if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
						if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
							$this->tax[$product['products_tax_class_id']]['value'] += (($products_price_tax+$attribute_price_tax) / 100) * ($products_tax)*$qty;
							$this->total+=(($products_price_tax+$attribute_price_tax) / 100) * ($products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = TAX_NO_TAX."$products_tax_description";
						} else {
							$this->tax[$product['products_tax_class_id']]['value'] += (($products_price+$attribute_price) / 100) * ($products_tax)*$qty;
							$this->total+= (($products_price+$attribute_price) / 100) * ($products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = TAX_NO_TAX."$products_tax_description";
						}
					}
				}
			}

		}
	}

	function get_products() {
		global $xtPrice,$main;
		if (!is_array($this->contents))
			return false;

		$products_array = array ();
		reset($this->contents);
        foreach($this->contents as $a){
			if($a['quantity'] != 0 || $a['quantity'] !=''){
                $products_query = xtc_db_query("select p.products_id,p.products_status, pd.products_name,p.products_shippingtime, p.products_model, p.products_price, p.products_discount_allowed, p.products_weight, p.products_tax_class_id from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_id='".xtc_get_prid($a['products_id'])."' and pd.products_id = p.products_id and pd.languages_id = '".$_SESSION['languages_id']."'");
                if ($products = xtc_db_fetch_array($products_query)) {
                    $prid = $products['products_id'];
                    $products_price = $xtPrice->xtcGetPrice($products['products_id'], $format = false, $a['quantity'],
                                                            $products['products_tax_class_id'], 0,0,0,$a['prices_id']);

                    $products_array[] = array (
                                               'id' => $a['products_id'],
                                               'prices_id' => $a['prices_id'],
                                               'status' => $products['products_status'],
                                               'name' => $products['products_name'],
                                               'model' => $products['products_model'],
                                               'image' => $products['products_image'],
                                               'price' => $products_price,
                                               'quantity' => $a['quantity'],
                                               'weight' => $products['products_weight'],
                                               'shipping_time' => $main->getShippingStatusName($products['products_shippingtime']),
                                               'final_price' => $products_price,
                                               'tax_class_id' => $products['products_tax_class_id']
                                               );
                }
			}
		}

		return $products_array;
	}

	function show_total() {
		$this->calculate();

		return $this->total;
	}

	function show_weight() {
		$this->calculate();

		return $this->weight;
	}

	function show_tax($format = true) {
		global $xtPrice;
		$this->calculate();
		$output = "";
		$val=0;
		foreach ($this->tax as $key => $value) {
			if ($this->tax[$key]['value'] > 0 ) {
			$output .= $this->tax[$key]['desc'].": ".$xtPrice->xtcFormat($this->tax[$key]['value'], true)."<br />";
			$val = $this->tax[$key]['value'];
			}
		}
		if ($format) {
		return $output;
		} else {
			return $val;
		}
	}

	function generate_cart_id($length = 5) {
		return xtc_create_random_value($length, 'digits');
	}

	function get_content_type() {
        $this->content_type = 'physical';
		return $this->content_type;
	}

	function unserialize($broken) {
		for (reset($broken); $kv = each($broken);) {
			$key = $kv['key'];
			if (gettype($this-> $key) != "user function")
				$this-> $key = $kv['value'];
		}
	}
}
?>
