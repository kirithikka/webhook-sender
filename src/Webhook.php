<?php

class Webhook
{
    private $url;
    private $orderId;
    private $name;
    private $event;

    public function __construct(string $url, string $orderId, string $name, string $event)
    {
        $this->url = $url;
        $this->orderId = $orderId;
        $this->name = $name;
        $this->event = $event;
    }

    /**
     * Get webhook url
     *
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get webhook order id
     *
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Get webhook name
     *
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get webhook event
     *
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Send the webhook to the endpoint(webhook url)
     *
     */
    public function sendToDestination()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->getUrl());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
            'order_id' => $this->getOrderId(),
            'name' => $this->getName(),
            'event' => $this->getEvent(),
        ]));

        curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return $httpCode === 200 ? true : false;
    }
}