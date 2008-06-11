<?php
/* -----------------------------------------------------------------------------------------
   $Id: shop_content.php 1303 2005-10-12 16:47:31Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(conditions.php,v 1.21 2003/02/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (shop_content.php,v 1.1 2003/08/19); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


function module()
{
    
    $smarty = new Smarty;

    require_once (DIR_FS_INC.'xtc_parse_input_field_data.inc.php');
    require_once (DIR_FS_INC.'xtc_validate_email.inc.php');
    if (GROUP_CHECK == 'true') 
    {
        $group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
    }
    
    if ($_GET['action'] == 'success') 
    {
        require (DIR_WS_INCLUDES.'header.php');
    }
    
    $smarty->assign('CONTENT_HEADING', $shop_content_data['content_heading']);
    
    $error = false;
    if (isset ($_GET['action']) && ($_GET['action'] == 'send')) 
    {
        if (xtc_validate_email(trim($_POST['email']))) 
        {
        xtc_php_mail($_POST['email'], $_POST['name'], CONTACT_US_EMAIL_ADDRESS, CONTACT_US_NAME, CONTACT_US_FORWARDING_STRING, $_POST['email'], $_POST['name'], '', '', CONTACT_US_EMAIL_SUBJECT, nl2br($_POST['message_body']), $_POST['message_body']);
    
            if (!isset ($mail_error)) 
            {
                xtc_redirect(xtc_href_link(FILENAME_CONTENT, 'action=success&coID='.(int) $_GET['coID']));
            } 
            else 
            {
                $smarty->assign('error_message', $mail_error);
            }
        } 
        else 
        {
            // error report hier einbauen
            $smarty->assign('error_message', ERROR_MAIL);
            $error = true;
        }
    
    }
    
    $smarty->assign('CONTACT_HEADING', $shop_content_data['content_title']);
    if (isset ($_GET['action']) && ($_GET['action'] == 'success')) 
    {
        $smarty->assign('success', '1');
        $smarty->assign('BUTTON_CONTINUE', '<a href="'.xtc_href_link(FILENAME_DEFAULT).'">'.xtc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).'</a>');
    
    } 
    else 
    {
        if ($shop_content_data['content_file'] != '') 
        {
            ob_start();
            if (strpos($shop_content_data['content_file'], '.txt'))
                echo '<pre>';
            include (DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
            if (strpos($shop_content_data['content_file'], '.txt'))
                echo '</pre>';
            $contact_content = ob_get_contents();
            ob_end_clean();
        } 
        else 
        {
            $contact_content = $shop_content_data['content_text'];
        }
        $smarty->assign('CONTACT_CONTENT', $contact_content);
        $smarty->assign('FORM_ACTION', xtc_draw_form('contact_us', xtc_href_link(FILENAME_CONTENT, 'action=send&coID='.(int) $_GET['coID'])));
        $smarty->assign('INPUT_NAME', xtc_draw_input_field('name', ($error ? $_POST['name'] : $first_name)));
        $smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', ($error ? $_POST['email'] : $email_address)));
        $smarty->assign('INPUT_TEXT', xtc_draw_textarea_field('message_body', 'soft', 50, 15, $_POST['']));
        $smarty->assign('FORM_END', '</form>');
    }
    
    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = 0;
    return $smarty->fetch(CURRENT_TEMPLATE.'/module/contact_us.html');
}
?>