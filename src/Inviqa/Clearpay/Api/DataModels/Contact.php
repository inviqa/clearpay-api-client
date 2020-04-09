<?php

namespace Inviqa\Clearpay\Api\DataModels;

class Contact
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $line1;
    /**
     * @var string
     */
    private $line2;
    /**
     * @var string
     */
    private $area1;
    /**
     * @var string
     */
    private $area2;
    /**
     * @var string
     */
    private $region;
    /**
     * @var string
     */
    private $postcode;
    /**
     * @var string
     */
    private $countryCode;
    /**
     * @var string
     */
    private $phoneNumber;

    private function __construct(
        string $name,
        string $line1,
        string $line2,
        string $area1,
        string $area2,
        string $region,
        string $postcode,
        string $countryCode,
        string $phoneNumber
    ) {
        $this->name = $name;
        $this->line1 = $line1;
        $this->line2 = $line2;
        $this->area1 = $area1;
        $this->area2 = $area2;
        $this->region = $region;
        $this->postcode = $postcode;
        $this->countryCode = $countryCode;
        $this->phoneNumber = $phoneNumber;
    }

    public static function fromState(array $state = []): self
    {
        return new self(
            $state['name'] ?? '',
            $state['line1'] ?? '',
            $state['line2'] ?? '',
            $state['area1'] ?? '',
            $state['area2'] ?? '',
            $state['region'] ?? '',
            $state['postcode'] ?? '',
            $state['countryCode'] ?? '',
            $state['phoneNumber'] ?? ''
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function line1(): string
    {
        return $this->line1;
    }

    public function line2(): string
    {
        return $this->line2;
    }

    public function area1(): string
    {
        return $this->area1;
    }

    public function area2(): string
    {
        return $this->area2;
    }

    public function region(): string
    {
        return $this->region;
    }

    public function postcode(): string
    {
        return $this->postcode;
    }

    public function countryCode(): string
    {
        return $this->countryCode;
    }

    public function phoneNumber(): string
    {
        return $this->phoneNumber;
    }
}
