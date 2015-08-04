<?php

class mysqlClass extends html {

    public function set_connection() {
        /* No settings file? goto installer... */
        if (!file_exists(APP . DS . WEB_CORE . DS . 'config/setting.php')) {
            if (!file_exists(APP . '/install'))
                die('Error: \'install\' directory is missing');
            header('Location: application/install/');
            exit;
        } else  {
            require(APP . DS . WEB_CORE . DS . 'config/setting.php');
            $connectDB = mysql_connect(DB_HOST, DB_USER, DB_PSWD) or die('<b>Connection not found , Please Configuration manually in application/config/setting.php!</b>');
            $selectDB = mysql_select_db(DB_NAME, $connectDB) or die('<b>Database not found , Configuration manually in application/config/setting.php!</b>');
            
        }
    }

    //function select
    public function SELECT($table, $rows='*', $where = NULL, $order = NULL) {
        $q = 'SELECT ' . $rows . ' FROM ' . $table;
        if ($where != null)
            $q .= ' WHERE ' . $where;
        if ($order != null)
            $q .= ' ORDER BY ' . $order;
        $this->result = mysql_query($q);
        return $this->result;
    }

    public function selectTable($tables, $rows='*', $where = NULL, $order = NULL, $limit=null, $inners=null) {
        $doNotEnclose = array();
        $q .='SELECT ';
        $count = count($tables);
        $i = 1;
        if (is_array($tables)) {
            foreach ($tables as $key => $value) {
                if (in_array($key, $doNotEnclose)) {
                    // Important when using MySQL functions like "AES_ENCRYPT", "ENCODE", "REPLACE" or such
                    $q .= $value;
                } else {
                    $q .= $key . '.' . $value;
                    if ($i++ < $count) {
                        $q.= ',';
                    }
                    if ($i == '2') {
                        $tb = $key;
                    }
                }
            }
            $q .=' FROM ' . $tb;
            foreach ($inners as $inn => $inner) {
                $q .=' INNER JOIN ';
                $q .= $inner;
            }
        } else {

            $q .=$rows;
            $q .=' FROM ';
            $q .=$tables;
            //$q .= "\n$whereClause";
        }
        if ($where != null) {
            if (is_array($where)) {
                $q .= ' WHERE ';
                $nn = 1;
                $jml = count($where);
                foreach ($where as $whr => $wh) {
                    $q .=' ' . $whr . ' = "' . $wh . '" ';

                    if ($nn++ < $jml) {
                        $q.= ' AND ';
                    }
                }
            } else {
                $q .= ' WHERE ' . $where;
            }
        }
        if ($order != null)
            $q .= ' ORDER BY ' . $order;
        if ($limit != null)
            $q .= ' ' . $limit . ' ';
        if (DEBUG != 'false')
            echo '<p style="display:block;margin:0 auto;width:100%;background:green;color:#fff;padding:10px;"><b>DEBUG:</b><br/>' . $q . '</p>';
        $this->result = mysql_query($q);
        return $this->result;
        //return $q;




        /*
          $data['table'] =$this->selectTable('posts','*',"post_id='1'","'post_id'");
         * untuk select 1 saja;
         * 
         */
        /*
         * $this->selectTable(array('posts' => '*',
          'comments' => '*', 'urls' => '*'), '', '', '',
          array('posts' => 'comments ON posts.post_id = comments.post_id','urls'=>'urls ON urls.id_url = posts.post_url'));
         */
    }

    //function insert
    public function INSERT($table, $values, $rows = null) {
        $insert = 'INSERT INTO ' . $table;
        if ($rows != null) {
            $insert .= ' (' . $rows . ')';
        }

        for ($i = 0; $i < count($values); $i++) {
            if (is_string($values[$i]))
                $values[$i] = '"' . $values[$i] . '"';
        }

        $values = implode(',', $values);

        $insert .= ' VALUES (' . $values . ')';
        $ins = mysql_query($insert);
        if ($ins) {
            return true;
        } else {
            return false;
        }
    }

    function buildQuery($type='INSERT', $table, $values, $whereClause='', $doNotEnclose=array()) {

        $table = trim($table);
        $type = trim($type);
        $type = strtoupper($type);

        switch ($type) {

            case 'INSERT':
            case 'REPLACE':
                if (empty($table) || empty($values)) {
                    return;
                }
                $q = "$type INTO `$table` (`";
                $q .= implode("`,\n`", array_keys($values));

                $q .= "`) VALUES (\n";
                $count = count($values);
                $i = 1;
                foreach ($values as $key => $value) {
                    if (in_array($key, $doNotEnclose)) {
                        // Important when using MySQL functions like "AES_ENCRYPT", "ENCODE", "REPLACE" or such
                        $q .= $value;
                    } else {
                        $q .= '\'' . $value . "'\n";
                    }
                    if ($i++ < $count) {
                        $q.= ',';
                    }
                }
                $q .= ')';
                $msg_success = 'Success saved';
                $msg_unsuccess = 'Unsuccess saved';
                break;

            case 'UPDATE':
                if (empty($table) || empty($values)) {
                    return;
                }
                $q = "UPDATE `$table` SET ";
                $count = count($values);
                $i = 1;
                foreach ($values as $key => $value) {
                    $q .= "`$key` = '" . $value . "'";
                    if ($i++ < $count) {
                        $q.= ",\n";
                    }
                }
                $q .= "\n$whereClause";
                $msg_success = 'Success updated';
                $msg_unsuccess = 'Unsuccess updated';

                break;
            case 'DELETE':
                if (empty($table)) {
                    return;
                }
                $q = "DELETE FROM `$table`";
                $q .= "\n$whereClause";
                $msg_success = 'Success deleted';
                $msg_unsuccess = 'Unsuccess deleted';
                break;
        }
        $sql = trim($q);
        ////
       // echo $sql;
        
        $sql = mysql_query($sql);
        if ($sql) {
            return "<p class='msg done'>" . $msg_success . "</p>";
        } else {
            return "<p class='msg error'>" . $msg_unsuccess . "</p>";
        }
    }

    function FetchObject($SQL = false) {
        if ($SQL) {
            return mysql_fetch_object($SQL);
        } elseif ($this->result != false) {
            return mysql_fetch_object($this->result);
        }
        return null;
    }
    function Query($sql) {
        return mysql_query($sql);
    }
    
    function FetchArray($query) {
        return mysql_fetch_array($query);
    }

    function Execute($SQL = false) {
        return mysql_query($SQL);
    }

    function NumRows($SQL = false) {
        return mysql_num_rows($SQL);
    }

}