<?php
try
{
    $APPDIR= $_SERVER["DOCUMENT_ROOT"].'/../';
    chdir  ($APPDIR);


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
        '/create_account/success'   =>  'create_account_success.php',
        '/create_guest_account'     =>  'create_guest_account.php',
        '/cart'                     =>  'shopping_cart.php',
        '/products'                 =>  'product_info.php',
        '/popup_content'            =>  'popup_content.php',
        '/search'                   =>  'advanced_search_result.php',
        '/ajax'                     =>  'ajax.php',
        '/wellcome'                  =>  'wellcome.php',

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

    include ('modules/'.$filename);


    if(!function_exists("module"))
        return;

    $main_content=module();


    $smarty = new Smarty;
    $smarty->assign('CURRENT_LOGO',CURRENT_LOGO);
    $smarty->assign('CURRENT_BACKGROUND',CURRENT_BACKGROUND);
    $smarty->assign('CURRENT_CSS',CURRENT_CSS);

    require (DIR_WS_INCLUDES.'header.php');
    require (DIR_FS_CATALOG.'includes/boxes.php');


    $smarty->assign('main_content', $main_content);
    $smarty->assign('language', $_SESSION['language']);
    $smarty->assign('realm', $APP_PATH[1]);
    $smarty->caching = 0;
    $smarty->display('index.html');
}
catch (Exception $e)
{

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>	
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <title>An Exception occured</title>
		
		<style type="text/css" media="screen"><!--

*{margin:0;padding:0;}
body 
{
	color: white;
	background-color: #000;
	font-family: Verdana, Geneva, Arial, sans-serif;
	font-size: 10px;
}

#horizon        
{
	text-align: center;
	position: absolute;
	top: 50%;
	left: 0px;
	width: 100%;
	height: 1px;
	overflow: visible;
	visibility: visible;
	display: block
}

#content    
{
	background-color: #000;
	margin-left: -300px;
	position: absolute;
	top: -35px;
	left: 50%;
	width: 600px;
	height: 120px;
	visibility: visible
}

.bodytext 
{
	font-size: 14px
}

.headline 
{
    color:#f00;
	font-weight: bold;
	font-size: 24px
}


a:link, a:visited 
	{
	color: #06f;
	text-decoration: none
	}

a:hover 
	{
	color: red;
	text-decoration: none
	}

.captions  
{
	color: white;
	font-size: 10px;
	line-height: 14px;
	text-align: left
}

#bt    
{
	padding-left: 6px;
	border-left: 1px dashed #66c;
	position: absolute;
	top: 120px;
	left: 40px;
	width: 600px;
	height: auto;
	visibility: visible;
	display: block
}


td
{
	font-size: 10px;
}

--></style></head><body>
		<div id="horizon">
			<div id="content">
				<div >

					<p class="bodytext">Unable to serve page due to exception of type </p>
					<span class="headline"><?php echo get_class($e); ?></span><br><br>

                    <?php echo $e->getMessage() ?>

					<div id="bt" class="captions">
                    <h3>backtrace</h3><br>


                    <table>
                    <?php 
                        foreach ($e->getTrace() as $n=>$r)
                        {
                            echo "<tr>";
                            echo "<td>$n</td>";
                            echo "<td>".$r["file"].":".$r["line"]."</td>";
                            echo "</tr>";

                            echo "<tr>";
                            echo "<td></td>";
                            echo "<td>".$r["class"].'::'.$r["function"].' (';
                            foreach ($r["args"] as $a)
                            {
                                echo $a;
                            }
                            echo ')</td>';
                            echo '</tr>';
                        }
                    ?>
                    </table>

</div>
				</div>
			</div>
		</div>
	</body></html><?php
}

?>
