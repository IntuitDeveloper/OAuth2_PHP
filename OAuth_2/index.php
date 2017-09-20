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
 <script
      type="text/javascript"
      src="https://appcenter.intuit.com/Content/IA/intuit.ipp.anywhere-1.3.3.js">
 </script>

 <script type="text/javascript">
     var redirectUrl = "<?=$redirect_uri?>"
     intuit.ipp.anywhere.setup({
             grantUrl:  redirectUrl,
             datasources: {
                  quickbooks : true,
                  payments : true
            },
             paymentOptions:{
                   intuitReferred : true
            }
     });
 </script>


<title>My Connect Page</title>


<?php

  if(isset($_SESSION['access_token']) && !empty($_SESSION['access_token'])){
    echo "<h3>Retrieve OAuth 2 Tokens from Sessions:</h3>";
    $tokens = array(
       'access_token' => $_SESSION['access_token'],
       'refresh_token' => $_SESSION['refresh_token']
    );
    var_dump($tokens);
    echo "<br /> <a href='" .$refreshTokenPage . "'>
          Refresh Token
    </a> <br />";
    echo "<br /> <a href='" .$refreshTokenPage . "?deleteSession=true'>
          Clean Session
    </a> <br />";
  }else{
    echo "<h3>Please Complete the \"Connect to QuickBooks\" OAuth 2 flow:</h3>";
    echo '<div> Add the OAuth 2 Consumer Key and OAuth 2 Consumer Secret of your application to config.php file to enable OAuth2 flow.</div> </br>
          <div> Add the oauth_redirect_uri to config.php file. This URL is used by Intuit to redirect the user to your page when user authorized your app. </div> </br>
          <div> Click on the button below to start "Connect to QuickBooks"</div>';
    echo "<br /> <ipp:connectToIntuit></ipp:connectToIntuit><br />";
  }

    echo "<h3>Please Complete the \"Sign In With Intuit\" flow:</h3>";
    echo '<div> Add the OAuth 2 Consumer Key and OAuth 2 Consumer Secret of your application to config.php file to enable OpenID flow.</div> </br>
          <div> Add the openID_redirect_uri to config.php file. This URL is used by Intuit to redirect the user to your page when the user agreed for your app retrieving their personal information. </div> </br>
          <div> Click on the button below to start "Sign in with Intuit"</div>';
    //$loginStringGeneration = "<ipp:login href=\"" .$openID_redirect_uri . "\" type=\"horizontal\" ></ipp:login>";
    echo "<br /> <ipp:login href=\"" .$openID_redirect_uri . "\" type=\"horizontal\" ></ipp:login> <br />";
  //}

 ?>



</html>
