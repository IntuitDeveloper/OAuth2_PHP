<?php
$session_id = session_id();
if (empty($session_id))
{
    session_start();
}
$configs = include('./config.php');
$redirect_uri = $configs['oauth_redirect_uri'];
$openID_redirect_uri = $configs['openID_redirect_uri'];
$refreshTokenPage = $configs['refreshTokenPage'];
 ?>
<html>


<title>My Connect Page</title>


<?php

  if(isset($_SESSION['access_token']) && !empty($_SESSION['access_token'])){
    echo "<h2 style='text-align:center; margin:50px 0'>Retrieve OAuth 2 Tokens from Sessions:</h2>";    
    $tokens = array(
       'access_token' => $_SESSION['access_token'],
       'refresh_token' => $_SESSION['refresh_token']
    );

    echo "<p><strong>Access Token:</strong> {$_SESSION['access_token']}</p>";
    echo "<p><strong>Refresh Token:</strong> {$_SESSION['refresh_token']}</p>";

    echo "<br /> <a href='" .$refreshTokenPage . "'>
          Refresh Token
    </a> <br />";
    echo "<br /> <a href='" .$refreshTokenPage . "?deleteSession=true'>
          Clean Session
    </a> <br />";
  } else if (!empty($_SESSION['userInfo'])) {
    echo "<h2 style='text-align:center; margin:50px 0'>User information obtained from open id call</h2>";
    echo "<br><h4>Given Name: {$_SESSION['userInfo']['givenName']}</h4>";
    echo "<h4>Family Name: {$_SESSION['userInfo']['familyName']}</h4>";
    echo "<h4>Email: {$_SESSION['userInfo']['email']}</h4>";
    echo "<h4>Phone Number: {$_SESSION['userInfo']['phoneNumber']}</h4>";
    echo "<h4>Address: {$_SESSION['userInfo']['address']['streetAddress']}, &nbsp;
                       {$_SESSION['userInfo']['address']['locality']}, &nbsp;
                       {$_SESSION['userInfo']['address']['region']} - {$_SESSION['userInfo']['address']['postalCode']}
          </h4>";
  } else{
    echo "<h3>Please Complete the \"Connect to QuickBooks\" OAuth 2 flow:</h3>";
    echo '<div> Add the OAuth 2 Consumer Key and OAuth 2 Consumer Secret of your application to config.php file to enable OAuth2 flow.</div> </br>
          <div> Add the oauth_redirect_uri to config.php file. This URL is used by Intuit to redirect the user to your page when user authorized your app. </div> </br>
          <div> Click on the button below to start "Connect to QuickBooks"</div>';
    echo "<br /> <a class='imgLink' href='/OAuth2_PHP/OAuth_2/OAuth2PHPExample.php'><img style='height: 40px' src='C2QB_white_btn.png'/></a> <br />";
    echo "<h3>Please Complete the \"Sign In With Intuit\" flow:</h3>";
    echo '<div> Add the OAuth 2 Consumer Key and OAuth 2 Consumer Secret of your application to config.php file to enable OpenID flow.</div> </br>
          <div> Add the openID_redirect_uri to config.php file. This URL is used by Intuit to redirect the user to your page when the user agreed for your app retrieving their personal information. </div> </br>
          <div> Click on the button below to start "Sign in with Intuit"</div>';
    echo "<a class='imgLink' href='/OAuth2_PHP/OAuth_2/OAuthOpenIDExample.php'><img style='height: 40px' src='IntuitSignIn-lg.jpg'/></a>";
  }
 ?>



</html>