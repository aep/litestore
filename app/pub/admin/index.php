<?php require('includes/application_top.php');?><!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
    <title><?php echo TITLE; ?></title>
    <link rel="stylesheet" type="text/css" href="images/stylesheet.css">
    <script type="text/javascript" src="/pub/javascript/spin.js"></script>
    <script type="text/javascript" src="/pub/javascript/adapter/prototype/prototype.js"></script>
    <script type="text/javascript" src="/pub/javascript/adapter/prototype/ext-prototype-adapter.js"></script>
    <script type="text/javascript" src="/pub/javascript/adapter/prototype/scriptaculous.js?load=effects"></script>
    <script type="text/javascript" src="/pub/javascript/ext-all-debug.js"></script>
    <script type="text/javascript" src="/pub/javascript/miframe.js"></script>
    <link rel="stylesheet" type="text/css"	href="/pub/javascript/resources/css/ext-all.css" >
    <script type="text/javascript" src="/pub/admin/admin.js"></script>
    <!--<link rel="stylesheet" type="text/css" href="/pub/javascript/resources/css/xtheme-slate.css" >-->
</head>
<body>

    <noscript>
        Diese Anwendung  benötigt Javascript.
    </noscript>

    <div id="ext_content"></div>    

    <div id="actions" style="display:none">
        <ul id="actionAbout">
            <li><a href="#" onclick="module_html('Willkommen','/admin/start.php')" >Start</a></li>
            <li><a href="/">Shop</a></li>
            <li><a href="#" onclick="module_iframe('Credits','/admin/credits.php')" >Credits</a></li>
            <li><a href="/logout">Logout</a></li>
        </ul>

        <ul id="actionCustomers">
            <li><a href="#" onclick="module_iframe('Kunden','/admin/customers.php')" >Kunden</a></li>
            <li><a href="#" onclick="module_iframe('Kundengruppen','/admin/customers_status.php')" >Kundengruppen</a></li>
            <li><a href="#" onclick="module_iframe('Bestellungen','/admin/orders.php')">Bestellungen</a></li>
        </ul>

        <ul id="actionCatalog">
            <li><a href="#" onclick="module_iframe('Artikelstamm','/admin/categories.php')">Artikelstamm</a></li>
            <li><a href="#" onclick="module_iframe('Hersteller','/admin/manufacturers.php')" >Hersteller</a></li>
            <li><a href="#" onclick="module_iframe('Sonderangebote','/admin/specials.php')" >Sonderangebote</a></li>
        </ul>
        <ul id="actionModules">
            <li><a href="#" onclick="module_iframe('Zahlungsoptionen','/admin/modules.php?set=payment')" >Zahlungsoptionen</a></li>
            <li><a href="#" onclick="module_iframe('Versandart','/admin/modules.php?set=shipping')" >Versandart</a></li>
            <li><a href="#" onclick="module_iframe('Zusammenfassung','/admin/modules.php?set=ordertotal')" >Zusammenfassung</a></li>
        </ul>        

        <ul id="actionStats">
            <li><a href="#" onclick="module_js('/admin/stats_products_viewed.php')" >Besuchte Artikel</a></li>
            <li><a href="#" onclick="module_js('/admin/stats_products_purchased.php')" >Verkaufte Artikel</a></li>
            <li><a href="#" onclick="module_js('/admin/stats_customers.php')" >Kunden-Bestellstatistik</a></li>
            <li><a href="#" onclick="module_iframe('Umsatzstatistik','/admin/stats_sales_report.php')" >Umsatzstatistik</a></li>
        </ul>

        <ul id="actionTools">
            <li><a href="#" onclick="module_iframe('Rundschreiben','/admin/module_newsletter.php')" >Rundschreiben</a></li>
            <li><a href="#" onclick="module_iframe('Content Manager','/admin/content_manager.php')" >Content Manager</a></li>
            <li><a href="#" onclick="module_iframe('CC-Blacklist','/admin/blacklist.php')" >CC-Blacklist</a></li>
            <li><a href="#" onclick="module_iframe('Banner Manager','/admin/banner_manager.php')" >Banner Manager</a></li>
            <li><a href="#" onclick="module_iframe('Google Adsense','/admin/adsense.php')" >Google Adsense</a></li>
            <li><a href="#" onclick="module_iframe('Google Adwords','/admin/adwords.php')" >Google Adwords</a></li>
            <li><a href="#" onclick="module_iframe('Export','/admin/export.php')" >Export</a></li>
            <li><a href="#" onclick="module_iframe('Import','/admin/csv_backend.php')" >Import</a></li>
        </ul>

        <ul  id="actionLocalisation">
            <li><a href="#" onclick="module_iframe('Land','/admin/countries.php')" >Land</a></li>
            <li><a href="#" onclick="module_iframe('W&auml;hrungen','/admin/currencies.php')" >W&auml;hrungen</a></li>
            <li><a href="#" onclick="module_iframe('Bundesl&auml;nder','/admin/zones.php')" >Bundesl&auml;nder</a></li>
            <li><a href="#" onclick="module_iframe('Steuerzonen','/admin/geo_zones.php')" >Steuerzonen</a></li>
            <li><a href="#" onclick="module_iframe('Steuerklassen','/admin/tax_classes.php')" >Steuerklassen</a></li>
            <li><a href="#" onclick="module_iframe('Steuers&auml;tze','/admin/tax_rates.php')" >Steuers&auml;tze</a></li>
        </ul>

        <ul id="actionSettings" >
            <li><a href="#" onclick="module_iframe('Mein Shop','/admin/configuration.php?gID=1')" >Mein Shop</a></li>
            <li><a href="#" onclick="module_iframe('Style','/admin/style.php')" >Style</a></li>
            <li><a href="#" onclick="module_iframe('Minumum Werte','/admin/configuration.php?gID=2')" >Minumum Werte</a></li>
            <li><a href="#" onclick="module_iframe('Maximum Werte','/admin/configuration.php?gID=3')" >Maximum Werte</a></li>
            <li><a href="#" onclick="module_iframe('Kunden Details','/admin/configuration.php?gID=5')" >Kunden Details</a></li>
            <li><a href="#" onclick="module_iframe('Versand Optionen','/admin/configuration.php?gID=7')" >Versand Optionen</a></li>
            <li><a href="#" onclick="module_iframe('Artikel Listen Optionen','/admin/configuration.php?gID=8')" >Artikel Listen Optionen</a></li>
            <li><a href="#" onclick="module_iframe('eMail Optionen','/admin/configuration.php?gID=12')" >eMail Optionen</a></li>
            <li><a href="#" onclick="module_iframe('Meta-Tags/Suchmaschinen','/admin/metatags.php')" >Meta-Tags/Suchmaschinen</a></li>
            <li><a href="#" onclick="module_iframe('Conversion tracking','/admin/configuration.php?gID=76')" >Conversion tracking</a></li>
            <li><a href="#" onclick="module_iframe('Zusatzmodule','/admin/configuration.php?gID=17')" >Zusatzmodule</a></li>
            <li><a href="#" onclick="module_iframe('UST ID','/admin/configuration.php?gID=18')" >UST ID</a></li>
            <li><a href="#" onclick="module_iframe('Such-Optionen','/admin/configuration.php?gID=22')" >Such-Optionen</a></li>
            <li><a href="#" onclick="module_iframe('Bestellstatus','/admin/orders_status.php')" >Bestellstatus</a></li>
            <li><a href="#" onclick="module_iframe('Lieferstatus','/admin/shipping_status.php')" >Lieferstatus</a></li>
            <li><a href="#" onclick="module_iframe('Verpackungseinheit','/admin/products_vpe.php')" >Verpackungseinheit</a></li>
        </ul>
    </div>
</body>
</html>

