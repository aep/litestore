<?php

$APP_PATH=split('/',$_GET["path"]);



include ('includes/application_top.php');
require_once (DIR_FS_INC.'aep.php');



$routes=array
(
    '/catalog'                  =>  'catalog.php',
    '/checkout/process'         =>  'checkout_process.php',
    '/checkout/success'         =>  'checkout_success.php',
    '/checkout/confirmation'    =>  'checkout_confirmation.php',
    '/checkout/payment/address' =>  'checkout_payment_address.php',
    '/checkout/payment'         =>  'checkout_payment.php',
    '/checkout/shipping/address'=>  'checkout_shipping_address.php',
    '/checkout'                 =>  'checkout_shipping.php',
    '/address_book/process'     =>  'address_book_process.php',
    '/address_book'             =>  'address_book.php',
    '/account/password'         =>  'account_password.php',
    '/account/newsletter'       =>  'newsletter.php',
    '/account/edit'             =>  'account_edit.php',
    '/account/history/order'    =>  'account_history_info.php',
    '/account/history'          =>  'account_history.php',
    '/account'                  =>  'account.php',
    '/login/lost/code'          =>  'display_vvcodes.php',
    '/login/lost'               =>  'password_double_opt.php',
    '/login'                    =>  'login.php',
    '/logout'                   =>  'logoff.php',
    '/cookiefail'               =>  'cookie_usage.php',
    '/content'                  =>  'content.php',
    '/contact'                  =>  'contact.php',
    '/create_account'           =>  'create_account.php',
    '/cart'                     =>  'shopping_cart.php',
    '/products'                 =>  'product_info.php',
    '/popup_content'            =>  'popup_content.php',
    '/search'                   =>  'advanced_search_result.php',
    '/ajax'                     =>  'ajax.php'

);

$filename="default.php";

foreach($routes as $route=>$fn)
{
    if(beginswith($_GET["path"],$route))
    {
        $filename=$fn;
        break;
    }
}

include ($filename);


if(!function_exists("module"))
    return;

$main_content=module();


$smarty = new Smarty;
$smarty->assign('tpl_path','/templates/'.CURRENT_TEMPLATE.'/');
$smarty->assign('CURRENT_LOGO',CURRENT_LOGO);
$smarty->assign('CURRENT_BACKGROUND',CURRENT_BACKGROUND);
$smarty->assign('CURRENT_CSS',CURRENT_CSS);

require (DIR_WS_INCLUDES.'header.php');
require (DIR_FS_CATALOG.'includes/boxes.php');


$smarty->assign('main_content', $main_content);
$smarty->assign('language', $_SESSION['language']);
$smarty->assign('realm', $APP_PATH[1]);
$smarty->caching = 0;
$smarty->display(CURRENT_TEMPLATE.'/index.html');
?>