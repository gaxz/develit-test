<?php
if (env("PAYSON_API_MODE") == "PROD") {
    $paysonApi = [
        'paysonApiAgentId' => env("PAYSON_PRODUCTION_AGENT_ID"),
        'paysonApiKey' => env("PAYSON_PRODUCTION_API_KEY"),
    ];
} else {
    $paysonApi = [
        'paysonApiAgentId' => env("PAYSON_TEST_AGENT_ID"),
        'paysonApiKey' => env("PAYSON_TEST_API_KEY"),
    ];
}

return array_merge([
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,

], $paysonApi);
