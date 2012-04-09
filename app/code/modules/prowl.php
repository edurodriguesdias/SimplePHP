<?php
	/**
	 * Project: SIMPLE PHP - Framework 
	 * 
	 * @copyright RFTI  www.rfti.com.br
	 * @author Rafael Franco <rafael@rfti.com.br>
	 */

	/**
	 * prowl module,a simple notification from prowl system
	 *
	 * @package prowl
	 * @author Rafael Franco
	 **/

        class prowl 
	{
                public $prowUrl;
                public $apiKey;
                public $application;
                
                public function __construct() 
		{
                    $this->prowUrl = 'https://api.prowlapp.com/publicapi/add'; 
                    $this->apiKey = '624cfa37930b048f0cdb1a7df022b90b73655ad8';
                    $this->application = 'FASHIONERA';
		}
                public function send($event,$description,$priority = 0,$redirect='') 
                {
                   
                   #set and control interval     
                   $model = new model();
                   $res = $model->getData('prowl','UNIX_TIMESTAMP(last) as last');
                   $lastProwl = $res[0]['last'];
                   $interval = 300; #seconds 5minutes
                   
                   if(time() > ($lastProwl+$interval)) {
                        $vars['apikey'] = $this->apiKey;
                        $vars['application'] = $this->application;

                        $vars['priority'] = $priority;
                        $vars['url'] = $redirect;

                        $vars['event'] = $event;
                        $vars['description'] = $description;

                        $ch = curl_init($this->prowUrl);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_VERBOSE, 0);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $return = curl_exec ($ch);

                        curl_close ($ch);
                        
                        #update prow sended
                        $model->alterData('prowl', array('last'=> time()));
                   }
                }             
        }
?>
