<?php

namespace Theapi\GoogleApiClientBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Theapi\GoogleApiClientBundle\Service\ClientService;

class AuthoriseCommand extends ContainerAwareCommand {

  protected function configure() {
    $this
      // the name of the command (the part after "bin/console")
      ->setName('googleclient:authorise')

      // the short description shown while running "php bin/console list"
      ->setDescription('Authorises the goodle api client.')

    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    // Get the API client and construct the service object.
    $client = $this->getContainer()->get(ClientService::class)->getClient();
    //$service = new \Google_Service_Sheets($client);

  }
}
