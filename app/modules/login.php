<?php
/* -----------------------------------------------------------------------------------------
   $Id: login.php 1143 2005-08-11 11:58:59Z gwinger $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(login.php,v 1.79 2003/05/19); www.oscommerce.com 
   (c) 2003      nextcommerce (login.php,v 1.13 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   guest account idea by Ingo T. <xIngox@web.de>
   ---------------------------------------------------------------------------------------*/
function module()
{
    global $session_started;
    
    if (isset ($_SESSION['customer_id']))
    {
        xtc_redirect(xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
    }
    require_once (DIR_FS_INC.'xtc_validate_password.inc.php');
    require_once (DIR_FS_INC.'xtc_array_to_string.inc.php');
    require_once (DIR_FS_INC.'xtc_write_user_info.inc.php');
    // redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
    if ($session_started == false)
    {
        xtc_redirect(xtc_href_link(FILENAME_COOKIE_USAGE));
    }
    
    if (isset ($_POST['email_address']))
    {
        global $db;
        $sth = $db->prepare("select customers_id, customers_vat_id, customers_firstname,customers_lastname, customers_gender, customers_password, customers_email_address, customers_default_address_id from ".TABLE_CUSTOMERS." where ( customers_email_address = :mail or  customers_cid = :mail )  and account_type = '0'");
        $sth->execute(array(':mail' => $_POST['email_address']));
        $check_customer = $sth->fetch();
        if (!$check_customer )
        {
            $_GET['login'] = 'fail';
            //we don't like getting probed. XTC can do that all day if they like it....
            $info_message = /*TEXT_NO_EMAIL_ADDRESS_FOUND*/TEXT_LOGIN_ERROR;
        }
        else
        {
            // Check that password is good
            if ($_POST['password'] != $check_customer['customers_password'])
            {
                $_GET['login'] = 'fail';
                $info_message = TEXT_LOGIN_ERROR;
            }
            else 
            {
                if (SESSION_RECREATE == 'True') 
                {
                    xtc_session_recreate();
                }
                $check_country_query = xtc_db_query("select entry_country_id, entry_zone_id from ".TABLE_ADDRESS_BOOK." where customers_id = '".(int) $check_customer['customers_id']."' and address_book_id = '".$check_customer['customers_default_address_id']."'");
                $check_country = xtc_db_fetch_array($check_country_query);
    
                $_SESSION['customer_gender'] = $check_customer['customers_gender'];
                $_SESSION['customer_first_name'] = $check_customer['customers_firstname'];
                $_SESSION['customer_last_name'] = $check_customer['customers_lastname'];
                $_SESSION['customer_id'] = $check_customer['customers_id'];
                $_SESSION['customer_vat_id'] = $check_customer['customers_vat_id'];
                $_SESSION['customer_default_address_id'] = $check_customer['customers_default_address_id'];
                $_SESSION['customer_country_id'] = $check_country['entry_country_id'];
                $_SESSION['customer_zone_id'] = $check_country['entry_zone_id'];
    
                $date_now = date('Ymd');
    
                xtc_db_query("update ".TABLE_CUSTOMERS_INFO." SET customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1 WHERE customers_info_id = '".(int) $_SESSION['customer_id']."'");
                xtc_write_user_info((int) $_SESSION['customer_id']);
                // restore cart contents
                $_SESSION['cart']->restore_contents();
                if (is_object($econda)) 
                    $econda->_loginUser();
    
                if ($_SESSION['cart']->count_contents() > 0) 
                {
                    xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
                } 
                else 
                {
                    xtc_redirect(xtc_href_link(FILENAME_DEFAULT));
                }
            }
        }
    }
    global $breadcrumb;
    $breadcrumb->add(NAVBAR_TITLE_LOGIN, "/login");
    
    $smarty = new Smarty;
    $smarty->assign('info_message', $info_message);
    $smarty->assign('account_option', ACCOUNT_OPTIONS);
    $smarty->assign('URI_NEW_ACCOUNT', xtc_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
    $smarty->assign('URI_GUEST', xtc_href_link(FILENAME_CREATE_GUEST_ACCOUNT, '', 'SSL'));
    $smarty->assign('LINK_LOST_PASSWORD', xtc_href_link(FILENAME_PASSWORD_DOUBLE_OPT, '', 'SSL'));
    
    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = 0;
    return $smarty->fetch('module/login.html');
}

?>
