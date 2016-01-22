#!/usr/bin/php

<?php

include("captiveportal.php");

$temp = array();

// Extend stream timeout to 24 hours
stream_set_timeout(STDIN, 86400);

while ( $input = fgets(STDIN) ) {
  // Split the output (space delimited) from squid into an array.
  $temp = split(' ', $input);

  // Set the URL from squid to a temporary holder.
  $output = $temp[0] . "\n";

  // Clean the Requesting IP Address field up.
  $ip = rtrim($temp[1], "/-");
  $site = $temp[0];

  $CaptivePortal = new captiveportal();

  $logado = $CaptivePortal->logado($ip);

  // Check the requesting IP Address.
  if ( $logado == 0 ) {
    // Check the URL and rewrite it if it matches foo.example.com
    if ( strpos($temp[0], "192.168.1.1") == false ) {
      $output = "302:http://192.168.1.1:81/\n";
    }
  }

  echo $output;
}
