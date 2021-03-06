<?php



	/**
	 * Project: SimplePHP Framework
	 *
	 * @copyright Alphacode  www.alphacode.com.br
	 * @author Rafael Franco <simplephp@alphacode.com.br>
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
		*  Create a html   box
		* @param <boolean> $full Define if show the full tag or only the values
		* @param <array> $data
		* @param <string> $name
		* @param <int> $selected
		* @param <int> $selectOption
		* @param <string> $selectLabel
		* @param <string> $cssclass
		* @param <string> $onchange
		* @param <boolean> $disabled
		* @param <array> $extraParam
		* @return select html component <string>
		*/
		public function select($full=true,$data=array(),$name='',$selected = 0,$selectOption = 1,$selectLabel = 'Selecione', $cssclass='',$onchange='#',$disabled = false, $extraParam = '' )
		{
			$return = '';
         if($selectOption == 1) {
				$return .= "<option value=\"0\">$selectLabel</option>\n";
			}

			if($extraParam != '') {
				foreach ($extraParam as $key => $value) {
					$params .= ' '.$key.'="'.$value.'"';
				}
			}

			if(is_array($data)){
				foreach($data as $id => $value) {
					if( $selected == $id ) {
						$return .= "<option selected value=\"$id\" $params >$value</option>\n";
					} else {
						$return .= "<option value=\"$id\" $params >$value</option>\n";
					}
				}
			}
			
			$actions = '';
			if($onchange != '#') {
				$actions = "onchange=\"$onchange\"";
			}

			if($full) {
				if($disabled == true ) {
					$return = "<select disabled=\"disabled\" class=\"$cssclass\" name=\"$name\" id=\"$name\"  $actions $params >$return</select>\n";
					} else {
						$return = "<select class=\"$cssclass\" name=\"$name\" $actions  id=\"$name\" $params >$return</select>\n";
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
			if(is_array($attributes)) {
				foreach ($attributes as $k => $v) {
					$params .= $k.'="'.$v.'" ';
				}
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
		 * h1 function, create an h1
		 *
		 * @return string
		 *
		 **/
		public function h1($content='',$attributes='')
		{
			return $this->tag('h1',$content,$attributes);
		}
		/**
		 * h2 function, create an h2
		 *
		 * @return string
		 *
		 **/
		public function h2($content='',$attributes='')
		{
			return $this->tag('h2',$content,$attributes);
		}
		/**
		 * h3 function, create an h3
		 *
		 * @return string
		 *
		 **/
		public function h3($content='',$attributes='')
		{
			return $this->tag('h3',$content,$attributes);
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
		 * ul function, create an ul
		 *
		 * @return string
		 *
		 **/
		public function ul($content='',$attributes='')
		{
			return $this->tag('ul',$content,$attributes);
		}

		/**
		 * li function, create an li
		 *
		 * @return string
		 *
		 **/
		public function li($content='',$attributes='')
		{
			return $this->tag('li',$content,$attributes);
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
		public function table($content,$attributes=array('class'=>'contentTable'),$striped=false,$color1='#f8f7ff',$color2='#f6f6f6',$full = true)
		{
			 $i = 0;
 		     foreach ($content as $row) {
				$htmlCol = '';
				$x = 0;
				foreach ($row as $col) {
					$htmlCol .= $this->tag('td',$col,array('id'=>$attributes['id'].$i.'_col_'.$x,'class'=>$attributes['id'].'_col_'.$x));
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

				if($i == 0) {
				   $htmlRows =  $this->tag('thead', $htmlRows );
				}
				$i++;
 		     }
 		    if($full) {
 		    	$return = $this->tag('table',$htmlRows,$attributes);
 		    } else {
 		    	$return = $htmlRows;
 		    }
 		    return $return;

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

		/**
		* input function, create an input
		*
		* @return string
		*
		**/
		public function textArea($value,$attributes='')
		{
			return $this->tag('textArea', $value,$attributes);
		}

		/**
		* button function, create an button
		*
		* @return string
		*
		**/
		public function button($content='',$attributes='')
		{
			return $this->tag('button',$content,$attributes);
		}


} // END class html

?>
