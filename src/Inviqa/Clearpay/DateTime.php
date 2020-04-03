<?php

namespace Inviqa\Clearpay;

class DateTime
{
    /**
     * @var \DateTimeInterface
     */
    private $dateTime;

    private function __construct(\DateTimeInterface $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public static function fromISO8601String(string $time): self
    {
        return new self(self::validate($time));
    }

    /**
     * @param string $time
     *
     * @return \DateTimeImmutable
     */
    private static function validate(string $time)
    {
        $format = \DateTime::ISO8601;
        if (isset($time[19]) && $time[19] === '.') {
            $format = 'Y-m-d\\TH:i:s.uO';
        }

        $result = \DateTimeImmutable::createFromFormat(
            $format,
            $time,
            new \DateTimeZone('UTC')
        );

        if (!$result instanceof \DateTimeInterface) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Time string "%s" does not create "%s" class from format "%s"',
                    $time,
                    \DateTimeInterface::class,
                    $format
                )
            );
        }

        return $result;
    }

    public function asDateTime(): \DateTimeInterface
    {
        return $this->dateTime;
    }
}
