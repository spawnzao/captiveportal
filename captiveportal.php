<?php

class CaptivePortal{
    public $host_mysql = 'localhost';
    public $user_mysql = 'captiveportal';
    public $pass_mysql = 'captiveportal';
    public $database_mysql = 'captiveportal';

    # Mysql

    function connMySQL() {
        $this->conn = mysql_connect($this->host_mysql,$this->user_mysql,$this->pass_mysql);
        if(!$this->conn) {
                echo "Erro (connect) MySQL: ".mysql_error();
        } elseif (!mysql_select_db($this->database_mysql,$this->conn)) {
                echo "Erro (select_db) MySQL: ".mysql_error();
        }
    }

   function query($sql) {
        $this->connMySQL();
        $this->sql = $sql;
        if($this->resultado = mysql_query($this->sql)) {
                $this->closeConnMySQL();
                return $this->resultado;
        } else {
                echo "Erro (mysql_query) MySQL: " . mysql_error()."\n".$sql;
                $this->closeConnMySQL();
                exit();
        }
    }

    function getArray($sql){
        return mysql_fetch_array($sql);
    }

    function getRows($sql){
        return mysql_num_rows($sql);
    }

    function closeConnMySQL() {
        return mysql_close($this->conn);
    }

    # Funcoes Principais

    function logado($ip){
        $this->expira($ip);
        $result = $this->query("SELECT * FROM sessions where ip='$ip'");
        $users = $this->getRows($result);
        return $users;
    }

    function usuario($ip){
        $this->expira($ip);
        $result = $this->query("SELECT * FROM sessions where ip='$ip'");
        $sessions = $this->getArray($result);
        $user = $sessions['user'];
        return $user;
    }

    function expira($ip){
        $result = $this->query("SELECT * FROM sessions");
        $date1 = new DateTime(date("Y-m-d H:i:s"));
        while ($sessions = $this->getArray($result)){
            $time = $sessions['time'];
            $date2 = new DateTime($time);
            $diff = $date1->diff($date2);
            $minutes = $diff->days * 24 * 60;
            $minutes += $diff->h * 60;
            $minutes += $diff->i;
            if ($minutes > 30){
                $this->logger("expira",$sessions['user']." expirou o tempo de conexao.",$ip);
                $this->query("DELETE FROM sessions WHERE id=".$sessions['id']);
            } else {
                if ($ip == $sessions['ip']){
                    $timestamp=date("Y-m-d H:i:s");
                    $this->query("UPDATE sessions SET `time` = '".$timestamp."' WHERE `id` = ".$sessions['id'].";");
                }
            }
        }
    }

    function logger($acao,$comando,$ip) {
        $time = date("Y-m-d H:i:s");
        $sql = "insert into logs ";
        $sql = $sql."(time,action,sys,description,ip) ";
        $sql = $sql."values ";
        $sql = $sql."('".$time."','".$acao."','squid','".$comando."','".$ip."');";
        $resultado = $this->query($sql);
    }

}

?>
