<?php
/* --------------------------------------------------------------
   $Id:

   neXTCommerce - ebusiness solutions
   http://www.nextcommerce.org

   Copyright (c) 2003 neXTCommerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project 
   (c) 2002-2003 osCommerce coding standards (a typical file) www.oscommerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------

 Modified for XT-Commerce by M.Hinsche
 http://www.gamesempire.de
 Apr 3th, 2004

   Third Party contribution:
      Unsold Carts Report (Version 1.8)
   http://www.oscommerce.com/community/contributions,1598

 Modified by JM Ivler
 Oct 8th, 2003

 Modifed by Aalst (stats_unsold_carts.php,v 1.4)
 aalst@aalst.com
 Nov 7th 2003

 Modifed by Aalst (stats_unsold_carts.php,v 1.4.1)
 aalst@aalst.com
 Nov 9th 2003

 Modifed by Aalst (stats_unsold_carts.php,v 1.4.2)
 aalst@aalst.com
 Nov 10th 2003

 Modifed by Aalst (stats_unsold_carts.php,v 1.6)
 aalst@aalst.com
 Nov 12th 2003

 Modifed by Aalst (stats_unsold_carts.php,v 1.7)
 aalst@aalst.com
 Nov 13th 2003
 
 Modified by Raimund Berg (stats_unsold_carts.php, v1.8)
 rb@malermeister-berg.de
 Original Idea: Roman Gruhn
 Mar 30th, 2004


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require('includes/application_top.php');



define ('FILENAME_STATS_UNSOLD_CARTS','stats_unsold_carts.php');

define('BOX_CONFIGURATION_70', 'RCS Einstellung');
define('BOX_REPORTS_RECOVER_CART_SALES', 'RCS Statistik');
define('BOX_TOOLS_RECOVER_CART', 'RCS Mail Kontakt' );


define('HEADING_TITLE', 'Recover Cart Sales Report v2.12');
define('DAYS_FIELD_PREFIX', 'Zeige die letzten ');
define('DAYS_FIELD_POSTFIX', ' Tage ');
define('DAYS_FIELD_BUTTON', 'OK');
define('TABLE_HEADING_SCART_ID', 'Warenkorb ID');
define('TABLE_HEADING_SCART_DATE', 'Hinzugef�gt am');
define('TABLE_HEADING_CUSTOMER', 'Kunden Name');
define('TABLE_HEADING_ORDER_DATE', 'Bestell Datum');
define('TABLE_HEADING_ORDER_STATUS', 'Status');
define('TABLE_HEADING_ORDER_AMOUNT', 'Betrag');
define('TOTAL_RECORDS', 'In �berpr�fung befindliche Datens�tze:');
define('TOTAL_SALES', 'Verk�ufe:');
define('TOTAL_SALES_EXPLANATION', ' (M�gliche Verk�ufe von Kunden, die ihre Bestellung nicht beendet haben und per RCS informiert wurden)');
define('TOTAL_RECOVERED', 'Total wiederhergestellt:');

define('MESSAGE_STACK_CUSTOMER_ID', 'Warenkorb f�r Kundennummer ');
define('MESSAGE_STACK_DELETE_SUCCESS', ' erfolgreich gel�scht');
define('HEADING_EMAIL_SENT', 'E-mail Sende-Report');
define('EMAIL_TEXT_LOGIN', 'Melden sie sich hier an:');
define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Anfrage von '.  STORE_NAME );
define('EMAIL_TEXT_SALUTATION', 'Sehr geehrte/geehrter ' );
define('EMAIL_TEXT_NEWCUST_INTRO', "\n\n" . 'Vielen Dank f�r Ihren Besuch bei ' . STORE_NAME .
                                   ' und Ihr Interesse an unseren Artikeln.  ');
define('EMAIL_TEXT_CURCUST_INTRO', "\n\n" . 'Vielen Dank f�r Ihren erneuten Besuch bei ' .
                                   STORE_NAME . ' und Ihr wiederholtes Interesse an unseren Artikeln.  ');
define('EMAIL_TEXT_BODY_HEADER', 'Wir haben gesehen, da� Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden ' . 'Artikeln gef�llt haben, jedoch den Einkauf nicht vollst�ndig durchgef�hrt haben. ' .
                                 "\n\n" . 'Inhalt Ihres Warenkorbes:' . "\n\n");
define('EMAIL_TEXT_BODY_FOOTER', 'Wir sind immer bem�ht unseren Service ' .
                                 'im Interesse unserer Kunden zu verbessern. Aus diesem Grund interessiert es uns nat�rlich, was die ' .
                                 'Ursachen daf�r waren, Ihren Einkauf dieses Mal nicht bei '. STORE_NAME . ' zu t�tigen. Wir w�ren Ihnen ' .
                                 'daher sehr dankbar, wenn Sie uns mitteilen w�rden, ob Sie bei Ihrem Besuch in unsererm Onlineshop ' .
                                 'Probleme oder Bedenken hatten ' . 'den Einkauf erfolgreich abzuschlie�en. Unser Ziel ist es Ihnen und ' .
                                 ' anderen Kunden den Einkauf bei ' . STORE_NAME . ' leichter und besser zu gestalten. ' .
                                 "\n\n" . 'Nochmals, vielen Dank f�r Ihre Zeit und Ihre Hilfe ' .
                                 'den Onlineshop von ' . STORE_NAME . ' zu verbessern.' . "\n\n" .
                                 'Mit freundlichen Gr��en' . "\n". 'Ihr Team von ');
define('DAYS_FIELD_PREFIX', 'Zeige die letzten ');
define('DAYS_FIELD_POSTFIX', ' Tage ');
define('DAYS_FIELD_BUTTON', 'Anzeigen');
define('TABLE_HEADING_DATE', 'Datum');
define('TABLE_HEADING_CONTACT', 'kontaktieren?');
define('TABLE_HEADING_CUSTOMER', 'Kunden Name');
define('TABLE_HEADING_EMAIL', 'E-Mail');
define('TABLE_HEADING_PHONE', 'Telefon');
define('TABLE_HEADING_MODEL', 'Artikel');
define('TABLE_HEADING_DESCRIPTION', 'Beschreibung');
define('TABLE_HEADING_QUANTY', 'Menge');
define('TABLE_HEADING_PRICE', 'Preis');
define('TABLE_HEADING_TOTAL', 'Summe');
define('TABLE_GRAND_TOTAL', 'Summe netto Gesamt: ');
define('TABLE_CART_TOTAL', 'Summe netto: ');
define('TABLE_GRAND_TOTAL_BRUTTO', 'Summe brutto Gesamt: ');
define('TABLE_CART_TOTAL_BRUTTO', 'Summe brutto: ');
define('TEXT_CURRENT_CUSTOMER', 'Kunde');
define('TEXT_SEND_EMAIL', 'Sende E-mail');
define('TEXT_RETURN', '[Klick hier um zur�ckzugehen]');
define('TEXT_NOT_CONTACTED', 'Nicht kontaktiert');
define('PSMSG', 'Zus�tzliche Nachricht (PS) am Ende der Mail: ');






require(DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

 
// Delete Entry Begin : Roman Gruhn
if ($HTTP_GET_VARS['action']=='delete') { 
   $reset_query_raw = "delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id=$HTTP_GET_VARS[customer_id]"; 
   xtc_db_query($reset_query_raw); 
   $reset_query_raw2 = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id=$HTTP_GET_VARS[customer_id]"; 
   xtc_db_query($reset_query_raw2); 
   xtc_redirect(xtc_href_link(FILENAME_STATS_UNSOLD_CARTS, 'delete=1&customer_id='. $HTTP_GET_VARS['customer_id'] . '&tdate=' . $HTTP_GET_VARS['tdate'])); 
} 
if ($HTTP_GET_VARS['delete']) { 
   $messageStack->add(MESSAGE_STACK_CUSTOMER_ID . $HTTP_GET_VARS['customer_id'] . MESSAGE_STACK_DELETE_SUCCESS, 'success'); 
} 
// Delete Entry End
?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->

<?


?>

<h1><?php echo HEADING_TITLE; ?></h1>


    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td align="left" colspan="2">
        <!-- REPORT TABLE BEGIN //-->
          <table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr>
              <td class="pageHeading" align="left"  colspan="2"></td>
              <td class="pageHeading" align="right"  colspan="4">
                <?php $tdate = $_POST['tdate'];
                if ($_POST['tdate'] == '') $tdate = '30';?>
                <form method=post action=<?php echo $PHP_SELF;?> >
                  <table align="right" width="100%">
                    <tr class="dataTableContent" align="right">
                      <td><?php echo DAYS_FIELD_PREFIX; ?><input type=text size=4 width=4 value=<?php echo $tdate; ?> name=tdate><?php echo DAYS_FIELD_POSTFIX; ?><input type=submit value="<?php echo DAYS_FIELD_BUTTON; ?>"></td>
                    </tr>
                  </table>
                </form>
              </td>
            </tr>
            <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent" align="left" colspan="1" width="15%"><?php echo TABLE_HEADING_DATE; ?></td>
              <td class="dataTableHeadingContent" align="left" colspan="1" width="35%"><?php echo TABLE_HEADING_CUSTOMER; ?></td>
              <td class="dataTableHeadingContent" align="left" colspan="1" width="35%"><?php echo TABLE_HEADING_EMAIL; ?></td>
              <td class="dataTableHeadingContent" align="left" colspan="3" width="15%"><?php echo TABLE_HEADING_PHONE; ?></td>
            </tr>
            <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent" align="left"   colspan="1" width="20%"><?php echo TABLE_HEADING_MODEL; ?></td>
              <td class="dataTableHeadingContent" align="left"   colspan="2" width="40%"><?php echo TABLE_HEADING_DESCRIPTION; ?></td>
              <td class="dataTableHeadingContent" align="center" colspan="1" width="10%"><?php echo TABLE_HEADING_QUANTY; ?></td>
              <td class="dataTableHeadingContent" align="right"  colspan="1" width="15%"><?php echo TABLE_HEADING_PRICE; ?></td>
              <td class="dataTableHeadingContent" align="right"  colspan="1" width="15%"><?php echo TABLE_HEADING_TOTAL; ?></td>
            </tr>

<?php
function k_seadate($day)  
{
  $rawtime = strtotime("-".$day." days");
  $ndate = date("Ymd", $rawtime);
  return $ndate;
}
function cart_date_short($raw_date) {
  if ( ($raw_date == '00000000') || ($raw_date == '') ) return false;

  $year = substr($raw_date, 0, 4);
  $month = (int)substr($raw_date, 4, 2);
  $day = (int)substr($raw_date, 6, 2);

  if (@date('Y', mktime(0, 0, 0, $month, $day, $year)) == $year) {
    return date(DATE_FORMAT, mktime(0, 0, 0, $month, $day, $year));
  } else {
    return ereg_replace('2037' . '$', $year, date(DATE_FORMAT, mktime(0, 0, 0, $month, $day, 2037)));
  }
}

  $tdate = $_POST['tdate'];
  if ($_POST['tdate'] == '') $tdate = '30';
  $ndate = k_seadate($tdate);
  
  
  
  $query3 = xtc_db_query("select cb.customers_id cid, max(cb.customers_basket_date_added) bdate
from " . TABLE_CUSTOMERS_BASKET . " cb                      
where  cb.customers_basket_date_added >= '" . $ndate . "'
group by cb.customers_id order by bdate desc");

  $knt3 = mysql_num_rows($query3);
  $totalAll = 0;
  
  for ($ii = 0; $ii < $knt3; $ii++) {
    $inrec3 = xtc_db_fetch_array($query3);
  
    $query1 = xtc_db_query("select cb.customers_id cid,
                                   cb.products_id pid,
                                   cb.customers_basket_quantity qty,
                                   cb.customers_basket_date_added bdate,
                                   cus.customers_firstname fname,
                                   cus.customers_lastname lname,
                                   cus.customers_telephone phone,
                                   cus.customers_email_address email
                            from   " . TABLE_CUSTOMERS_BASKET . " cb,
                                   " . TABLE_CUSTOMERS . " cus
                            where  cb.customers_id = cus.customers_id and cb.customers_id = ".$inrec3['cid'] . "
							order by cb.customers_basket_date_added desc");
    $results = 0;
    $curcus = "";
    $tprice = 0;
//  $totalAll = 0;
    $knt = mysql_num_rows($query1);
    $first_line = true;
  
    for ($i = 0; $i <= $knt; $i++) {
      $inrec = xtc_db_fetch_array($query1);

      if ($curcus != $inrec['cid']) {
        // output line
        $totalAll += $tprice;
        $tcart_formated = $currencies->format($tprice);
        $cline .= "
            <tr>
              <td class='dataTableContent' align='right' colspan='6'><b>" . TABLE_CART_TOTAL . "</b>" . $tcart_formated . "</td>
            </tr>
            <tr>
              <!-- Delete Button : Roman Gruhn //-->
              <td colspan='6' align='right'><a href=" . xtc_href_link(FILENAME_STATS_UNSOLD_CARTS,"action=delete&customer_id=$curcus&tdate=$tdate") . ">" .  IMAGE_RESET . "</a></td>
            </tr>";

        if ($curcus != "") echo $cline;

        // set new cline and curcus
        $curcus = $inrec['cid'];
        $tprice = 0;

        if ($first_line == false) { 
          $cline = "
            <tr>
              <td colspan=6><br></td>
            </tr>";
        } else {
          $cline = "";
          $first_line = false;
        }
        $cline .= "
            <tr>
              <td class='dataTableContent' align='left' width='15%'><b> " . cart_date_short($inrec['bdate']) . "</td>
              <td class='dataTableContent' align='left' width='35%'><a href='" . xtc_href_link(FILENAME_CUSTOMERS, 'search=' . $inrec['lname'], 'NONSSL') . "'><b>" . $inrec['fname'] . " " . $inrec['lname'] . "</a></td>
              <td class='dataTableContent' align='left' width='35%'><a href='" . xtc_href_link('mail.php', 'selected_box=tools&customer=' . $inrec['email']) . "'>" . $inrec['email'] . "</a></td>
              <td class='dataTableContent' align='left' colspan='3' width='15%'>" . $inrec['phone'] . "</td>
            </tr>";
    }

      // empty the shopping cart
      $query2 = xtc_db_query("select  p.products_price price,
                                    p.products_model model,
                                    pd.products_name name
                            from    " . TABLE_PRODUCTS . " p,
                                    " . TABLE_PRODUCTS_DESCRIPTION . " pd,
                                    " . TABLE_LANGUAGES . " l
                            where   p.products_id = '" . $inrec['pid'] . "' and
                                    pd.products_id = p.products_id and
                                    l.languages_id = pd.languages_id");

      $inrec2 = xtc_db_fetch_array($query2);
      $tprice = $tprice + ($inrec['qty'] * $inrec2['price']);

      if ($inrec['qty'] != 0) {
        $pprice_formated  = $currencies->format($inrec2['price']);
        $tpprice_formated = $currencies->format(($inrec['qty'] * $inrec2['price']));
        $cline .= "
            <tr class='dataTableRow'>
              <td class='dataTableContent' align='left'   width='20%'>" . $inrec2['model'] . "</td>
              <td class='dataTableContent' align='left'   colspan='2' width='40%'><a href='" . xtc_href_link(FILENAME_CATEGORIES, 'action=new_product_preview&read=only&pID=' . $inrec['pid'] . '&origin=' . FILENAME_STATS_UNSOLD_CARTS . '?page=' . $HTTP_GET_VARS['page'], 'NONSSL') . "'>" . $inrec2['name'] . "</a></td>
              <td class='dataTableContent' align='center' width='10%'>" . $inrec['qty'] . "</td>
              <td class='dataTableContent' align='right'  width='15%'>" . $pprice_formated . "</td>
              <td class='dataTableContent' align='right'  width='15%'>" . $tpprice_formated . "</td>
            </tr>";
      }
    }
  }

  $totalAll_formated = $currencies->format($totalAll);
  
  $cline .= "
            <tr>
              <td class='dataTableContent' align='right' colspan='6'><b>" . TABLE_GRAND_TOTAL . "</b>" . $totalAll_formated . "</td>
            </tr>";

  echo $cline;
?>
        </tr>    
          </table>
        <!-- REPORT TABLE END //-->
        </td>
      </tr>
    </table>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>