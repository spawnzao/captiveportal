<?php

class CaptivePortal{
    public $server = 'ldaps://ad.seweb.corp';
    public $users = 'OU=Users,DC=seweb,DC=corp';
    public $user_default = 'administrator';
    public $pass_default = 'P@ssw0rd';
    public $host_mysql = 'localhost';
    public $user_mysql = 'captiveportal';
    public $pass_mysql = 'captiveportal';
    public $database_mysql = 'captiveportal';

    # functions das páginas

    function page(){
        if (isset($_GET['page'])){
	    switch($_GET['page'])
            {
                case 'index' : $this->logado(); $this->home(); break;
                case 'login' : $this->login(); break;
                case 'logoff' : $this->logado(); $this->logoff(); break;
                case 'logon' : $this->form_login(); break;
                case 'newpasswd' : $this->logado(); $this->newpasswd(); break;
                case 'alterstatus' : $this->logado(); $this->alterstatus(); break;
                default : $this->logado(); $this->home();
            }
	} else {
	    $this->logado();
	    $this->home();
	}
    }

    function form_login(){
	$this->erro_login();
        include('login.php');
    }

    function login(){
	$ip = $this->ip();
        $result = $this->query("SELECT * FROM sessions where ip='".$ip."'");
        $usuarios = $this->getRows($result);
        if ($usuarios > 0){
            header("Location:/");
        } elseif (($_POST['UserUsername']) and ($_POST['UserPassword'])){
            $this->user = $_POST['UserUsername'];
            $this->pass = $_POST['UserPassword'];
            $this->loginLDAP();
            if ($this->login){
		// check deny
		$result2 = $this->query("SELECT * FROM disallow where user='".$this->user."' order by id DESC limit 0,1;");
        	$qtdis = $this->getRows($result2);
		 //echo $this->user." - ".$qtdis; exit();
		if ($qtdis > 0 ){
		    $disallow = $this->getArray($result2);
		    $type = $disallow['type'];
		    if ($type == 'always'){
		    	$this->logger("login",$this->user." tentou logar, mas o usuario que esta bloqueado indefinidamente.");
                    	header("Location:/?page=logon&erro=2");
		    } else {
                        $this->logger("login",$this->user." tentou logar, mas o usuario que esta bloqueado temporariamente.");
                        header("Location:/?page=logon&erro=3");
		    }
		} else {
		    $timestamp=date("Y-m-d H:i:s");
		    $ip = $this->ip();
		    $sql = "insert into sessions ";
	 	    $sql = $sql."(user,ip,time) ";
	  	    $sql = $sql."values ";
	  	    $sql = $sql."('$this->user','$ip','$timestamp');";
		    $resultado = $this->query($sql);
                    $this->logger("login",$this->user." efetuou login.");
                    header("Location:/");
		}
            } else {
                $this->logger("login",$this->user." inseriu login ou senha inválidos.");
                header("Location:/?page=logon&erro=1");
            }
        } else {
            $this->logger("login","login ou senha em branco!");
            header("Location:/?page=logon&erro=5");
        }
    }

    function logoff(){
        $this->logger("logoff","Efetuou logoff.");
	$ip = $this->ip();
        $result=$this->query("DELETE FROM sessions WHERE ip='$ip'");
        header("Location:/?page=logon&erro=6");
    }


    function home(){
        $ip = $this->ip();
        $result = $this->query("SELECT * FROM sessions where ip='$ip'");
	$sessions = $this->getArray($result);
	$user = $sessions['user'];
	include('home.php');
	$this->expira();
    }

    # functions de conexao ldap

    function connLDAP(){
        $this->connect = @ldap_connect($this->server) or die ("Erro connection: ".ldap_error($this->connect));
        ldap_set_option($this->connect, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->connect, LDAP_OPT_REFERRALS, 0);
    }

    function loginLDAP(){
        $this->connLDAP();
        if ($this->connect){
            // autentica usuário
            $this->usermail = $this->user.'@seweb.corp';
            $this->login = @ldap_bind($this->connect,$this->usermail,$this->pass);
        }
    }

    function search($query){
        if (!isset($this->connect)){
            $this->connLDAP();
        }
        if (!isset($this->login)){
            $this->user = $this->user_default;
            $this->pass = $this->pass_default;
            $this->loginLDAP();
        }
        $return = @ldap_search($this->connect, $this->users, $query) or die ("Erro search: ".ldap_error($this->connect));
        return($return);
    }

    function get_entries($search){
        if ($search){
            $return = @ldap_get_entries($this->connect, $search) or die ("Erro entries: ".ldap_error($this->connect));
        }
        return($return);
    }

    function first_entry($search){
        if ($search){
            $return = @ldap_first_entry($this->connect, $search) or die ("Erro entry: ".ldap_error($this->connect));
        }
        return($return);
    }

    function get_dn($entry){
        if ($entry){
            $return = @ldap_get_dn($this->connect, $entry) or die ("Erro dn: ".ldap_error($this->connect));
        }
        return($return);
    }

    function modifyLDAP($dn,$value){
        if (($dn) and ($value)){
            $return = @ldap_modify($this->connect, $dn, $value) or die ("Erro modify: ".ldap_error($this->connect));
        }
        return($return);
    }

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


    # functions principais

    function erro_login(){
        if (isset($_GET['erro'])){
            switch($_GET['erro'])
            {
                case 1 : $this->msg_page = "Usuário ou senha incorretos!"; break;
            	case 2 : $this->msg_page = "Usuário bloqueado indefinitivamente!"; break;
            	case 3 : $this->msg_page = "Usuário bloqueado temporariamente!"; break;
            	case 4 : $this->msg_page = "Sessão desconectada! Por favor efetue um novo login."; break;
            	case 5 : $this->msg_page = "Por favor preencha o login e senha corretamente!"; break;
            	case 6 : $this->msg_page = "Logoff executado com sucesso!"; break;
            }
	}
    }

    function logado(){
        $ip = $this->ip();
	$result = $this->query("SELECT * FROM sessions where ip='".$ip."'");
	$usuarios = $this->getRows($result);
	if ($usuarios == 0){
            header("Location:?page=logon&erro=4");
            exit();
        } 
    }

    function expira(){
        $ip = $this->ip();
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
		$this->logger("expira",$sessions['user']." expirou o tempo de conexao.");
		$this->query("DELETE FROM sessions WHERE id=".$sessions['id']);
	    } else {
		if ($ip == $sessions['ip']){
		    $timestamp=date("Y-m-d H:i:s");
		    $this->query("UPDATE sessions SET `time` = '".$timestamp."' WHERE `id` = ".$sessions['id'].";");
		}
 	    }
	}
    }

    function logger($acao,$comando) {
	$time = date("Y-m-d H:i:s");
	$ip = $this->ip();
	$sql = "insert into logs ";
	$sql = $sql."(time,action,sys,description,ip) ";
	$sql = $sql."values ";
	$sql = $sql."('".$time."','".$acao."','captive portal','".$comando."','".$ip."');";
	$resultado = $this->query($sql);
    }

    function ip() {
        $return = $_SERVER['REMOTE_ADDR'];
	//$return = $_SERVER['HTTP_X_FORWARDED_FOR'];
        return $return;
    }

}

$class = new CaptivePortal;

?>
