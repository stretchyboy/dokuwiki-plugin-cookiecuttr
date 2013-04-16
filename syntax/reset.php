<?php
/**
 * Plugin Now: Inserts a timestamp.
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Christopher Smith <chris@jalakai.co.uk>
 */

// must be run within DokuWiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'syntax.php';

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_cookiecuttr_reset extends DokuWiki_Syntax_Plugin {


    function getType() { return 'substition'; }
    function getSort() { return 32; }

    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\[CookieCuttrReset\]',$mode,'plugin_cookiecuttr_reset');
    }

    function handle($match, $state, $pos, &$handler) {
        return array($match, $state, $pos);
        
    }

    function render($mode, &$renderer, $data) {
        if($mode == 'xhtml'){
          $renderer->doc .= '<script>jQuery(document).ready(function() {if( jQuery.cookieAccepted() == false ) { jQuery.cookieCuttr({cookieResetButton:true});}});</script>';
            return true;
        }
        return false;
    }
}
