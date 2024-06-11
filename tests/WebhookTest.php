<?php

require_once __DIR__ . '/../src/Webhook.php';

function testSendToDestinationSuccess()
{
    echo "\n testSendToDestinationSuccess - ";
    $webhook = new Webhook('https://webhook-test.info1100.workers.dev/success1', '1', 'Test Name', 'Test Event');
    if ($webhook->sendToDestination()) {
        echo "PASS";
    } else {
        echo "FAIL";
    }
}

function testSendToDestinationFail()
{
    echo "\n testSendToDestinationFail - ";
    $webhook = new Webhook('https://webhook-test.info1100.workers.dev/fail1', '2', 'Test Name', 'Test Event');
    if (!$webhook->sendToDestination()) {
        echo "PASS";
    } else {
        echo "FAIL";
    }
}

testSendToDestinationSuccess();
testSendToDestinationFail();

echo "\n Webhook sendToDestination tested successfully.\n";
