<?php

  // (c) 2017 Phillip R Berger - phillip@berger.land
  // http://www.berger.land
  //
  // Free to use this under GNU General Public License v3.0
  // Attribute me where you can
  //
  // This file checks the hash coming from GitHub and only pulls the code if that hash matches
  // based on the shared secret and other criteria that come from GitHub

  if (isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {

    if (isset($_POST['payload'])) {
      
      // Put the shared secret which you told GitHub about below here
      $sharedSecret = "";

      // This grabs the entire payload without any bitwise variances
      $payload = file_get_contents('php://input');

      $hubSignature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

      list($algo, $hash) = explode('=', $hubSignature, 2);

      $payloadHash = hash_hmac($algo, $payload, $sharedSecret);

      $json = json_decode($_POST['payload']);

      if ($hash === $payloadHash) {
        
        // You could modify this if you wanted to check for another branch name besides 'master'.
        // By default this script will only pull on changes to master and ignore other branches.
        if ($json->ref === "refs/heads/master") {
          echo shell_exec("git fetch --all") . PHP_EOL;
          echo shell_exec("git reset --hard origin/master");
        }
        else {
          echo $json->ref . " branch detected. Ignoring.";
        }
      }
      else {
        echo "Bad hash. Access denied.";
      }
    }
    else {
      echo "No valid payload detected.";
    }
  }
  else {
    echo "No valid signature detected.";
  }

?>