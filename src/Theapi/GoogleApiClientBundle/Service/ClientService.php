<?php
/**
 * See https://developers.google.com/sheets/api/quickstart/php
 *
 * Download credentials from
 * https://console.developers.google.com/apis/credentials?project=XXXX
 */

namespace Theapi\GoogleApiClientBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ClientService implements ContainerAwareInterface {

  /**
   * @var ContainerInterface|null
   */
  private $container;

  /**
   * @inheritDoc
   */
  public function setContainer(ContainerInterface $container = NULL) {
    $this->container = $container;
  }

  /**
   * @return \Google_Client
   */
  public function getClient() {

    $client = new \Google_Client();
    $client->setApplicationName($this->container->getParameter('theapi_google_api_client.application_name'));
    $client->setScopes($this->container->getParameter('theapi_google_api_client.scopes'));
    $client->setAuthConfig($this->container->getParameter('theapi_google_api_client.client_secret_path'));
    $client->setAccessType('offline');

    // Load previously authorized credentials from a file.
    $credentialsPath = $this->container->getParameter('theapi_google_api_client.credentials_path');
    if (file_exists($credentialsPath)) {
      $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {
      // Request authorization from the user.
      $authUrl = $client->createAuthUrl();
      printf("Open the following link in your browser:\n%s\n", $authUrl);
      print 'Enter verification code: ';
      $authCode = trim(fgets(STDIN));

      // Exchange authorization code for an access token.
      $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

      // Store the credentials to disk.
      if(!file_exists(dirname($credentialsPath))) {
        mkdir(dirname($credentialsPath), 0700, true);
      }
      file_put_contents($credentialsPath, json_encode($accessToken));
      printf("Credentials saved to %s\n", $credentialsPath);
    }
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
      $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
      file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
    }
    return $client;
  }

}
