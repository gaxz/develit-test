<?php

namespace common\integrations;

/**
 * Payment api adapter
 */
class Payment
{
    private $apiHandler;

    public function __construct(ApiHandler $apiHandler)
    {
        $this->apiHandler = $apiHandler;
    }

    public function getCheckoutView()
    {
        return $this->apiHandler->getCheckoutView();
    }
}