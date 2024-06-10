<?php

require_once __DIR__ . '/Webhook.php';

class WebhooksFileProcessor
{
    private $webhooksFile;

    public function __construct(string $webhooksFile)
    {
        $this->webhooksFile = $webhooksFile;
    }

    /**
     * Get the webhooks from the webhook text file
     *
     */
    public function getWebhooks(): array
    {
        $webhooks = [];

        try {
            $webhooksFile = fopen($this->webhooksFile, 'r');
            if (!$webhooksFile) {
                throw new \Exception('Webhooks text file not found!');
            }

            $isFirstLine = false;
            while (($line = fgetcsv($webhooksFile)) !== false) {
                if (!$isFirstLine) {
                    $isFirstLine = true;
                    continue;
                }

                $webhooks[] = new Webhook($line[0], $line[1], $line[2], $line[3]);
            }
        } catch(\Exception $e) {
            echo "Error in processing webhooks file";
        }

        return $webhooks;
    }
}
