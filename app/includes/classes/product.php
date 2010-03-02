<?php

/* -----------------------------------------------------------------------------------------
   $Id: product.php 1316 2005-10-21 15:30:58Z mz $ 

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2005 ReStore
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(Coding Standards); www.oscommerce.com 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class product {

	/**
	 * 
	 * Constructor
	 * 
	 */
	function product($pID = 0) {
		$this->pID = $pID;
		$this->useStandardImage=false;
		$this->standardImage='noimage.gif';
		if ($pID = 0) {
			$this->isProduct = false;
			return;
		}
		// query for Product
		$group_check = "";
		if (GROUP_CHECK == 'true') {
			$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
		}

		$fsk_lock = "";
		if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
			$fsk_lock = ' and p.products_fsk18!=1';
		}


        global $db;
        $product_query=$db->query("select COUNT(*) FROM ".TABLE_PRODUCTS." p,
										                                      ".TABLE_PRODUCTS_DESCRIPTION." pd
										                                      where p.products_status = '1'
										                                      and p.products_id = '".$this->pID."'
										                                      and pd.products_id = p.products_id
										                                      ".$group_check.$fsk_lock."
										                                      and pd.languages_id = '".(int) $_SESSION['languages_id']."'")->fetch();

		if (!$product_query["COUNT(*)"]) {
			$this->isProduct = false;
		} else {
			$this->isProduct = true;
            $product_query=$db->query("select * FROM ".TABLE_PRODUCTS." p,
										                                      ".TABLE_PRODUCTS_DESCRIPTION." pd
										                                      where p.products_status = '1'
										                                      and p.products_id = '".$this->pID."'
										                                      and pd.products_id = p.products_id
										                                      ".$group_check.$fsk_lock."
										                                      and pd.languages_id = '".(int) $_SESSION['languages_id']."'")->fetch();
			$this->data = xtc_db_fetch_array($product_query, true);
		}

	}

	/**
	 * 
	 *  Query for attributes count
	 * 
	 */

	function getAttributesCount() {

		$products_attributes_query = xtDBquery("select count(*) as total from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".$this->pID."' and patrib.options_id = popt.products_options_id and popt.languages_id = '".(int) $_SESSION['languages_id']."'");
		$products_attributes = xtc_db_fetch_array($products_attributes_query, true);
		return $products_attributes['total'];

	}

	/**
	 * 
	 * Query for reviews count
	 * 
	 */

	function getReviewsCount() {
		$reviews_query = xtDBquery("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".$this->pID."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."' and rd.reviews_text !=''");
		$reviews = xtc_db_fetch_array($reviews_query, true);
		return $reviews['total'];
	}

	/**
	 * 
	 * select reviews
	 * 
	 */

	function getReviews() {

		$data_reviews = array ();
		$reviews_query = xtDBquery("select
									                                 r.reviews_rating,
									                                 r.reviews_id,
									                                 r.customers_name,
									                                 r.date_added,
									                                 r.last_modified,
									                                 r.reviews_read,
									                                 rd.reviews_text
									                                 from ".TABLE_REVIEWS." r,
									                                 ".TABLE_REVIEWS_DESCRIPTION." rd
									                                 where r.products_id = '".$this->pID."'
									                                 and  r.reviews_id=rd.reviews_id
									                                 and rd.languages_id = '".$_SESSION['languages_id']."'
									                                 order by reviews_id DESC");
		if (xtc_db_num_rows($reviews_query, true)) {
			$row = 0;
			$data_reviews = array ();
			while ($reviews = xtc_db_fetch_array($reviews_query, true)) {
				$row ++;
				$data_reviews[] = array ('AUTHOR' => $reviews['customers_name'], 'DATE' => xtc_date_short($reviews['date_added']), 'RATING' => xtc_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.$reviews['reviews_rating'].'.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])), 'TEXT' => $reviews['reviews_text']);
				if ($row == PRODUCT_REVIEWS_VIEW)
					break;
			}
		}
		return $data_reviews;

	}

	/**
	 * 
	 * return model if set, else return name
	 * 
	 */

	function getBreadcrumbModel() {

		if ($this->data['products_model'] != "")
			return $this->data['products_model'];
		return $this->data['products_name'];

	}

	/**
	 * 
	 * get also purchased products related to current
	 * 
	 */

	function getAlsoPurchased() {
		global $xtPrice;

		$module_content = array ();

		$fsk_lock = "";
		if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
			$fsk_lock = ' and p.products_fsk18!=1';
		}
		$group_check = "";
		if (GROUP_CHECK == 'true') {
			$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
		}

		$orders_query = "select
				    p.products_fsk18,
				    p.products_id,
				    p.products_price,
				    p.products_tax_class_id,
				    pd.products_name,
				    p.products_vpe_id,
				    p.products_vpe_status,
				    p.products_vpe_value,
				    p.products_trading_unit
				    from ".TABLE_ORDERS_PRODUCTS." opa, ".TABLE_ORDERS_PRODUCTS." opb, ".TABLE_ORDERS." o, ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
				    where opa.products_id = '".$this->pID."'
				    and opa.orders_id = opb.orders_id
				    and opb.products_id != '".$this->pID."'														                                  and opb.products_id = p.products_id
				    and opb.orders_id = o.orders_id
				    and p.products_status = '1'
    				    and pd.languages_id = '".(int) $_SESSION['languages_id']."'
		                    and opb.products_id = pd.products_id
		                    ".$group_check."
		                    ".$fsk_lock."
		                    group by p.products_id order by o.date_purchased desc limit ".MAX_DISPLAY_ALSO_PURCHASED;
		
		$orders_query = xtDBquery($orders_query);
		while ($orders = xtc_db_fetch_array($orders_query, true)) {

			$module_content[] = $this->buildDataArray($orders);

		}

		return $module_content;

	}

	/**
	 * 
	 * 
	 *  Get Cross sells 
	 * 
	 * 
	 */
function getCrossSells() {
		global $xtPrice;

		$cs_groups = "SELECT products_xsell_grp_name_id FROM ".TABLE_PRODUCTS_XSELL." WHERE products_id = '".$this->pID."' GROUP BY products_xsell_grp_name_id";
		$cs_groups = xtDBquery($cs_groups);
		$cross_sell_data = array ();

		while ($cross_sells = xtc_db_fetch_array($cs_groups, true)) {

			$fsk_lock = '';
			if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
				$fsk_lock = ' and p.products_fsk18!=1';
			}
			$group_check = "";
			if (GROUP_CHECK == 'true') {
				$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
			}

				$cross_query = "select 
						    p.products_fsk18,
						    p.products_tax_class_id,
						    p.products_id,
						    pd.products_name,
						    pd.products_short_description,
						    p.products_fsk18,p.products_price,p.products_vpe_id,
						    p.products_vpe_status,
						    p.products_vpe_value,
                                    		    p.products_trading_unit, 
                                                    xp.sort_order from ".TABLE_PRODUCTS_XSELL." xp, ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
                                                    where xp.products_id = '".$this->pID."' and xp.xsell_id = p.products_id ".$fsk_lock.$group_check."
		                                    and p.products_id = pd.products_id and xp.products_xsell_grp_name_id='".$cross_sells['products_xsell_grp_name_id']."'
		                                    and pd.languages_id = '".$_SESSION['languages_id']."'
		                                    and p.products_status = '1'
		                                    order by xp.sort_order asc";

			$cross_query = xtDBquery($cross_query);
			if (xtc_db_num_rows($cross_query, true) > 0)
				$cross_sell_data[$cross_sells['products_xsell_grp_name_id']] = array ('GROUP' => xtc_get_cross_sell_name($cross_sells['products_xsell_grp_name_id']), 'PRODUCTS' => array ());

			while ($xsell = xtc_db_fetch_array($cross_query, true)) {

				$cross_sell_data[$cross_sells['products_xsell_grp_name_id']]['PRODUCTS'][] = $this->buildDataArray($xsell);
			}

		}
		return $cross_sell_data;

	}
	
	
	/**
	 * 
	 * get reverse cross sells
	 * 
	 */
	 
	 function getReverseCrossSells() {
	 			global $xtPrice;


			$fsk_lock = '';
			if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
				$fsk_lock = ' and p.products_fsk18!=1';
			}
			$group_check = "";
			if (GROUP_CHECK == 'true') {
				$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
			}

			$cross_query = xtDBquery("select 
			                             p.products_fsk18,
						     p.products_tax_class_id,
						     p.products_id,
						     pd.products_name,
						     pd.products_short_description,
						     p.products_fsk18,p.products_price,p.products_vpe_id,
						     p.products_vpe_status,
						     p.products_vpe_value,  
                                                     p.products_trading_unit,
						     xp.sort_order from ".TABLE_PRODUCTS_XSELL." xp, ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
						     where xp.xsell_id = '".$this->pID."' and xp.products_id = p.products_id ".$fsk_lock.$group_check."
						     and p.products_id = pd.products_id
						     and pd.languages_id = '".$_SESSION['languages_id']."'
						       and p.products_status = '1'
                                                     order by xp.sort_order asc");

			while ($xsell = xtc_db_fetch_array($cross_query, true)) {

				$cross_sell_data[] = $this->buildDataArray($xsell);
			}


		return $cross_sell_data;
	 	
	 	
	 	
	 }
	


	function isProduct() {
		return $this->isProduct;
	}
	
	function getVPEtext($product, $price) {
		global $xtPrice;

		require_once (DIR_FS_INC.'xtc_get_vpe_name.inc.php');

		if (!is_array($product))
			$product = $this->data;

		if ($product['products_vpe_status'] == 1 && $product['products_vpe_value'] != 0.0 && $price > 0) {
			return $xtPrice->xtcFormat($price * (1 / $product['products_vpe_value']), true).TXT_PER.xtc_get_vpe_name($product['products_vpe_id']);
		}

		return;

	}
	

	function buildDataArray(&$array,$image='thumbnail') 
    {
        global $xtPrice,$main,$PHP_SELF;
        $tax_rate = $xtPrice->TAX[$array['products_tax_class_id']];

        $products_price = $xtPrice->xtcGetPrice($array['products_id'], $format = true, 1, $array['products_tax_class_id'], $array['products_price'], 1);


        $products_prices = $xtPrice->xtcGetPrices($array['products_id'],$_SESSION['customers_status']['customers_status_id'],
                                                  $format = true, 1, $array['products_tax_class_id'], $array['products_price'], 1);

        if ($_SESSION['customers_status']['customers_status_show_price'] != '0') 
        {
            if (($_SESSION['customers_status']['customers_fsk18'] == '0') || ($array['products_fsk18'] == '0'))
            {
                $buy_now =
                    $_GET["path"].'?action=buy_now&amp;BUYproducts_id='.$array['products_id'].xtc_get_all_get_params(array ('action'));

            }
        }
			

		
			$shipping_status_name = $main->getShippingStatusName($array['products_shippingtime']);
			$shipping_status_image = $main->getShippingStatusImage($array['products_shippingtime']);
		
		

    
        $prod_name_stripped = ereg_replace("[^A-Za-z0-9]", "_", $array["products_name"] );


		return array ('PRODUCTS_NAME' => $array['products_name'], 
				'COUNT'=>$array['ID'],
				'PRODUCTS_ID'=>$array['products_id'],
				'PRODUCTS_MODEL'=>$array['products_model'],
				'PRODUCTS_VPE' => $this->getVPEtext($array, $products_price['plain']), 
				'PRODUCTS_VPE_NAME' => xtc_get_vpe_name($array['products_vpe_id']), 
				'PRODUCTS_IMAGE' => $array['image_url'], 
				'PRODUCTS_LINK' => "/products/".$array['products_id']."/".$prod_name_stripped,
				'PRODUCTS_PRICE' => $products_price['formated'], 
				'PRODUCTS_PRICES' => $products_prices, 
				'PRODUCTS_TAX_INFO' => $main->getTaxInfo($tax_rate), 
				'PRODUCTS_SHIPPING_LINK' => $main->getShippingLink(), 
				'PRODUCTS_BUY_LINK' => $buy_now,
				'PRODUCTS_SHIPPING_NAME'=>$shipping_status_name,
				'PRODUCTS_SHIPPING_IMAGE'=>$shipping_status_image, 
				'PRODUCTS_DESCRIPTION' => $array['products_description'],
				'PRODUCTS_EXPIRES' => $array['expires_date'],
				'PRODUCTS_CATEGORY_URL'=>$array['cat_url'],
				'PRODUCTS_SHORT_DESCRIPTION' => $array['products_short_description'], 
				'PRODUCTS_FSK18' => $array['products_fsk18'],
				'PRODUCTS_TRADING_UNIT' => $array['products_trading_unit'],
                'ALLOWED_TO_SEE_PRICE' => ($xtPrice->cStatus['customers_status_show_price'] != '0')
                );
}

	
}
?>
