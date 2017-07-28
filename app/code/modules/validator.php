<?php
/**
* Project: SimplePHP Framework
*
* @copyright Alphacode  www.alphacode.com.br
* @author Rafael Franco <simplephp@alphacode.com.br>
*/

/**
* validator module
*
* @package validator
* @author Rafael Franco
* Class to validate documents and informations
**/
class validator {

    //variavel por definir se o sistema utiliza o conceito de contexto
    public $context = false;
    
    public function __construct(){

    }

    /**
     * Calcula o cpf e retorna verdadeiro ou falso
     * @param $cpf string
     * @return true or false
    **/
    public function cpf($cpf = false){
        $invalids = array('00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555','66666666666', '77777777777', '88888888888', '99999999999');
        if (in_array($cpf, $invalids)){
            return false;
        } else {
            if ( !function_exists('calc_digits_position') ) {
                function calc_digits_position( $digits, $position = 10, $sumDigits = 0 ) {
                    for ( $i = 0; $i < strlen( $digits ); $i++  ) {
                        $sumDigits = $sumDigits + ( $digits[$i] * $position );
                        $position--;
                    }
                    $sumDigits = $sumDigits % 11;
                    if ( $sumDigits < 2 ) {
                        $sumDigits = 0;
                    } else {
                        $sumDigits = 11 - $sumDigits;
                    }
                    $cpf = $digits . $sumDigits;
                    return $cpf;
                }
            }
            if ( ! $cpf ) {
                return false;
            }
            $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
            if ( strlen( $cpf ) != 11 ) {
                return false;
            }
            $digits = substr($cpf, 0, 9);
            $newCpf = calc_digits_position( $digits );
            $newCpf = calc_digits_position( $newCpf, 11 );
            if ( $newCpf === $cpf ) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Calcula o cnpj e retorna verdadeiro ou falso
     * @param $cnpj string
     * @return true or false
    **/
    public function cnpj($cnpj = false){
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        if (strlen($cnpj) != 14){
            return false;
        }
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++){
            $sum += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $remainder = $sum % 11;
        if ($cnpj{12} != ($remainder < 2 ? 0 : 11 - $remainder)){
            return false;
        }
        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++){
            $sum += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $remainder = $sum % 11;
        return $cnpj{13} == ($remainder < 2 ? 0 : 11 - $remainder);
    }

    public function cnh($cnh = false) {
        $result = false;
        if ( is_string( $cnh ) ) {
            if ( ( strlen( $cnh = preg_replace( '/[^\d]/' , '' , $cnh ) ) == 11 ) && ( str_repeat( $cnh{ 1 } , 11 ) != $cnh ) ){
                $dsc = 0;

                for ( $i = 0 , $j = 9 , $v = 0 ; $i < 9 ; ++$i , --$j ){
                    $v += (int) $cnh{ $i } * $j;
                }
                if ( ( $vl1 = $v % 11 ) >= 10 ) {
                    $vl1 = 0;
                    $dsc = 2;
                }
                for ( $i = 0 , $j = 1 , $v = 0 ; $i < 9 ; ++$i , ++$j )
                $v += (int) $cnh{ $i } * $j;
                $vl2 = ( $x = ( $v % 11 ) ) >= 10 ? 0 : $x - $dsc;
                $result = sprintf( '%d%d' , $vl1 , $vl2 ) == substr( $cnh , -2 );
            }
        }
        return $result;
    }

    /**
     * Remove qualquer máscara de um número pelo regex
     * @param $number int
     * @return clean number
    **/
    public function removeMaskOfNumber($number){
        $number = preg_replace('/\D/', '', $number);
        return $number;
    }

    /**
     * Valida formato do e-mail recebido
     * @param $email string
     * @return true or false
    **/
    public function email($email = false){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Valida formato da placa do veículo
     * @param $placa string
     * @return true or false
    **/
    public function placa($placa = false){
        if (preg_match('/^[A-Z]{3}\-[0-9]{4}$/', $placa)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Confirma existência da url
     * @param $url string
     * @return true or false
    **/
    public function is_url_exist($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($code == 200){
            $status = true;
        }else{
            $status = false;
        }
        curl_close($ch);
        return $status;
    }
}
?>
