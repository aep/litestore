<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_cleanName.inc.php 1319 2005-10-23 10:35:15Z mz $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


 function xtc_cleanName($name) {
 	$search_array=array('�','�','�','�','�','�','&auml;','&Auml;','&ouml;','&Ouml;','&uuml;','&Uuml;');
 	$replace_array=array('ae','Ae','oe','Oe','ue','Ue','ae','Ae','oe','Oe','ue','Ue');
 	$name=str_replace($search_array,$replace_array,$name);   	
 	
     $replace_param='/[^a-zA-Z0-9]/';
     $name=preg_replace($replace_param,'-',$name);    
     return $name;
 }

?>