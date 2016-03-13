<?php

/**
 * Project: SimplePHP Framework
 * 
 * @copyright Alphacode  www.alphacode.com.br
 * @author Rafael Franco <simplephp@alphacode.com.br>
 */

/**
 *  admin class
 *
 * @package admin
 * @author Rafael Franco
 * */
class master extends simplePHP {
        public $session;

        public function __construct() {
         	global $keys;
                //load modules
                $this->session = $this->loadModule('session');
                $this->model = $this->loadModule('model');
                $this->html = $this->loadModule('html');

         	$this->keys['header'] = file_get_contents(SIMPLEPHP_PATH.'/app/code/view/master/header.php');
            
        }
        public function _actionStart() {
         	return $this->keys;
        }
        /**
         * Do login on Simple PHP Master area
         * */
        public function _actionLogin() {
                if((MASTER_LOGIN == $_POST['login']) && (MASTER_PASSWD == $_POST['pass'])) {
                        $this->session->add('master','logged');
                        $this->redirect('/master/dashboard');
                } else {
                        $this->showError('Login e senha incorretos','/master');
                }
        }

        public function _actionDashboard() {
                $modulos = $this->model->getList('adm_modulos','id','nome');
                foreach ($modulos as $key => $value) {
                        $modulo = $value .' ';
                        $modulo .= '['.$this->html->link('Tabela','/master/configuraTabela/'.$key).']';
                        $modulo .= '['.$this->html->link('Gerar views','/master/configuraTabela/'.$key).']';
                        $modulo .= '['.$this->html->link('Gerar controller','/master/configuraTabela/'.$key).']';
                        $this->keys['modulos'] .= $this->html->li($modulo);
                }
                return $this->keys;
        }

        public function _actionConfiguratabela() {
                $modulo = $this->model->getOne('adm_modulos',$this->getParameter(3));
                $this->keys['modulo'] = $modulo['nome'];
                return $this->keys;
        }

        public function _actionaddModule() {

                
                $this->model->addData('adm_modulos',$_POST);
                
                $this->redirect('/master/dashboard');
        }
        public function _actionaddTable() {

                
                pre($_POST);        
        
        }
}
?>
