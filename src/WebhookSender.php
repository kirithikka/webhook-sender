<?php

class WebhookSender
{
    private $delay;

    private $failedEndPointsCounts;

    const MAX_RETRY_DELAY = 60; // 1 minute

    const FAILED_WEBHOOKS_THRESHOLD = 5;

    /**
     * Send the webhooks to their endpoints(webhook url)
     *
     */
    public function sendWebhooks(array $webhooks)
    {
        foreach ($webhooks as $webhook) {
            $webhookUrl = $webhook->getUrl();

            // check if the end point has failed. If yes, don't send the webhook
            if (isset($this->failedEndPointsCounts[$webhookUrl])
                && $this->failedEndPointsCounts[$webhookUrl] >= self::FAILED_WEBHOOKS_THRESHOLD
            ) {
                continue;
            }

            $this->intialiseDelay();

            // if the webhook is not successfully sent, retry using an 
            // exponential backoff strategy
            while ($this->delay <= self::MAX_RETRY_DELAY) {
                echo "\n" . $this->delay;
                if ($webhook->sendToDestination()) {
                    break;
                }

                sleep($this->delay);
                $this->delay = 2 * $this->delay;
            }

            // after the maximum retry delay(1 min), 
            // add the webhook endpoint to failed end points and increment its count
            if ($this->delay > self::MAX_RETRY_DELAY) {
                $this->incrementFailedEndPointsCounts($webhookUrl);
            }
        }
    }

    /**
     * Initialise the delay
     *
     */
    private function intialiseDelay()
    {
        $this->delay = 1;
    }

    /**
     * Add failed end point and increment its count
     *
     */
    private function incrementFailedEndPointsCounts($url)
    {
        if (isset($failedEndPointsCounts[$url])) {
            $this->failedEndPointsCounts[$url]++;
        } else {
            $this->failedEndPointsCounts[$url] = 0;
        }
    }
}
