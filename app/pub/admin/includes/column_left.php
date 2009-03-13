<?php
/* --------------------------------------------------------------
   $Id: column_left.php 1231 2005-09-21 13:05:36Z mz $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(column_left.php,v 1.15 2002/01/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (column_left.php,v 1.25 2003/08/19); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  $admin_access_query = xtc_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . $_SESSION['customer_id'] . "'");
  $admin_access = xtc_db_fetch_array($admin_access_query); 


?>

<div id="sidebar">

    <ul id="actionAbout">
        <li>
<!--        <img src="images/s.gif" class="icon-show-all"/> -->
            <a  href="/admin/start.php">Start</a>
    	</li>
	    <li>
            <a href="/">Shop</a>
    	</li>
	    <li>
            <a href="/admin/credits.php" >Credits</a>
    	</li>
	    <li>
            <a href="/logout">Logout</a>
        </li>

    </ul>

    <ul id="actionCustomers">
        <li>            <a href="http://localhost/admin/customers.php" >Kunden</a>
        </li>
        <li>
            <a href="http://localhost/admin/customers_status.php" >Kundengruppen</a>
        </li>
        <li>
            <a href="http://localhost/admin/orders.php">Bestellungen</a>
        </li>
    </ul>

    <ul id="actionCatalog">
        <li>
            <a href="http://localhost/admin/categories.php">Kategorien / Artikel</a>
        </li>
        <li>
            <a href="http://localhost/admin/manufacturers.php" >Hersteller</a>
        </li>
        <li>
            <a href="http://localhost/admin/specials.php" >Sonderangebote</a>
        </li>
    </ul>
    <ul id="actionModules">
        <li>
        
            <a href="http://localhost/admin/modules.php?set=payment" >Zahlungsoptionen</a>
        </li>
        <li>
            <a href="http://localhost/admin/modules.php?set=shipping" >Versandart</a>
        </li>
        <li>
            <a href="http://localhost/admin/modules.php?set=ordertotal" >Zusammenfassung</a>
        </li>
    </ul>        

    <ul id="actionStats">
        <li>
            <a href="http://localhost/admin/stats_products_viewed.php" >Besuchte Artikel</a>
        </li>
        <li>
            <a href="http://localhost/admin/stats_products_purchased.php" >Verkaufte Artikel</a>
        </li>
        <li>
            <a href="http://localhost/admin/stats_customers.php" >Kunden-<br />&nbsp;Bestellstatistik</a>
        </li>
        <li>
            <a href="http://localhost/admin/stats_sales_report.php" >Umsatzstatistik</a>
        </li>
    </ul>

    <ul id="actionTools">
        <li>
            <a href="http://localhost/admin/module_newsletter.php" >Rundschreiben</a>
        </li>
        <li>
            <a href="http://localhost/admin/content_manager.php" >Content Manager</a>
        </li>
        <li>
            <a href="http://localhost/admin/blacklist.php" >CC-Blacklist</a>
        </li>
        <li>
            <a href="http://localhost/admin/banner_manager.php" >Banner Manager</a>
        </li>
        <li>
            <a href="/admin/adsense.php" >Google Adsense</a>
        </li>
        <li>
            <a href="/admin/adwords.php" >Google Adwords</a>
        </li>
        <li>
            <a href="http://localhost/admin/export.php" >Export</a>
        </li>
        <li>
            <a href="http://localhost/admin/csv_backend.php" >Import</a>
        </li>
    </ul>

    <ul  id="actionLocalisation">
        <li>
            <a href="http://localhost/admin/countries.php" >Land</a>
        </li>
        <li>
            <a href="http://localhost/admin/currencies.php" >W&auml;hrungen</a>
        </li>
        <li>
            <a href="http://localhost/admin/zones.php" >Bundesl&auml;nder</a>
        </li>
        <li>
            <a href="http://localhost/admin/geo_zones.php" >Steuerzonen</a>
        </li>
        <li>
            <a href="http://localhost/admin/tax_classes.php" >Steuerklassen</a>
        </li>
        <li>
            <a href="http://localhost/admin/tax_rates.php" >Steuers&auml;tze</a>
        </li>
    </ul>

    <ul id="actionSettings" >
        <li>
            <a href="http://localhost/admin/configuration.php?gID=1" >Mein Shop</a>
        </li>
        <li>
            <a href="http://localhost/admin/style.php" >Style</a>
        </li>
        <li>
            <a href="http://localhost/admin/configuration.php?gID=2" >Minumum Werte</a>
        </li>
        <li>
            <a href="http://localhost/admin/configuration.php?gID=3" >Maximum Werte</a>
        </li>
        <li>
            <a href="http://localhost/admin/configuration.php?gID=5" >Kunden Details</a>
        </li>
        <li>
            <a href="http://localhost/admin/configuration.php?gID=7" >Versand Optionen</a>
        </li>
        <li>
            <a href="http://localhost/admin/configuration.php?gID=8" >Artikel Listen Optionen</a>
        </li>
        <li>
            <a href="http://localhost/admin/configuration.php?gID=12" >eMail Optionen</a>
        </li>
        <li>
            <a href="/admin/metatags.php" >Meta-Tags/Suchmaschinen</a>
        </li>
        <li>
            <a href="http://localhost/admin/configuration.php?gID=76" >Conversion tracking</a>
        </li>
        <li>
            <a href="http://localhost/admin/configuration.php?gID=17" >Zusatzmodule</a>
        </li>
        <li>
            <a href="http://localhost/admin/configuration.php?gID=18" >UST ID</a>
        </li>
        <li>
            <a href="http://localhost/admin/configuration.php?gID=22" >Such-Optionen</a>
        </li>
        <li>
            <a href="http://localhost/admin/orders_status.php" >Bestellstatus</a>
        </li>
        <li>
            <a href="http://localhost/admin/shipping_status.php" >Lieferstatus</a>
        </li>
        <li>
            <a href="http://localhost/admin/products_vpe.php" >Verpackungseinheit</a>
        </li>
    </ul>


    </div>

</div>

