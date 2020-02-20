<?php
$session_id = session_id();
if (empty($session_id))
{
    session_start();
}
require("./Client.php");
$configs = include('./config.php');

$client_id = $configs['client_id'];
$client_secret = $configs['client_secret'];
$authorizationRequestUrl = $configs['authorizationRequestUrl'];
$scope = $configs['openID_scope'];
$response_type = 'code';
$redirect_uri = $configs['openID_redirect_uri'];
$state = 'RandomState';
$grant_type= 'authorization_code';


//$certFilePath = './Certificate/all.platform.intuit.com.pem';
$certFilePath = './Certificate/cacert.pem';
//$certFilePathOpenID = './Certificate/sandbox_all_platform_intuit_com.pem';
$certFilePathOpenID = './Certificate/cacert.pem';
/*At the time of development, https://accounts.platform.intuit.com/v1/openid_connect/userinfo is not available. Use sandbox instead. */
$usrInfoURL = 'https://sandbox-accounts.platform.intuit.com/v1/openid_connect/userinfo';
$tokenEndPointUrl = $configs['tokenEndPointUrl'];

$client = new Client($client_id, $client_secret, $certFilePath);
//$OpenIDclient = new Client($client_id, $client_secret, $certFilePathOpenID);

if (!isset($_GET["code"]))
{
    /*Step 1
    /*Do not use Curl, use header so it can redirect. Curl just download the content it does not redirect*/
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
    $openID_accessToken = $result['access_token'];
    //Use Sandbox certificate
    $client->setCertificate($certFilePathOpenID);
    $userInfo = $client->callForOpenIDEndpoint($openID_accessToken, $usrInfoURL);
    $_SESSION['userInfo'] = $userInfo;

    header("Location: http://localhost/OAuth2_PHP/OAuth_2/index.php");
    exit();
}

?>
