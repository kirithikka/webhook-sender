<?php

require_once __DIR__ . '/WebhookSender.php';
require_once __DIR__ . '/WebhooksFileProcessor.php';

// read the webhook file and get the webhooks
$webhooksFile = __DIR__ . "/../data/webhooks.txt";
$webhookFileProcessor = new WebhooksFileProcessor($webhooksFile);
$webhooks = $webhookFileProcessor->getWebhooks();

// send the webhooks
$webhookSender = new WebhookSender();
$webhookSender->sendWebhooks($webhooks);