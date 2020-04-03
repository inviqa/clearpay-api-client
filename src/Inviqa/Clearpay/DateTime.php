<?php

namespace Inviqa\Clearpay;

class DateTime
{
    /**
     * @var \DateTimeInterface|null
     */
    private $dateTime;

    /**
     * DateTime constructor.
     *
     * @param \DateTimeInterface|null $dateTime
     */
    private function __construct($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public static function fromTimeString(string $time = ''): self
    {
        if (strlen($time) === 0) {
            return new self(null);
        }

        return new self(self::toDateTimeImmutable($time));
    }

    private static function toDateTimeImmutable(
        string $time
    ): \DateTimeInterface {
        return new \DateTimeImmutable(
            $time,
            new \DateTimeZone('UTC')
        );
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function asDateTime()
    {
        return $this->dateTime;
    }
}
