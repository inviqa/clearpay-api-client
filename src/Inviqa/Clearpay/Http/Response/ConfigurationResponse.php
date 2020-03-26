<?php

namespace Inviqa\Clearpay\Http\Response;

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
        $this->responseParams = json_decode($httpResponse->content(), true);
        $this->success = !empty($this->responseParams['minimumAmount']);
        $this->currencyCode = $this->extractCurrencyCode();
        $this->minimumAmount = $this->extractMinimumAmount();
        $this->maximumAmount = $this->extractMaximumAmount();
    }

    public function isSuccessful()
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

    private function extractCurrencyCode()
    {
        if (!empty($this->responseParams['minimumAmount']['currency'])) {
            return $this->responseParams['minimumAmount']['currency'];
        }

        return '';
    }

    private function extractMinimumAmount()
    {
        if (!empty($this->responseParams['minimumAmount']['amount'])) {
            return $this->responseParams['minimumAmount']['amount'];
        }

        return '';
    }

    private function extractMaximumAmount()
    {
        if (!empty($this->responseParams['maximumAmount']['amount'])) {
            return $this->responseParams['maximumAmount']['amount'];
        }

        return '';
    }
}
