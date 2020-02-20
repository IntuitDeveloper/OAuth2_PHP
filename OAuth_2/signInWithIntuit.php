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
