<?php

namespace Inviqa\Clearpay\Api\DataModels;

class Consumer
{
    /**
     * @var string
     */
    private $givenNames;
    /**
     * @var string
     */
    private $surname;
    /**
     * @var string
     */
    private $phoneNumber;
    /**
     * @var string
     */
    private $email;

    private function __construct(
        string $givenNames,
        string $surname,
        string $phoneNumber,
        string $email
    ) {
        $this->givenNames = $givenNames;
        $this->surname = $surname;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
    }

    public static function fromState(array $state): self
    {
        return new self(
            $state['givenNames'],
            $state['surname'],
            $state['phoneNumber'],
            $state['email']
        );
    }

    public function givenNames(): string
    {
        return $this->givenNames;
    }

    public function surname(): string
    {
        return $this->surname;
    }

    public function phoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function email(): string
    {
        return $this->email;
    }
}
