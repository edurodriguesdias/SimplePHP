<?php

/**
 * Project: SIMPLE PHP - Framework 
 * 
 * @copyright RFTI  www.rfti.com.br
 * @author Rafael Franco <rafael@rfti.com.br>
 */

/**
 * simplePHP module
 *
 * @package simplePHP
 * @author Rafael Franco
 * */
class simplePHP extends util {

    private $html;

    #construct

    public function __construct() {
        $this->html = $this->loadModule('html');
    }

    /**
     * getParameter get the url parameters
     *
     * @return string		
     * */
    public function getParameter($position) {
        #get the url and explode to get positions
        $url = explode('/', urldecode($_SERVER['REQUEST_URI']));
        return (count($url) > $position) ? $url[$position] : '';
    }

    /**
     * loadPage function
     * @param <string> $controler
     * @param <string> $action
     * @return void
     * */
    public function loadPage($controler, $action) {
        #load xml module
        $xml = $this->loadModule('xml');

        #load global vars
        global $template;

        #load page configuration file
        $page = file_get_contents('../view/' . $controler . '/' . $action . '.xml');
        $page_data = $xml->xml2array($page);

        #make page
        $template = $this->makePage($page_data);
        
        
        #include and load controller
        include '../control/' . $controler . '.php';
                         
        $control = new $controler();
        $action = "_action".  ucfirst($action);
        
        $control->$action();
        
        
    }

    /**
     * applyKeys function
     * Apply keys to template
     * @param <string> $html
     * @param  <array> $keys
     * @return <string> $html
     */
    public function applyKeys($html, $keys) {
        for ($x = 1; $x < 6; $x++) {
            foreach ($keys as $key => $value) {
                $html = str_replace("[#$key#]", $value, $html);
            }
        }
        return $html;
    }

    /**
     * @global array $keys
     * @param type $key
     * @param type $value 
     */
    public function setKey($key, $value) {
        global $keys;
        $keys[$key] = stripslashes($value);
    }

    /**
     * loadModule function
     *
     * @return object
     * */
    public function loadModule($moduleName) {
        #include and load module
        include '../modules/' . $moduleName . '.php';
        return new $moduleName();
    }

    /**
     * sucess function 
     * @param <string> $message
     * @param <string> $url
     * @return void
     * */
    public function sucess($message, $url) {
        global $template;
        $template = file_get_contents('../app/view/' . $this->getParameter(1) . '/sucess.html');
        $this->setKey('message', $message);
        $this->setKey('url', $url);
    }

    /**
     * redirect function
     *
     * @return void
     * */
    public function redirect($link) {

        header('location:' . $link);
        exit;
    }

    public function makePage($page_data) {


        $html = '';
        foreach ($page_data as $node => $content) {
            $html .= $this->makeContent($node);
            if (is_array($content)) {
                $html .= $this->makePage($content);
            } else {
                $html .=$this->makeContent($content);
            }
        }

        return $html;
    }

    private function makeContent($type) {

        

        switch ($type) {
            case 'root' :
                $content = $this->html->html();
            break;
            case 'header' :
                $content = $this->html->header();
            break;
        }

        return $content;
    }

}

?>