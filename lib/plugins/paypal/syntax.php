<?php
/*
 * DokuWiki paypal plugin
 * Author : Zahno Silvan
 * Usage:
 * {{paypal>encrypted_value}} 
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the LGNU Lesser General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * LGNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the LGNU Lesser General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
 

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_paypal extends DokuWiki_Syntax_Plugin {

    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Zahno Silvan',
            'email'  => 'zaswiki@gmail.com',
            'date'   => '2011-02-17',
            'name'   => 'Paypal Plugin',
            'desc'   => 'Embedding PayPal Donation Button',
            'url'    => 'http://zawiki.zapto.org/doku.php/tschinz:dw_paypal',
        );
    }

    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }

    /**
     * Where to sort in?
     */
    function getSort(){
        return 299;
    }


    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
      $this->Lexer->addSpecialPattern('\{\{paypal>.*?\}\}',$mode,'plugin_paypal');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        switch ($state) {
          case DOKU_LEXER_ENTER :
            break;
          case DOKU_LEXER_MATCHED :
            break;
          case DOKU_LEXER_UNMATCHED :
            break;
          case DOKU_LEXER_EXIT :
            break;
          case DOKU_LEXER_SPECIAL :
            return $match;
            break;
        }
        return array();
    }

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
    	global $conf;
        if($mode == 'xhtml'){
			// strip {{paypal> from start
			$data = substr($data,9);
            // strip }} from end
			$data = substr($data,0,-2);
			$encrypted_value = $data;

			switch ($encrypted_value) {
				case 'desplegableSuscripcion':
					if ($conf['lang']=='es')
						$renderer->doc .= $this->desplegableSuscripcionES();
					else
						$renderer->doc .= $this->desplegableSuscripcionEN();
					break;
				case 'botonCancelar':
					if ($conf['lang']=='es')
						$renderer->doc .= $this->botonCancelarES();
					else
						$renderer->doc .= $this->botonCancelarEN();
					break;
				case 'botonCualquierPrecio':
					if ($conf['lang']=='es')
						$renderer->doc .= $this->botonCualquierPrecioES();
					else
						$renderer->doc .= $this->botonCualquierPrecioEN();
					break;
				default:
					if (empty($encrypted_value))
					{
						$renderer->doc .= 'No encrypted value given';
						return true;
					}

					$renderer->doc .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">';
					$renderer->doc .= '<input type="hidden" name="cmd" value="_s-xclick">';
					$renderer->doc .= '<input type="hidden" name="encrypted" value="'.$encrypted_value.'">';
					$renderer->doc .= '<input type="image" src="https://www.paypal.com/en_US/CH/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">';
					$renderer->doc .= '<img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">';
					$renderer->doc .= '</form>';

					return true;
			}
        }
        return false;
    }

    function botonCancelarES() {
    	return <<< EOT
<A HREF="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=paypal%40tsolucio%2ecom">
<IMG SRC="https://www.paypalobjects.com/es_ES/ES/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
</A>
EOT;
    }

    function botonCancelarEN() {
    	return <<< EOT
<A HREF="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=paypal%40tsolucio%2ecom">
<IMG SRC="https://www.paypalobjects.com/en_US/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
</A>
EOT;
    }

    function botonCualquierPrecioES() {
    	return <<< EOT
<div id="paypal_logo"><img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" alt="PayPal"></div>
<form action="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&no_shipping=0&no_note=1&tax=0&currency_code=EUR&bn=PP%2dBuyNowBF&charset=UTF%2d8" method="post">
<p>Cantidad a Pagar: <input type="text" name="amount" size="5" class="inputbox"><span id="donate_symbol_currency">€</span>
<input type="hidden" name="business" value="paypal@tsolucio.com">
<input type="hidden" name="item_name" value="Pago a TSolucio">
<input type="hidden" name="return" value="http://crmevolutivo.com/doku.php/es:donate_thanks">
<input type="hidden" name="cancel" value="http://crmevolutivo.com/doku.php/es:donate_cancel">
<input type="hidden" name="paypallength" value="4">
&nbsp;&nbsp;<input type="submit" class="button" name="paypalsubmit" alt="Make payments with PayPal - its fast, free and secure!" value="Comprar/Donar">
</p></form>
EOT;
    }

    function botonCualquierPrecioEN() {
    	return <<< EOT
<div id="paypal_logo"><img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" alt="PayPal"></div>
<form action="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&no_shipping=0&no_note=1&tax=0&currency_code=EUR&bn=PP%2dBuyNowBF&charset=UTF%2d8" method="post">
<p>Amount to Pay: <input type="text" name="amount" size="5" class="inputbox"><span id="donate_symbol_currency">€</span>
<input type="hidden" name="business" value="paypal@tsolucio.com">
<input type="hidden" name="item_name" value="Pago a TSolucio">
<input type="hidden" name="return" value="http://crmevolutivo.com/doku.php/en:donate_thanks">
<input type="hidden" name="cancel" value="http://crmevolutivo.com/doku.php/en:donate_cancel">
<input type="hidden" name="paypallength" value="4">
&nbsp;&nbsp;<input type="submit" class="button" name="paypalsubmit" alt="Make payments with PayPal - its fast, free and secure!" value="Buy/Donate">
</p></form>
EOT;
    }

    function desplegableSuscripcionES() {
    	return <<< EOT
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="9TQN3YC4VSR66">
    <table>
    <tr><td><input type="hidden" name="on0" value="coreBOS Subscription Options"><b>Opciones de Subscripción a coreBOS</b></td></tr><tr><td><select name="os0">
	<option value="coreBOS Code Subscription">Subscripción al Código de coreBOS : €110,00 EUR - anualmente</option>
	<option value="coreBOS Support Subscription">Subscripción Soporte coreBOS : €150,00 EUR - mensualmente</option>
    </select> </td></tr>
    </table>
    <input type="hidden" name="currency_code" value="EUR">
    <input type="image" src="https://www.paypalobjects.com/es_ES/ES/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal. La forma rápida y segura de pagar en Internet.">
    <img alt="" border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
    </form>
EOT;
    }

    function desplegableSuscripcionEN() {
    	return <<< EOT
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="9TQN3YC4VSR66">
    <table>
    <tr><td><input type="hidden" name="on0" value="coreBOS Subscription Options"><b>coreBOS Subscription Options</b></td></tr><tr><td><select name="os0">
	<option value="coreBOS Code Subscription">coreBOS Code Subscription : €110,00 EUR - anual</option>
	<option value="coreBOS Support Subscription">coreBOS Support Subscription : €150,00 EUR - monthly</option>
    </select> </td></tr>
    </table>
    <input type="hidden" name="currency_code" value="EUR">
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal. Secure and quick way to pay on the Internet.">
    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
EOT;
    }

}
