<?php

namespace App\Service;

use App\Entity\User;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Configuration;


class MailerService
{

  private $client;

  public function __construct(string $apiKey)
  {
    $config = Configuration::getDefaultConfiguration();

    $config->setApiKey('api-key', $apiKey);

    $httpClient = new \GuzzleHttp\Client();

    $this->client = new TransactionalEmailsApi($httpClient, $config);
  }

  public function sendMail(User $user, int $templatedId, array $params): void
  {
    $sendSmtpEmail = new SendSmtpEmail();

    $sendSmtpEmail["to"] = [
      [
        "email" => $user->getEmail(),
        "name" => $user->getFirstName(),
      ]
    ];

    $sendSmtpEmail["templateId"] = $templatedId;
    $sendSmtpEmail["params"] = $params;

    $this->client->sendTransacEmail($sendSmtpEmail);
  }
}