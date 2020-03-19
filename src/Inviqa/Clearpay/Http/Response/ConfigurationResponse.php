<?php

namespace Inviqa\Clearpay\Http\Response;

use Inviqa\Clearpay\JsonHandler;

class ConfigurationResponse
{
    /**
     * @var bool
     */
    private $success;

    /**
     * @var string
     */
    private $currencyCode;

    /**
     * @var string
     */
    private $minimumAmount;

    /**
     * @var string
     */
    private $maximumAmount;

    /**
     * @var array
     */
    private $responseParams;

    public function __construct(HttpResponse $httpResponse)
    {
        $this->responseParams = JsonHandler::decode($httpResponse->content(), true);
        $this->success = !empty($this->responseParams['minimumAmount']);
        $this->currencyCode = $this->extractCurrencyCode();
        $this->minimumAmount = $this->extractMinimumAmount();
        $this->maximumAmount = $this->extractMaximumAmount();
    }

    public function isSuccessful(): bool
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode(string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return string
     */
    public function getMinimumAmount(): string
    {
        return $this->minimumAmount;
    }

    /**
     * @param string $minimumAmount
     */
    public function setMinimumAmount(string $minimumAmount): void
    {
        $this->minimumAmount = $minimumAmount;
    }

    /**
     * @return string
     */
    public function getMaximumAmount(): string
    {
        return $this->maximumAmount;
    }

    /**
     * @param string $maximumAmount
     */
    public function setMaximumAmount(string $maximumAmount): void
    {
        $this->maximumAmount = $maximumAmount;
    }

    private function extractCurrencyCode(): string
    {
        if (!empty($this->responseParams['minimumAmount']['currency'])) {
            return $this->responseParams['minimumAmount']['currency'];
        }

        return '';
    }

    private function extractMinimumAmount(): string
    {
        if (!empty($this->responseParams['minimumAmount']['amount'])) {
            return $this->responseParams['minimumAmount']['amount'];
        }

        return '';
    }

    private function extractMaximumAmount(): string
    {
        if (!empty($this->responseParams['maximumAmount']['amount'])) {
            return $this->responseParams['maximumAmount']['amount'];
        }

        return '';
    }
}
