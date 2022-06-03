<?php

namespace common\integrations;

use Payson\Payments\CheckoutClient;

class PaysonApiHandler implements ApiHandler
{
    public $checkoutClient;
    
    public function __construct(CheckoutClient $checkoutClient)
    {
        $this->checkoutClient = $checkoutClient;
    }

    public function getCheckoutView()
    {
        $view = $this->checkoutClient->create($this->dataSample());

        return $view['snippet'];
    }

    public function dataSample()
    {
        // Get protocol for URLs
        $protocol = 'http://';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $protocol = 'https://';
        }

        return [
            'customer' => [
                'city' => 'Stan',
                'identityNumber' => '4605092222',
                'email' => 'tess.t.persson@test.se',
                'firstName' => 'Tess T',
                'lastName' => 'Persson',
                'postalCode' => '99999',
                'street' => 'Testgatan 1'
            ],
            'order' => [
                'currency' => 'sek',
                'items' => [
                    [
                        'name' => 'Product 1',
                        'quantity' => 1.00,
                        'unitPrice' => 99.00,
                        'taxRate' => 0.25
                    ],
                    [
                        'name' => 'Product 2',
                        'quantity' => 2.00,
                        'unitPrice' => 299.00,
                        'taxRate' => 0.25
                    ]
                ]
            ],
            'merchant' => [
                'termsUri' => str_replace(basename($_SERVER['PHP_SELF']), 'terms.php', $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']),
                'checkoutUri' => "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
                'confirmationUri' => str_replace(basename($_SERVER['PHP_SELF']), 'confirmation.php', $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . '?ref=co2',
                'notificationUri' => str_replace(basename($_SERVER['PHP_SELF']), 'notification.php', $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . '?ref=co2'
            ],
            'gui' => [
                'colorScheme' => 'White',
                'locale' => 'sv'
            ]
        ];
    }
}
