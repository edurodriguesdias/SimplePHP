<?php
	/**
	 * Project: SimplePHP Framework
	 * 
	 * @copyright Alphacode  www.alphacode.com.br
	 * @author Rafael Franco <simplephp@alphacode.com.br>
	 */

	/**
	 * interface module, user interface components
	 *
	 * @package interface
	 * @author Rafael Franco
	 **/
	class ui extends html
	{
		public function __construct() 
		{
	
		}
		public function pager($step,$total,$active=1,$onclick='',$moreParam='') {

             #number of pages
             $pages = intval($total/$step);
             $pages = (($pages*$step) == $total) ? $pages : $pages +1;
             $return = '';
             
             $url = explode('/', $_SERVER['REQUEST_URI']);

             $currentPage = '/'.$url[1].'/'.$url[2];
             #before
              if(($active!=1)) {
                 $values['class'] = 'stepper-before';
                 $values['onclick'] = $onclick."(".($active-1). ",'$currentPage','$moreParam')";
                 $return .= $this->span('Anterior',$values);
             }

             for($x = 1; $x<= $pages;$x++) {
                 if( ($x >= ($active-2)) && ($x<($active+3)  or ($x < 6)  )) {
                         $values['class'] = 'stepper';
                         $values['onclick'] = $onclick."($x,'$currentPage', '$moreParam')";
                         #current Step
                         if($active == $x) {
                              $values['class'] = 'stepper stepper-active';
                             $i = $this->b($x); 
                         } else {
                             $i = $x;
                         }
                         $return .= $this->span($i,$values);
                 }
             }

             #next
             if(($active+1) <= $pages) {
                 $values['class'] = 'stepper-next';
                 $values['onclick'] = $onclick."(".($active+1). ",'$currentPage','$moreParam')";
                 $return .= $this->span('Pr&oacute;xima', $values);
             }
              $return =  $this->div($return,array('id'=>'pager'));

              if($total <= $step) {
                  $return = '';
              }
              return $return;
         }

        /* MULTIPAGER - DUAS OU MAIS PAGINAÇÕES NA MESMA TELA
        * @param <int> $step
        * @param <int> $total
        * @param <int> $id_param
        * @param <string> $onclick
        * @param <string> $param
        */
        public function multiPager($step,$total,$id_param=1,$onclick='goUrl2',$param='') {
            
            $param = explode('/', $param);
            $active = $param[$id_param-1];

            $return = '';

            $url = explode('/',$_SERVER['REQUEST_URI']);
            $currentPage = '/'.$url[1].'/'.$url[2];

            # number of pages
            $pages = intval($total/$step);
            $pages = (($pages*$step) == $total) ? $pages : $pages + 1;

            # before
            if ($active > 1) {
                $values['class'] = 'stepper-before';
                $param_url = '';
                foreach ($param as $key => $item) {
                    if (($id_param-1) == $key) {
                        $param_url .= '/'.($active-1);
                    } else {
                        $param_url .= '/'.$param[$key];
                    }
                }
                $values['onclick'] = $onclick."('".$currentPage.$param_url."')";
                $return .= $this->span('Anterior',$values);
            }

            for ($x = 1; $x <= $pages; $x++) {
                if (($x >= ($active-2)) && ($x < ($active + 3) or ($x < 6))) {
                    $values['class'] = 'stepper';
                    $param_url = '';
                    foreach ($param as $key => $item) {
                        if (($id_param-1) == $key) {
                            $param_url .= '/'.$x;
                        } else {
                            $param_url .= '/'.$param[$key];
                        }
                    }
                    $values['onclick'] = $onclick."('".$currentPage.$param_url."')";
                    # current Step
                    if($active == $x) {
                        $values['class'] = 'stepper stepper-active';
                        $i = $this->b($x); 
                    } else {
                        $i = $x;
                    }
                    $return .= $this->span($i,$values);
                }
            }

            # next
            if (($active + 1) <= $pages) {
                $values['class'] = 'stepper-next';
                $param_url = '';
                foreach ($param as $key => $item) {
                    if (($id_param-1) == $key) {
                        $param_url .= '/'.($active+1);
                    } else {
                        $param_url .= '/'.$param[$key];
                    }
                }
                $values['onclick'] = $onclick."('".$currentPage.$param_url."')";
                $return .= $this->span('Pr&oacute;xima', $values);
            }
            $return =  $this->div($return,array('id'=>'pager'));

            if ($total <= $step) {
                $return = '';
            }
            
            return $return;
        }

		/**
		* dateSelector function, create a data selector html
		* @param <int> $day
		* @param <int> $mounth
		* @param <int> $year
		* @param <int> $yearStart
		* @param <int> $yearEnd
		* @return <string> $selector
		**/
		public function dateSelector($day='1',$mounth='1',$year='2011',$yearStart=1900,$yearEnd=2011,$name='')	
		{
			$selector  = $this->select(TRUE,$this->days(),$name.'Day',$day,0).'/';
			$selector .= $this->select(TRUE,$this->mounths(),$name.'Mounth',$mounth,0).'/';
			$selector .= $this->select(TRUE,$this->years($yearStart,$yearEnd),$name.'Year',$year,0);
			return  $selector;
		}
		
	}
?>
