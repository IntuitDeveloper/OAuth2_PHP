<?php
require("./Client.php");
$configs = include('./config.php');

$session_id = session_id();
if (empty($session_id))
{
    session_start();
}
$authorizationRequestUrl = $configs['authorizationRequestUrl'];
$tokenEndPointUrl = $configs['tokenEndPointUrl'];
$client_id = $configs['client_id'];
$client_secret = $configs['client_secret'];
$scope = $configs['oauth_scope'];
$redirect_uri = $configs['oauth_redirect_uri'];


$response_type = 'code';
$state = 'RandomState';
$include_granted_scope = 'false';
$grant_type= 'authorization_code';
//$certFilePath = './Certificate/all.platform.intuit.com.pem';
$certFilePath = './Certificate/cacert.pem';


$client = new Client($client_id, $client_secret, $certFilePath);


if (!isset($_GET["code"]))
{
    /*Step 1
    /*Do not use Curl, use header so it can redirect. Curl just download the content it does not redirect*/
    //$json_result = $client->getAuthorizationCode($authorizationRequestUrl, $scope, $redirect_uri, $response_type, $state, $include_granted_scope);
    //unset $_SESSION global variables
    unset($_SESSION['access_token']);
    unset($_SESSION['refresh_token']);
    $authUrl = $client->getAuthorizationURL($authorizationRequestUrl, $scope, $redirect_uri, $response_type, $state);
    header("Location: ".$authUrl);
    exit();
}
else
{
    $code = $_GET["code"];
    $responseState = $_GET['state'];
    if(strcmp($state, $responseState) != 0){
      throw new Exception("The state is not correct from Intuit Server. Consider your app is hacked.");
    }
    $result = $client->getAccessToken($tokenEndPointUrl,  $code, $redirect_uri, $grant_type);
    //record them in the session variable
    $_SESSION['access_token'] = $result['access_token'];
    $_SESSION['refresh_token'] = $result['refresh_token'];

    //
    // JS to close popup and refresh parent page
    echo '<script type="text/javascript">
                window.opener.location.href = window.opener.location.href;
                window.close();
              </script>';

}


?>
