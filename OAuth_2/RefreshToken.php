<?php
require("./Client.php");
$configs = include('./config.php');

$session_id = session_id();
if (empty($session_id))
{
    session_start();
}
$tokenEndPointUrl = $configs['tokenEndPointUrl'];
$mainPage = $configs['mainPage'];
$client_id = $configs['client_id'];
$client_secret = $configs['client_secret'];


$grant_type= 'refresh_token';
//$certFilePath = './Certificate/all.platform.intuit.com.pem';
$certFilePath = './Certificate/cacert.pem';


$refresh_token = $_SESSION['refresh_token'];

$client = new Client($client_id, $client_secret, $certFilePath);
if (!isset($_GET["deleteSession"]))
{
$result = $client->refreshAccessToken($tokenEndPointUrl, $grant_type, $refresh_token);
$_SESSION['access_token'] = $result['access_token'];
$_SESSION['refresh_token'] = $result['refresh_token'];


echo '<script type="text/javascript">
            window.location.href = \'' .$mainPage . '\';
          </script>';
          
}else{
  $_SESSION['access_token'] = null;
  $_SESSION['refresh_token'] = null;

  echo '<script type="text/javascript">
              window.location.href = \'' .$mainPage . '\';
            </script>';
}

?>
