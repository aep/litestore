<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_draw_input_field.inc.php,v 1.1 2003/09/06 21:47:50 fanta2k Exp $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
   (c) 2003	 nextcommerce (xtc_draw_input_field.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function xtc_draw_input_field_ib_1($name, $value = '', $parameters = '', $type = 'text', $reinsert_value = true, $elements = 0, $quantity) 
{
	static $xid=0;
	$xid++;
	$idstring="xtc_draw_input_field_ib_1_".$xid;

	$field = '<table cellspacing=0 cellpadding=0 border=0><tr><td>';
	$field .= '<input id="'.$idstring.'" type="' . xtc_parse_input_field_data($type, array('"' => '&quot;')) . '" name="' . xtc_parse_input_field_data($name, array('"' => '&quot;')) . '"';

	if ( (isset($GLOBALS[$name])) && ($reinsert_value == true) ) 
	{
		$field .= ' value="' . xtc_parse_input_field_data($GLOBALS[$name], array('"' => '&quot;')) . '"';
	} 
	elseif (xtc_not_null($value)) 
	{
		$field .= ' value="' . xtc_parse_input_field_data($value, array('"' => '&quot;')) . '"';
	}

	if (xtc_not_null($parameters)) 
		$field .= ' ' . $parameters;

	$field .= ' readonly="readonly" ';
	$field .= ' onfocus="alert(\'Die Menge kann nicht ge&auml;ndert werden. Klicken Sie auf + oder - , um &Auml;nderungen vorzunehmen.\')" ';

	$field .= '>';
	$field .= '</td><td width=20>';
	$field .= '<IMG SRC="templates/Red500/img/plus.gif" ALT="Menge erh&ouml;hen" onClick="document.getElementById(\''.$idstring.'\').value=Math.abs(parseInt(document.getElementById(\''.$idstring.'\').value)+parseInt('.$quantity.'))">';
		
	$field .= '<IMG SRC="templates/Red500/img/minus.gif" ALT="Menge verringern" onClick="document.getElementById(\''.$idstring.'\').value=count_down(parseInt(document.getElementById(\''.$idstring.'\').value), '.$quantity.')">';	
	$field .= '</td></tr></table>';
	$field .= '<br/>VE: '.$quantity;

	
	return $field;
}
?>
