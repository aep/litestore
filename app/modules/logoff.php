<?php


function module()
{
    
    global $breadcrumb;    
    $breadcrumb->add(NAVBAR_TITLE_LOGOFF);

    
    //delete Guests from Database   
    
    if (($_SESSION['account_type'] == 1) && (DELETE_GUEST_ACCOUNT == 'true')) 
    {
        xtc_db_query("delete from ".TABLE_CUSTOMERS." where customers_id = '".$_SESSION['customer_id']."'");
        xtc_db_query("delete from ".TABLE_ADDRESS_BOOK." where customers_id = '".$_SESSION['customer_id']."'");
        xtc_db_query("delete from ".TABLE_CUSTOMERS_INFO." where customers_info_id = '".$_SESSION['customer_id']."'");
    }
    
    xtc_session_destroy();
    
    unset ($_SESSION['customer_id']);
    unset ($_SESSION['customer_default_address_id']);
    unset ($_SESSION['customer_first_name']);
    unset ($_SESSION['customer_country_id']);
    unset ($_SESSION['customer_zone_id']);
    unset ($_SESSION['comments']);
    unset ($_SESSION['user_info']);
    unset ($_SESSION['customers_status']);
    unset ($_SESSION['selected_box']);
    unset ($_SESSION['navigation']);
    unset ($_SESSION['shipping']);
    unset ($_SESSION['payment']);
    unset ($_SESSION['ccard']);
    // GV Code Start
    unset ($_SESSION['gv_id']);
    unset ($_SESSION['cc_id']);
    // GV Code End
    $_SESSION['cart']->reset();
    // write customers status guest in session again
    require (DIR_WS_INCLUDES.'write_customers_status.php');
    
    global $azrael;
    return $azrael->renderPreset('Wellcome');

}
?>
