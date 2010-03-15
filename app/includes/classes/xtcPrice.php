<?php


/* -----------------------------------------------------------------------------------------
   $Id: xtcPrice.php 1316 2005-10-21 15:30:58Z mz $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(currencies.php,v 1.15 2003/03/17); www.oscommerce.com
   (c) 2003         nextcommerce (currencies.php,v 1.9 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class xtcPrice {
	var $currencies;

	// class constructor
	function xtcPrice($currency, $cGroup) {

		$this->currencies = array ();
		$this->cStatus = array ();
		$this->actualGroup = $cGroup;
		$this->actualCurr = $currency;
		$this->TAX = array ();
		$this->SHIPPING = array();
		$this->showFrom_Attributes = true;

        global $db;
        $q=$db->prepare('select * from currencies');
        $q->execute();
		while ($currencies = $q->fetch()) {
			$this->currencies[$currencies['code']] = $currencies;
		}

        $q=$db->prepare('select * from customers_status where customers_status_id=? and languages_id=?');
        $q->execute(array($this->actualGroup,$_SESSION['languages_id']));
		$customers_status_value = $q->fetch();

		$this->cStatus = array (
                                'customers_status_id' => $this->actualGroup,
                                'customers_status_name' => $customers_status_value['customers_status_name'],
                                'customers_status_image' => $customers_status_value['customers_status_image'],
                                'customers_status_public' => $customers_status_value['customers_status_public'],
                                'customers_status_discount' => $customers_status_value['customers_status_discount'],
                                'customers_status_ot_discount_flag' => $customers_status_value['customers_status_ot_discount_flag'],
                                'customers_status_ot_discount' => $customers_status_value['customers_status_ot_discount'],
                                'customers_status_graduated_prices' => $customers_status_value['customers_status_graduated_prices'],
                                'customers_status_show_price' => $customers_status_value['customers_status_show_price'],
                                'customers_status_show_price_tax' => $customers_status_value['customers_status_show_price_tax'],
                                'customers_status_add_tax_ot' => $customers_status_value['customers_status_add_tax_ot'],
                                'customers_status_payment_unallowed' => $customers_status_value['customers_status_payment_unallowed'],
                                'customers_status_shipping_unallowed' => $customers_status_value['customers_status_shipping_unallowed'],
                                'customers_status_discount_attributes' => $customers_status_value['customers_status_discount_attributes'],
                                'customers_fsk18' => $customers_status_value['customers_fsk18'],
                                'customers_fsk18_display' => $customers_status_value['customers_fsk18_display']
                                );

        $q=$db->prepare('select tax_class_id as class from tax_class');
        $q->execute();
		while ($zones_data = $q->fetch()) {
			// calculate tax based on shipping or deliverey country (for downloads)
			if (isset($_SESSION['billto']) && isset($_SESSION['sendto'])){
                $q=$db->prepare('select ab.entry_country_id, ab.entry_zone_id from address_book ab left join zones '
                                                  .' z on (ab.entry_zone_id = z.zone_id) where ab.customers_id = ? and ab.address_book_id = ?');
                $q->execute(array($_SESSION['customer_id'],($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto'])));
                $tax_address = $q->fetch();
                $this->TAX[$zones_data['class']]=xtc_get_tax_rate($zones_data['class'],$tax_address['entry_country_id'], $tax_address['entry_zone_id']);				
			} else {
                $this->TAX[$zones_data['class']]=xtc_get_tax_rate($zones_data['class']);
			}
		}
	}



    function _priceFromQ($q,$format){
        $n=$q['price'];
        // add tax
        if ($this->cStatus['customers_status_show_price_tax'] != '0'){
            $n= $this->xtcAddTax($n,$this->TAX[$tax_class]);
        }
        //format
        if($format){
            if($q['show_old_price']>0){
                $o=$q['show_old_price'];
                if ($this->cStatus['customers_status_show_price_tax'] != '0'){
                    $o= $this->xtcAddTax($o,$this->TAX[$tax_class]);
                }
                $q["price"]=array(
                                  'plain'=>$n,
                                  'formated'=>   $this->xtcFormat($n, $format).'<br >'
                                  .'<span class="productOldPrice">'.$this->xtcFormat($o, $format).'</span>'
                                  .' -'.round((($o-$n)/$o)*100).'%'
                                  );
            }else{
                $q["price"]=array('plain'=>$n,'formated'=>$this->xtcFormat($n, $format, 0, false, null, $q['products_id']));
            }
        }else{
            //xtc compatbility hack;
            return $n;
        }
        return $q;
    }


	function idPrice($pricesID, $format = true, $qty, $tax_class) {
        // check if group is allowed to see prices
        if ($this->cStatus['customers_status_show_price'] == '0')
            return null;

        global $db;
        $q=$db->prepare("select prices_id,quantity,price,show_old_price from prices where prices_id=?");
        $q->execute(array($pricesID));
        $r=$q->fetch();
        return $this->_priceFromQ($r,$format);
    }

	function productPrices($productsID,$customer_status_id, $format = true, $qty, $tax_class) {
        // check if group is allowed to see prices
        if ($this->cStatus['customers_status_show_price'] == '0')
            return null;

        global $db;

        $q=$db->prepare("select price_group_id from customers_status_price_group where customers_status_id=?");
        $q->execute(array($customer_status_id));

        $a = array();
        while ($pg=$q->fetch()){
            $q2=$db->prepare("select prices_id,quantity,price,show_old_price from prices where price_group_id=? and products_id=?");
            $q2->execute(array($pg["price_group_id"],$productsID));

            while ($r=$q2->fetch()){
                $a[]=$this->_priceFromQ($r,$format);
            }
        }
        return $a;

	}

	function getPprice($pID) {
		$pQuery = "SELECT products_price FROM ".TABLE_PRODUCTS." WHERE products_id='".$pID."'";
		$pQuery = xtDBquery($pQuery);
		$pData = xtc_db_fetch_array($pQuery, true);
		return $pData['products_price'];
	}

	function xtcAddTax($price, $tax) {
		$price = $price + $price / 100 * $tax;
		$price = $this->xtcCalculateCurr($price);
		return round($price, $this->currencies[$this->actualCurr]['decimal_places']);
	}

	function xtcCheckDiscount($pID) {

		// check if group got discount
		if ($this->cStatus['customers_status_discount'] != '0.00') {

			$discount_query = "SELECT products_discount_allowed FROM ".TABLE_PRODUCTS." WHERE products_id = '".$pID."'";
			$discount_query = xtDBquery($discount_query);
			$dData = xtc_db_fetch_array($discount_query, true);

			$discount = $dData['products_discount_allowed'];
			if ($this->cStatus['customers_status_discount'] < $discount)
				$discount = $this->cStatus['customers_status_discount'];
			if ($discount == '0.00')
				return false;
			return $discount;

		}
		return false;
	}

	function xtcGetGraduatedPrice($pID, $qty) {
		if (GRADUATED_ASSIGN == 'true')
			if (xtc_get_qty($pID) > $qty)
				$qty = xtc_get_qty($pID);
		//if (!is_int($this->cStatus['customers_status_id']) && $this->cStatus['customers_status_id']!=0) $this->cStatus['customers_status_id'] = DEFAULT_CUSTOMERS_STATUS_ID_GUEST;
		$graduated_price_query = "SELECT max(quantity) as qty
				                                FROM prices
				                                WHERE products_id='".$pID."'
                                                and customers_status_id='".$this->actualGroup."'
				                                AND quantity<='".$qty."'";
		$graduated_price_query = xtDBquery($graduated_price_query);
		$graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);
		if ($graduated_price_data['qty']) {
			$graduated_price_query = "SELECT price as personal_offer
						                                FROM prices
						                                WHERE products_id='".$pID."'
                                                        and customers_status_id='".$this->actualGroup."'
						                                AND quantity='".$graduated_price_data['qty']."'";
			$graduated_price_query = xtDBquery($graduated_price_query);
			$graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);

			$sPrice = $graduated_price_data['personal_offer'];
			if ($sPrice != 0.00)
				return $sPrice;
		} else {
			return;
		}

	}

	function xtcGetOptionPrice($pID, $option, $value) {
		$attribute_price_query = "select pd.products_discount_allowed,pd.products_tax_class_id, p.options_values_price, p.price_prefix, p.options_values_weight, p.weight_prefix from ".TABLE_PRODUCTS_ATTRIBUTES." p, ".TABLE_PRODUCTS." pd where p.products_id = '".$pID."' and p.options_id = '".$option."' and pd.products_id = p.products_id and p.options_values_id = '".$value."'";
		$attribute_price_query = xtDBquery($attribute_price_query);
		$attribute_price_data = xtc_db_fetch_array($attribute_price_query, true);
		$dicount = 0;
		if ($this->cStatus['customers_status_discount_attributes'] == 1 && $this->cStatus['customers_status_discount'] != 0.00) {
			$discount = $this->cStatus['customers_status_discount'];
			if ($attribute_price_data['products_discount_allowed'] < $this->cStatus['customers_status_discount'])
				$discount = $attribute_price_data['products_discount_allowed'];
		}
		$price = $this->xtcFormat($attribute_price_data['options_values_price'], false, $attribute_price_data['products_tax_class_id']);
		if ($attribute_price_data['weight_prefix'] != '+')
			$attribute_price_data['options_values_weight'] *= -1;
		if ($attribute_price_data['price_prefix'] == '+') {
			$price = $price - $price / 100 * $discount;
		} else {
			$price *= -1;
		}
		return array ('weight' => $attribute_price_data['options_values_weight'], 'price' => $price);
	}

	function xtcShowNote($vpeStatus, $vpeStatus = 0) {
		if ($vpeStatus == 1)
			return array ('formated' => NOT_ALLOWED_TO_SEE_PRICES, 'plain' => 0);
		return NOT_ALLOWED_TO_SEE_PRICES;
	}

	function xtcCheckSpecial($pID) {
		$product_query = "select specials_new_products_price from ".TABLE_SPECIALS." where products_id = '".$pID."' and status=1";
		$product_query = xtDBquery($product_query);
		$product = xtc_db_fetch_array($product_query, true);

		return $product['specials_new_products_price'];

	}

	function xtcCalculateCurr($price) {
		return $this->currencies[$this->actualCurr]['value'] * $price;
	}

	function calcTax($price, $tax) {
		return $price * $tax / 100;
	}

	function xtcRemoveCurr($price) {

		// check if used Curr != DEFAULT curr
		if (DEFAULT_CURRENCY != $this->actualCurr) {
			return $price * (1 / $this->currencies[$this->actualCurr]['value']);
		} else {
			return $price;
		}

	}

	function xtcRemoveTax($price, $tax) {
		$price = ($price / (($tax +100) / 100));
		return $price;
	}

	function xtcGetTax($price, $tax) {
		$tax = $price - $this->xtcRemoveTax($price, $tax);
		return $tax;
	}
	
	function xtcRemoveDC($price,$dc) {
	
		$price = $price - ($price/100*$dc);
		
		return $price;	
	}
	
	function xtcGetDC($price,$dc) {
		
		$dc = $price/100*$dc;
	
		return $dc;	
	}

	function checkAttributes($pID) {
		if (!$this->showFrom_Attributes) return;
		if ($pID == 0)
			return;
		$products_attributes_query = "select count(*) as total from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".$pID."' and patrib.options_id = popt.products_options_id and popt.languages_id = '".(int) $_SESSION['languages_id']."'";
		$products_attributes = xtDBquery($products_attributes_query);
		$products_attributes = xtc_db_fetch_array($products_attributes, true);
		if ($products_attributes['total'] > 0)
			return ' '.strtolower(FROM).' ';
	}

	function xtcCalculateCurrEx($price, $curr) {
		return $price * ($this->currencies[$curr]['value'] / $this->currencies[$this->actualCurr]['value']);
	}

	/*
	*
	*    Format Functions
	*
	*
	*
	*/

	function xtcFormat($price, $format, $tax_class = 0, $curr = false, $vpeStatus = 0, $pID = 0) {

		if ($curr)
			$price = $this->xtcCalculateCurr($price);

		if ($tax_class != 0) {
			$products_tax = $this->TAX[$tax_class];
			if ($this->cStatus['customers_status_show_price_tax'] == '0')
				$products_tax = '';
			$price = $this->xtcAddTax($price, $products_tax);
		}

		if ($format) {
			$Pprice = number_format($price, $this->currencies[$this->actualCurr]['decimal_places'], $this->currencies[$this->actualCurr]['decimal_point'], $this->currencies[$this->actualCurr]['thousands_point']);
			$Pprice = $this->checkAttributes($pID).$this->currencies[$this->actualCurr]['symbol_left'].' '.$Pprice.' '.$this->currencies[$this->actualCurr]['symbol_right'];
			if ($vpeStatus == 0) {
				return $Pprice;
			} else {
				return array ('formated' => $Pprice, 'plain' => $price);
			}
		} else {

			return round($price, $this->currencies[$this->actualCurr]['decimal_places']);

		}

	}

	function xtcFormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus = 0) {
		$sPrice = $pPrice - ($pPrice / 100) * $discount;
		if ($format) {
			$price = '<span class="productOldPrice">'.INSTEAD.$this->xtcFormat($pPrice, $format).'</span><br >'.ONLY.$this->checkAttributes($pID).$this->xtcFormat($sPrice, $format).'<br >'.YOU_SAVE.$discount.'%';
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function xtcFormatSpecial($pID, $sPrice, $pPrice, $format, $vpeStatus = 0) {
		if ($format) {
			$price = '<span class="productOldPrice">'.INSTEAD.$this->xtcFormat($pPrice, $format).'</span><br >'.ONLY.$this->checkAttributes($pID).$this->xtcFormat($sPrice, $format);
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function xtcFormatSpecialGraduated($pID, $sPrice, $pPrice, $format, $vpeStatus = 0, $pID) {
		if ($pPrice == 0)
			return $this->xtcFormat($sPrice, $format, 0, false, $vpeStatus);
		if ($discount = $this->xtcCheckDiscount($pID))
			$sPrice -= $sPrice / 100 * $discount;
		if ($format) {
			if ($sPrice != $pPrice) {
				$price = '<span class="productOldPrice">'.MSRP.$this->xtcFormat($pPrice, $format).'</span><br >'.YOUR_PRICE.$this->checkAttributes($pID).$this->xtcFormat($sPrice, $format);
			} else {
				$price = FROM.$this->xtcFormat($sPrice, $format);
			}
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function get_decimal_places($code) {
		return $this->currencies[$this->actualCurr]['decimal_places'];
	}

}
?>
