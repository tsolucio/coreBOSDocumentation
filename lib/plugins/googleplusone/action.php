<?php
/**
 * Google +1 Plugin: Embeds +1 button into page
 *
 * @license    GPLv3 (http://www.gnu.org/licenses/gpl.html)
 * @link       http://www.dokuwiki.org/plugin:googleplusone
 * @author     Markus Birth <markus@birth-online.de>
 */

if ( !defined( 'DOKU_INC' ) ) die();
if ( !defined( 'DOKU_PLUGIN' ) ) define( 'DOKU_PLUGIN', DOKU_INC.'lib/plugins/' );
require_once( DOKU_PLUGIN.'action.php' );

class action_plugin_googleplusone extends DokuWiki_Action_Plugin {

    /**
     * return some info
     */
    function getInfo() {
        return confToHash( dirname(__FILE__).'/INFO.txt' );
    }

    /*
     * plugin should use this method to register its handlers with the dokuwiki's event controller
     */
    function register(&$controller) {
        $controller->register_hook( 'JQUERY_READY', 'BEFORE', $this, '_addjs' );
        $controller->register_hook( 'TPL_METAHEADER_OUTPUT', 'BEFORE', $this, '_addscript' );
    }

    function _addjs(&$event, $param) {
        global $ID;
        $event->data[] = 'jQuery( \'div.trace\' ).append( \'<div id="googleplusone" class="no"><g:plusone size="small"></g:plusone></div>\' );';
    }

    function _addscript( &$event, $param ) {
        $event->data['script'][] = array(
            'type' => 'text/javascript',
            'charset' => 'utf-8',
            '_data' => '{lang: \'en\'}',
            'src' => 'https://apis.google.com/js/plusone.js',
        );
    }
}
