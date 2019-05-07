<?php


namespace App\Helper;


class CsrfTokenManager
{
    private $csrfHelper;

    public function __construct($container) {
        $this->csrfHelper = $container['csrf'];
    }

    public function generateTokens($request) {
        $nameKey = $this->csrfHelper->getTokenNameKey();
        $valueKey = $this->csrfHelper->getTokenValueKey();
        return [
            "nameKey" => $nameKey,
            "valueKey" => $valueKey,
            'name' => $request->getAttribute($nameKey),
            'value' => $request->getAttribute($valueKey)
        ];
    }
}