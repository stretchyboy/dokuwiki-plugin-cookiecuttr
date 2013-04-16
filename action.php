<?php
/**
 * cookieCuttr Plugin:   EU cookie law compatible.
 *
 * @author     Martyn Eggleton <martyn.eggleton@gmail.com>
 */

if(!defined('DOKU_INC')) die();


class action_plugin_cookiecuttr extends DokuWiki_Action_Plugin {

    /**
     * Register its handlers with the DokuWiki's event controller
     */
    function register(&$controller) {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this,
                                   '_hookjs');
    }

    
    function _hookjs(&$event, $param) {
      global $ID;
      
        $aConfs = array('cookieCutter',
                        'cookieDisable', 
                        'cookiePolicyDWPage',
                        'cookieMessage',
                        'cookieDeclineButton',
                        #'cookieErrorMessage'
                        );
        
        $aOutputs = array('cookieAnalytics' => false);
        foreach($aConfs as $sName)
        {
          $aOutputs[$sName] = $this->getConf($sName);
        }
        
        if(cleanID($aOutputs['cookiePolicyDWPage']) === $ID)
        {
          $aOutputs['cookiePolicyPage'] = true;
        }
        
        $aOutputs['cookiePolicyLink'] = wl(cleanID($aOutputs['cookiePolicyDWPage']));
        
        // TODO :  filter out empty's?
        
        $sOpts = json_encode($aOutputs);
        
        $event->data["script"][] = array (
          "type" => "text/javascript",
          "charset" => "utf-8",
          "_data" => "jQuery(document).ready(function () {jQuery.cookieCuttr(".$sOpts.");});",
          );
    }
}
