<?php

require_once __DIR__ . '/Log.php';

class WebhookSender
{
    private $delay;

    private $failedEndPointsCounts = [];

    const MAX_RETRY_DELAY = 60; // 1 minute

    const FAILED_WEBHOOKS_THRESHOLD = 5;

    /**
     * Send the webhooks to their endpoints(webhook url)
     *
     */
    public function sendWebhooks(array $webhooks)
    {
        Log::debug("Sending webhooks");
        foreach ($webhooks as $webhook) {
            $webhookUrl = $webhook->getUrl();

            // check if the end point has failed. If yes, don't send the webhook
            if (isset($this->failedEndPointsCounts[$webhookUrl])
                && $this->failedEndPointsCounts[$webhookUrl] >= self::FAILED_WEBHOOKS_THRESHOLD
            ) {
                Log::debug("Stopped attempting to send webhook to " . $webhookUrl);
                continue;
            }

            $this->initialiseDelay();

            // if the webhook is not successfully sent, retry using an 
            // exponential backoff strategy
            while ($this->delay <= self::MAX_RETRY_DELAY) {
                if ($webhook->sendToDestination()) {
                    Log::debug("Webhook sent successfully to: " . $webhookUrl);
                    break;
                }

                Log::debug("Failed to send webhook to: " . $webhookUrl . " - Retrying in " . $this->delay . " seconds");
                sleep($this->delay);
                $this->delay *= 2;
            }

            // after the maximum retry delay(1 min), 
            // add the webhook endpoint to failed end points and increment its count
            if ($this->delay > self::MAX_RETRY_DELAY) {
                $this->incrementFailedEndPointsCounts($webhookUrl);
                Log::debug("Max retries reached. Failed to send webhook to: " . $webhookUrl);
            }
        }
    }

    /**
     * Initialise the delay
     *
     */
    private function initialiseDelay()
    {
        $this->delay = 1;
    }

    /**
     * Add failed end point and increment its count
     *
     */
    private function incrementFailedEndPointsCounts($url)
    {
        if (isset($this->failedEndPointsCounts[$url])) {
            $this->failedEndPointsCounts[$url]++;
        } else {
            $this->failedEndPointsCounts[$url] = 1;
        }
    }
}
