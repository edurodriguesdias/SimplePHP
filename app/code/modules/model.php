<?php

/**
 * Project: SimplePHP Framework
 * 
 * @copyright Alphacode  www.alphacode.com.br
 * @author Rafael Franco <simplephp@alphacode.com.br>
 * @package model
 *
 * Classe de model genérica, reponsavel por toda a interação do projeto com o banco de dados
 * */
class model {

    //variavel responsável pela exibição ou não do debug das queryes
    public $debug = 0;

    //variavel por definir se o sistema utiliza o conceito de contexto
    public $context = false;

    public function __construct() {
            
    }

    //Habilita o debug
    public function enableDebug() {
            $this->debug = 1;
    }

    //Desabilita o debug
    public function disableDebug() {
            $this->debug = 0;
    }

    /**
     * Busca uma lista de valores de uma tabela
     * @param $table string, nome da tabela
     * @param $key string, chave para a lista
     * @param $value string, valor para a lista
     * @param $filters array, lista de filtros
     * @param $function_key string funcão para aplicação na chave : exemplo strtoupper
     * @param $function_value string funcão para aplicação no valor : exemplo strtoupper
     */
    public function getList($table, $key='id', $value='name', $filters='', $function_key='_void', $function_value='_void') {
        $data = $this->getData($table, "a.$key,a.$value", $filters, '', "a.$value asc");
        foreach ($data as $item) {
            if ($function_key != '_void') {
                $item[$key] = $function_key($item[$key]);
            }
            if ($function_value != '_void') {
                $item[$value] = $function_key($item[$value]);
            }
            $return[$item[$key]] = $item[$value];
        }
        return $return;
    }

    //função para retornar o proprio valor
    private function _void($var) {
            return($var);
    }

    /**
     * Busca os dados no banco de dados
     * @param $table string, nome da tabela
     * @param $values string, lista dos valores
     * @param $filters array lista de filtros chave e valor
     * @param $limits array - start | limit
     * @param $orderby string
     * @param $join string or array lista de joins 
     * @param $groupby string
     */
    public function getData($table, $values='a.*', $filters = '', $limits='', $orderby='a.ID DESC', $join='', $groupby='') {

            global $mdb2;

            $sql = "SELECT $values "
                    . "FROM $table as a ";
            
            //caso seja array itera os joins
            if(is_array($join)) {
                foreach ($join as $key => $value) {
                    $sql .= " $join ";
                }
            } else {
                $sql .= " $join ";
            }

            $sql .= "WHERE a.id >= 1 ";

            $sql .= $this->makeFilters($filters);

            if($this->context) {
                $sql .= " AND a.conta_id = " . $_SESSION['conta_id'];
            }

            if ($groupby != '') {
                    $sql .= " group by $groupby ";
            }

            $sql .= " ORDER BY " . $orderby . " ";

            if ($limits != '') {
                    $sql .= "Limit $limits[start], $limits[limit];";
            }

            if ($this->debug == 1) {
                echo "<br><b>$sql</b><br>";
                $arq = fopen("../logs/query-select-errors.txt",'a+');
                fwrite($arq,$sql." - ".@date('d/m/Y h:i:s').'/n');
            }
            
            $res = $mdb2->loadModule('Extended')->getAll($sql, null, array(), '', MDB2_FETCHMODE_ASSOC);

            if (count($res) == 0) {
                $res[0]['result'] = 'empty';
            }

            return $res;
    }

    
    /**
    *   Função responsável por criar os filtros de sql
    **/
    private function makeFilters($filters){ 
		$sql = ''; 
        if ($filters != '') {
                foreach ($filters as $key => $value) {
                       if (substr(trim($key), 0, 2) != 'in') {
                        $key    = addslashes($key);
                        $value  = addslashes($value);
                       }
                        
                        if (substr_count($key, 'like') == 1) {
                                
                                if (substr(trim($key), 0, 9) == 'likeAfter') {
                                     $key = str_replace('likeAfter', '', $key);
                                     $sql .= "AND $key like '$value%' ";   
                                } else {
                                    if (substr(trim($key), 0, 10) == 'likeBefore') {
                                        $key = str_replace('likeBefore', '', $key);
                                        $sql .= "AND $key like '%$value' ";   
                                    } else {
                                        $key = str_replace('like ', '', $key);
                                        $sql .= "AND $key like '%$value%' ";   
                                    }     
                                }
                        } else if (substr(trim($key), 0, 2) == 'or') {
                                $key = str_replace('or ', '', $key);
                                $sql .= "OR $key = '$value' ";
                        } else if (substr(trim($key), 0, 2) == 'in') {
                                $key = str_replace('in ', '', $key);
                                $sql .= "AND $key in $value ";
                        } else if (substr(trim($key), 0, 5) == 'notin') {
                                $key = str_replace('notin ', '', $key);
                                $sql .= "AND $key not in $value ";
                        } else if (substr(trim($key), 0, 3) == 'dif') {
                                $key = str_replace('dif', '', $key);
                                $sql .= "AND $key != '$value' ";
                        } else if (substr(trim($key), 0, 1) == '<') {
                                $key = str_replace('<', '', $key);
                                $sql .= "AND $key < $value ";
                        } else if (substr(trim($key), 0, 1) == '>') {
                                $key = str_replace('>', '', $key);
                                $sql .= "AND $key > $value ";
                        } else {
                                if (is_string($value)) {
                                        $sql .= "AND $key = '$value' ";
                                } else {
                                        $sql .= "AND $key = $value ";
                                }
                        }
                }
        }
      
        return $sql;
    }
    
    
    /**
     * Insere dados no banco
     * @param $table string, nome da tabela
     * @param $data array, array de dados
     * @param $saveIp bool, salvar ip sim ou não
     * @return <array>
     */
    public function addData($table, $data, $saveIp = false) {
        global $mdb2;

        if($saveIp) {
            $data['ip'] = $_SERVER['REMOTE_ADDR'];
        }

        if($context) {
            $data['usuario_id'] = $_SESSION['usuario_id'];
            $data['conta_id'] = $_SESSION['conta_id'];
        }

        $sql = "INSERT INTO $table ( `id` ";
        extract($data);

        $id = "NULL";

        foreach ($data as $key => $value) {
                $sql .= ",`$key`";
        }
        $sql .= ") VALUES ( " . $id . " ";
        foreach ($data as $key => $value) {
            $key    = addslashes($key);
            $value  = addslashes($value);
                    
            if ($value == 'NULL') {
                    $sql .= ", $value";
            } else if (is_string($value)) {
                    $sql .= ", '$value'";
            } else {
                    if ($value) {
                            $sql .= ", $value";
                    } else {
                            $sql .= ", ''";
                    }
            }
        }
        $sql .= ");";
        
        if ($this->debug == 1) {
            echo "<br><b>$sql</b><br>";
        }        
        $mdb2->query($sql);
        if ($mdb2->lastInsertID($table, 'id') == 0) {
            $arq = fopen("../logs/query-insert-errors.txt", 'a+');
            fwrite($arq, $sql . " - " . @date('d/m/Y h:i:s') . '');
            return array('status'=>'erro','sql'=>$sql);
        } else {
            return $mdb2->lastInsertID($table, 'id');
        }
    }              


