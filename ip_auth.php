#!/usr/bin/php

<?php

require_once("captiveportal.php");

error_reporting(0);

// Make sure we have STDIN and STDOUT defined
if (! defined(STDIN)) {
        define("STDIN", fopen("php://stdin", "r"));
}
if (! defined(STDOUT)){
        define("STDOUT", fopen('php://stdout', 'w'));
        }
while( !feof(STDIN)){
        $line = trim(fgets(STDIN));
        $fields = explode(' ', $line);
        $ip = $fields[0];

        $usuario="";

        $CaptivePortal = new captiveportal();

        $logado = $CaptivePortal->logado($ip);

        if ($logado > 0){
                $usuario = $CaptivePortal->usuario($ip);
        }
        if ($usuario !="")
            $resposta="OK user={$usuario}";
        else
            $resposta="ERR";
        fwrite (STDOUT, "{$resposta}\n");

        file_put_contents('/etc/squid/mylog2.log', "\r\n".$ip." ---- ".$input." ---- ".$usuario." ---- ".$resposta." END",FILE_APPEND);
    }
?>