[![Sample Banner](views/Sample.png)][ss1]

# OAuth2_PHP



**QuickBooks OAuth2 Sample app for PHP**

The Intuit Developer team has written this OAuth 2.0 Sample App in PHP to provide working examples of OAuth 2.0 concepts, and how to integrate with Intuit endpoints.

**What is included**

The Sample app demonstrate three parts:

1) How to generate OAuth tokens 

2) How to use OpenID to get User information 

3) Refresh token and logout

**Getting Started**

Before beginning, it may be helpful to have a basic understanding of OAuth 2.0 concepts. There are plenty of tutorials and guides to get started with OAuth 2.0. Check out the docs on https://developer.intuit.com/

**PreRequisites**

PHP version > 5.6

ngrok

openSSL

DONOT USE LOCAL HOST. USE NGROK HTTPS URL.

**Setup**

***Certificate Setup***

The core of HTTPS is the handshake process. During the handshake, clients will verify that the server is exactly the server they want to communicate with -- by verifying the certificate chain on the server. For ease of use, this sample program has already provided certificate with the app under Certificate folder. For those who want to know how to get those certificate, here is the step:

1) Download the server certificate from the websites. You can follow the instruction here: <http://docs.bvstools.com/home/ssl-documentation/exporting-certificate-authorities-cas-from-a-website> Make sure you choose the X.509 format with Chain(cer)

2) Use OpenSSL to convert the crt file to pem file: 

openssl x509 -inform der -in certificate.cer -out certificate.pem


***ngrok Setup***

Since the redirected url has to be through SSL, we recommand ngrok here. Ngrok will simply assigns a temporary publicly accessible domain name (ex: https://abc123.ngrok.io) to forward to some port on your local machine (in this case, port 80).

For how to use ngrok, follow the instruction Here: <https://ngrok.com/download>


***Configuring your app***

All configuration for this app is located in config.php Locate and open this file.

We will need to update 6 items:

client_id

client_secret

oauth_redirect_uri

openID_redirect_uri

mainPage

refreshTokenPage


First 4 values must match exactly with what is listed in your app settings on developer.intuit.com. If you haven't already created an app, you may do so there. Please read on for important notes about client credentials, scopes, and redirect urls.

Once you have created an app on Intuit's Developer Portal, you can find your credentials (Client ID and Client Secret) under the "Keys" tab. You will also find a section to enter your Redirect URI here.

mainPage is the home page that located in your own server.
refreshTokenPage is the page that has the script for running refreshtokens.

You can refer to the commented value in the config.php file there. 

**Scopes**

While you are in config.php, you'll notice the scope configurations.

      'oauth_scope' => 'com.intuit.quickbooks.accounting',
      'openID_scope' => 'openid profile email',

It is important to ensure that the scopes your are requesting match the scopes allowed on the Developer Portal. 

**Run your app!**

* setting up both Developer Portal and your config.php
* Run the ngrok. For easy of use, this sample is running on port 80(default port)
    ./ngrok http 80 
* Then you will get the https url mapping to the localhost port-> https://d1eec721.ngrok.io
* Download the project and put it under your server. For mac, you can put it under Apache Server root: /Library/WebServer/Documents
* Use this as reference and paste this in browser-
    https://d1eec721.ngrok.io/OAuth_2/index.php and do enter.
  (Do not use localhost. We use seesion to record values. The session will only work with the same domain)

**Notice**

The Sample code use:
~~~php
window.opener.location.href = window.opener.location.href;
~~~

as the refresh page javscript code. Therefore, please use NGORK URL in your URI. DO NOT USE LOCALHOST

[ss1]: https://help.developer.intuit.com/s/samplefeedback?cid=9010&repoName=OAuth2_PHP