    /**
     * Substitui dados no banco
     * @param $table string, nome da tabela
     * @param $data array, array de dados
     * @param $saveIp bool, salvar ip sim ou não
     * @return <array>
     */
	public function replaceData($table, $data,$saveIp = false) {
        global $mdb2;

        if($saveIp) {
            $data['ip'] = $_SERVER['REMOTE_ADDR'];
        }

        $sql = "REPLACE INTO $table ( `id` ";
        extract($data);

        $id = "NULL";

        foreach ($data as $key => $value) {
                $sql .= ",`$key`";
        }
        $sql .= ") VALUES ( " . $id . " ";
        foreach ($data as $key => $value) {
                $key    = addslashes($key);
                $value  = addslashes($value);

                if ($value == 'NULL') {
                        $sql .= ", $value";
                } else if (is_string($value)) {
                        $sql .= ", '$value'";
                } else {
                        if ($value) {
                                $sql .= ", $value";
                        } else {
                                $sql .= ", ''";
                        }
                }
        }
        $sql .= ");";
        if ($this->debug == 1) {
                echo "<br><b>$sql</b><br>";
        }        
        $mdb2->query($sql);
        if (mysql_insert_id() == 0) {
                $arq = fopen("../logs/query-insert-errors.txt", 'a+');
                fwrite($arq, $sql . " - " . @date('d/m/Y h:i:s') . '
		');
                return array('status'=>'erro','sql'=>$sql);
        } else {
                return mysql_insert_id();
        }
    }

    /**
     * Conta dados no banco
     * @param $table string, nome da tabela
     * @param $filters array, array de dados
     * @param $additional string, sql adicional
     * @param $distinct bool, distinto ou não
     * @param $join string, sql adicional
     * @return <int>
     */
    public function countData($table, $filters = '', $additional = '', $distinct='', $join = "") {
            global $mdb2;

            if ($distinct == '') {
                    $sql = "SELECT count(a.id) as qtd ";
            } else {
                    $sql = "SELECT count(distinct($distinct)) as qtd ";
            }
            
            $t = explode(' ',$table);

            $sql    .= "FROM $t[0] as a  "
                    . " $join "
                    . "WHERE a.id >= 1 ";

            #makefilters     
            $sql .= $this->makeFilters($filters);
            
            if($this->context) {
                $sql .= " AND a.conta_id = " . $_SESSION['conta_id'];
            }
            
            if ($additional) {
                $sql .= " " . $additional;
            }
           
            if($this->debug == 1) {
                echo "<br><b>$sql</b><br>";
            }
           

            $res = $mdb2->loadModule('Extended')->getAll($sql, null, array(), '', MDB2_FETCHMODE_ASSOC);
            if(is_array($res)) {
                return $res[0]['qtd'];    
            } else {
                return 0;
            }
            
    }

    /**
     * Remove dados de uma tabela
     * @param $table string, nome da tabela
     * @param $filters array, array de dados
     * @return <boolean>
     */
    public function removeData($table, $filters) {
        global $mdb2;
        $sql = "Delete  "
                . "FROM $table "
                . "WHERE id >= 1 ";
        
        if ($filters != '') {
                foreach ($filters as $key => $value) {
                        $key    = addslashes($key);
                        $value  = addslashes($value);
                
                        if (substr_count($value, 'like') == 1) {
                                $value = str_replace('like ', '', $value);
                                $sql .= "AND $key like '%$value%' ";
                        } else if (substr(trim($value), 0, 2) == 'in') {
                                $value = str_replace('in ', '', $value);
                                $sql .= "AND $key in $value ";
                        } else if (substr(trim($value), 0, 2) == '<=') {
                                $value = str_replace('<= ', '', $value);
                                $sql .= "AND $key <= '$value' ";
                        } else if (substr(trim($value), 0, 2) == '>=') {
                                $value = str_replace('>= ', '', $value);
                                $sql .= "AND $key >= '$value' ";
                        } else {
                                if (is_string($value)) {
                                        $sql .= "AND $key = '$value' ";
                                } else {
                                        $sql .= "AND $key = $value ";
                                }
                        }
                }
        }
        
        if ($this->debug == 1) {
                echo "<br><b>$sql</b><br>";
        }

        $res = $mdb2->query($sql);
        if (@$res->result != 1) {
                $arq = fopen("../logs/query-remove-errors.txt", 'a+');
                fwrite($arq, $sql . " - " . @date('d/m/Y h:i:s') . '
								');
                die('Error not removed data - See log file');
        } else {
                return true;
        }
    }

    /**
     * Altera dados de uma tabela
     * @param $table string, nome da tabela
     * @param $data array, array de dados
     * @param $filters array, array de dados
     * @return <boolean>
     */
    public function alterData($table, $data, $filter) {
        global $mdb2;

        $sql = "UPDATE $table ";
        extract($data);
        $sql .= ' SET';
        foreach ($data as $key => $value) {
                # $value = str_replace("'",'"',$value);
                $value = addslashes($value);
                if (is_string($value)) {
                        $sql .= " $key = '$value' ,";
                } else {
                        if ($value) {
                                $sql .= " $key = $value ,";
                        } else {
                                $sql .= " $key = '' ,";
                        }
                }
        }

        $sql = substr($sql, 0, strlen($sql) - 1);

        $sql .= "WHERE 1=1 ";
        if (is_array($filter)) {
                foreach ($filter as $key => $value) {
                        if (is_string($value)) {
                                $sql .= "AND $key = '$value' ";
                        } else {
                                $sql .= "AND $key = $value ";
                        }
                }
        }


        $res = $mdb2->query($sql);
        
        if ($this->debug == 1) {
                echo "<br><b>$sql</b><br>";
        }  
        if (@$res->result != 1) {
                $arq = fopen("../logs/query-update-errors.txt", 'a+');
                fwrite($arq, $sql . " - " . @date('d/m/Y h:i:s') . '
				');
                die('Error not updated data - See log file');
        } else {
                return true;
        }
    }

    /**
    * Busca as colunas de uma tabela
    * @param @column string
    * @return array 
    **/
    public function getColumns($column) {
        global $mdb2;

        $sql = "SHOW columns FROM $column ";
        if ($this->debug == 1) {
            echo "<br><b>$sql</b><br>";
        }
                
        $res = $mdb2->loadModule('Extended')->getAll($sql, null, array(), '', MDB2_FETCHMODE_ASSOC);

        if (count($res) == 0) {
            $res[0]['result'] = 'empty';
        }
        return $res;
    }

    /**
    * Adiciona colunas em uma tabela
    * @param @table string
    * @param @column string
    * @param @type string
    * @return void 
    **/
    public function addColumn($table,$column,$type) {
        global $mdb2;
        $sql = "ALTER TABLE $table ADD $column $type;";

        if ($this->debug == 1) {
            echo "<br><b>$sql</b><br>";
        }
                
        $res = $mdb2->loadModule('Extended')->getAll($sql, null, array(), '', MDB2_FETCHMODE_ASSOC);

        if (count($res) == 0) {
            $res[0]['result'] = 'empty';
        }
        return $res;
    }

    /**
    * Roda um sql generico
    * @param @sql string
    * @return boolean 
    **/
    public function sql($sql) {
        global $mdb2;
     
        if ($this->debug == 1) {
            echo "<br><b>$sql</b><br>";
        }
                
        $res = $mdb2->loadModule('Extended')->getAll($sql, null, array(), '', MDB2_FETCHMODE_ASSOC);

        if (count($res) == 0) {
            $res[0]['result'] = 'empty';
        }
        return $res;
    }

    /**
    * Busca um unico registro
    * @param $table string, nome da tabela
    * @param @id int
    * @param @chave string
    * @return array 
    **/
    public function getOne($tabela,$id,$chave='id') {
        $dados = $this->getData($tabela,'*',array($chave=>$id));
        return $dados[0];
    }
}

?>