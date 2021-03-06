<?php

/**
 * Project: SimplePHP Framework
 *
 * @copyright Alphacode  www.alphacode.com.br
 * @author Rafael Franco <simplephp@alphacode.com.br>
 */

/**
 * simplePHP module
 *
 * @package simplePHP
 * @author Rafael Franco
 * */
class simplePHP extends util {

    public $version = '0.0';
    private static $controler;
    private static $action;

    #construct simple php object
    public function __construct() {

        #get the controler
        $url_parameter[1] = str_replace('-', '', $this->getParameter(1));
        $controller_name = explode('?', $url_parameter[1]);

        self::$controler  = ($controller_name[0] == '') ? 'hotsite' : $controller_name[0] ;


        #get the action
        $url_parameter[2] = str_replace('-', '', $this->getParameter(2));
        self::$action = ($url_parameter[2] == '') ? 'start' : $url_parameter[2] ;

    }

    /**
     * getParameter get the url parameters
     *
     * @return string
     * */
    public function getParameter($position) {
        #get the url and explode to get positions
        $url = explode('/', urldecode($_SERVER['REQUEST_URI']));

        $return = (count($url) > $position) ? $url[$position] : '';
        $return = (@$return[0] == '?') ? '' : $return;
        return $return;
    }

    /**
     * loadPage function
     * @param <string> $controler
     * @param <string> $action
     * @return void
     * */
    public function loadPage() {

        #init vars
        $controler =  self::$controler;
        $action = self::$action;

        #init keys
        $keys = array();
        $keys['action'] = self::$action;
		$keys['controler'] = $controler;

        #load global vars
        global $template;
     #include and load controller
        if($controler == 'master') {
            include SIMPLEPHP_PATH.'app/code/control/' . $controler . '.php';
        } else {

            if(file_exists('../control/' . $controler . '.php')) {
                include '../control/' . $controler . '.php';
            } else {
                include '../control/hotsite.php';
                $action = $controler ;
                $controler = 'hotsite';
            }
        }

        #load page configuration file
        $page = '';
        if($controler != 'master') {
            if(is_file('../view/' . $controler . '/' . $action . '.html')) {
                	$page = file_get_contents('../view/' . $controler . '/' . $action . '.html');
                } else {
					#if have an default template, load them
	 				if(is_file('../view/' . $controler . '/default.html')) {
						$page = file_get_contents('../view/' . $controler . '/default.html');
					}
				}
        } else {
            if(is_file(SIMPLEPHP_PATH.'app/code/view/' . $controler . '/' . $action . '.html')) {
                $page = file_get_contents(SIMPLEPHP_PATH.'app/code/view/' . $controler . '/' . $action . '.html');
            } else {
	            $page = file_get_contents(SIMPLEPHP_PATH.'app/code/view/' . $controler . '/default.html');
			}
        }




        #call the controller
        $control = new $controler();
        $action = "_action".  ucfirst($action);
        $keys = array();

		if(method_exists($control,$action)) {
			$keys = $control->$action();
		} else {
			$keys = $control->_actionStart();
		}
        $keys['http_host'] = $_SERVER['HTTP_HOST'];
        #app keys

        $html = ($page != '') ? $this->applyKeys($page,$keys) : 'Template not found or empty';

        #print the page
        echo $html;



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
    public function loadModule($moduleName, $param='', $local=false) {
        global $action;

        ##test if module is not loaded
        if(!in_array($moduleName, get_declared_classes())) {
            #include and load module
            if($local) {
                include '../control/' . $moduleName . '.php';
            } else {
                include SIMPLEPHP_PATH.'app/code/modules/' . $moduleName . '.php';
            }
        }
        if($param == '') {
            return new $moduleName(self::$controler,self::$action);
        } else {
            return new $moduleName($param);
        }

    }

    /**
     * sucess function
     * @param <string> $message
     * @param <string> $url
     * @return void
     * */
    public function sucess($message, $url) {
        global $template;
        $template = file_get_contents(SIMPLEPHP_PATH.'/app/code/view/master/sucess.html');
        $this->setKey('message', $message);
        $this->setKey('url', $url);
    }


    /**
     * showError function
     * @param <string> $message
     * @param <string> $url
     * @return void
     * */
    public function showError($message, $url,$buttonMessage = 'Voltar') {
        global $template;
        $template = file_get_contents(SIMPLEPHP_PATH.'/app/code/view/master/error.html');
        $this->setKey('message', $message);
        $this->setKey('url', $url);
        $this->setKey('buttonMessage', $buttonMessage);
    }

    /**
     * redirect function
     *
     * @return void
     *
     * The 2nd, 3rd 'n 4th params are optional
     * 2nd param expects the toast type { 'show', 'info', 'success', 'warning', 'error'}
     * 3rd param expects the title that will be show in the toast
     * 4th param expects the message that will be show in the toast
     * */
    public function redirect($link, $status="", $title="", $message="") {
        if ( $status != "" ) {

            /********
                ToDo:
                    - Adicionar método em forma de array, onde serão passados os parâmetros que serão exibidos no
            ********/

            $_SESSION['toast']['status']  = $status;
            $_SESSION['toast']['title']   = $title;
            $_SESSION['toast']['message'] = $message;
        }
        header('location:' . $link);

        exit;
    }

    /**
     * includeHTML function, import html file to the current page
     * @return array
     * */
    public function includeHTML($path) {
        $return = "<!-- Start: $path -->";
		if(is_file($path)) {
			 $return .= file_get_contents($path);
		}
        $return .= "
		<!-- End: $path -->";
        #return value keys to replace in html
        return $return;
    }
}

?>
