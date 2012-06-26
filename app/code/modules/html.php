<?php
	/**
	 * Project: SIMPLE PHP - Framework 
	 * 
	 * @copyright RFTI  www.rfti.com.br
	 * @author Rafael Franco <rafael@rfti.com.br>
	 */

	/**
	 * html module
	 *
	 * @package html
	 * @author Rafael Franco
	 **/
	class html extends util
	{
		public function __construct() 
		{
                    
		}
		

		/**
		*  Create a html select box
		* @param <boolean> $full Define if show the full tag or only the values
		* @param <array> $data
		* @param <string> $name
		* @param <int> $selected
		* @param <int> $selectOption
		* @param <string> $selectLabel
		* @param <string> $cssclass
		* @param <string> $onchange
		* @param <boolean> $disabled
		* @return select html component <string>
		*/
		public function select($full=true,$data=array(),$name='',$selected = 0,$selectOption = 1,$selectLabel = 'Selecione', $cssclass='',$onchange='#',$disabled = false ) 
		{
			$return = '';
                        if($selectOption == 1) {
				$return .= "<option value=\"0\">$selectLabel</option>\n";
			}

			if(is_array($data)){
				foreach($data as $id => $value) {
					if($selected == $id ) {
						$return .= "<option selected value=\"$id\">$value</option>\n";
					} else {
						$return .= "<option value=\"$id\">$value</option>\n";
					}
				}
			}
			$actions = '';
			if($onchange != '#') {
				$actions = "onchange=\"$onchange\"";
			}
			if($full) {
				if($disabled == true ) {
					$return = "<select disabled=\"disabled\" class=\"$cssclass\" name=\"$name\" id=\"$name\"  $actions >$return</select>\n";
					} else {
						$return = "<select class=\"$cssclass\" name=\"$name\" $actions  id=\"$name\" >$return</select>\n";
					}
				}
				return  $return;
		}
		
		/**
		 * tag function, create an html tag
		 *
		 * @return string 
		 * 
		 **/
		private function tag($tag,$content='',$attributes='')
		{
			$params = '';
			foreach ($attributes as $k => $v) {
				$params .= $k.'="'.$v.'" ';
			}
			if(in_array($tag,array('img','input'))) {
				$return =   "<$tag $params />";
			} else {
				$return =  "<$tag $params >$content</$tag>";
			}
				return $return;
		}
		
		/**
		 * div function, create an div
		 *
		 * @return string 
		 * 
		 **/
		public function div($content='',$attributes='')
		{
                    
			return $this->tag('div',$content,$attributes);
		}
                
                /**
		 * div function, create an div
		 *
		 * @return string 
		 * 
		 **/
		public function html($content='',$attributes='')
		{
                    
			return $this->tag('html',$content,$attributes);
		}
                
                /**
		 * div function, create an div
		 *
		 * @return string 
		 * 
		 **/
		public function header($content='',$attributes='')
		{
                    
			return $this->tag('header',$content,$attributes);
		}
		
		/**
		 * b function, create an b
		 *
		 * @return string 
		 * 
		 **/
		public function b($content='',$attributes='')
		{
			return $this->tag('b',$content,$attributes);
		}
		/**
		 * p function, create an p
		 *
		 * @return string 
		 * 
		 **/
		public function p($content='',$attributes='')
		{
			return $this->tag('p',$content,$attributes);
		}
		
		/**
		 * span function, create an span
		 *
		 * @return string 
		 * 
		 **/
		public function span($content='',$attributes='')
		{
			return $this->tag('span',$content,$attributes);
		}
		
		/**
		 * a function, create an a
		 *
		 * @return string 
		 * 
		 **/
		public function link($label,$href='#',$target='',$class='')
		{
			$attributes['href'] = $href;
			$attributes['target'] = $target;
			$attributes['class'] = $class;
			return $this->tag('a',$label,$attributes);
		}
		
		/**
		* img function, create an img
		*
		* @return string 
		* 
		**/
		public function img($link,$attributes='')
		{	
			$attributes['src'] = $link;
			return $this->tag('img','',$attributes);
		}
		
		/**
		* table function, create an table
		*
		* @return string 
		* 
		**/
		public function table($content,$attributes='',$striped=false,$color1='#f8f7ff',$color2='#f6f6f6') 
		{
			 $i = 0;
 		     foreach ($content as $row) {
				$htmlCol = '';
				$x = 0;
				foreach ($row as $col) {
					$htmlCol .= $this->tag('td',$col,array('id'=>$attributes['id'].$i.'_col_'.$x));
					$x++;
				}
				if($striped) {
					if($i % 2) {
						$color = $color1;
					} else {
						$color = $color2;
					}
					$htmlRows .= $this->tag('tr',$htmlCol,array('id'=>$attributes['id'].'_row_'.$i,'bgcolor'=>$color));
				} else {
					$htmlRows .= $this->tag('tr',$htmlCol,array('id'=>$attributes['id'].'_row_'.$i));
				}
				$i++;
 		     }
			return $this->tag('table',$htmlRows,$attributes);
		}
		
		/**
		* input function, create an input
		*
		* @return string 
		* 
		**/
		public function input($type,$value,$attributes='')
		{	
			$attributes['value'] = $value;
			$attributes['type'] = $type;
			return $this->tag('input','',$attributes);
		}
		

		

} // END class html

?>