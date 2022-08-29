<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

use Symfony\Component\Validator\Constraints as Assert;

final class FormatConstraint implements ConstraintInterface
{
    private array $formatMap;

    public function __construct()
    {
        $this->formatMap = [
            'date' => Assert\Date::class,
            'time' => Assert\Time::class,
            'date-time' => Assert\DateTime::class,
            'regex' => Assert\Regex::class,
            'email' => Assert\Email::class,
            'hostname' => Assert\Hostname::class,
            'ipv4' => Assert\Ip::class,
            'ipv6' => Assert\Ip::class,
            'url' => Assert\Url::class,
            'uuid' => Assert\Uuid::class,
        ];
    }

    public function isApplicable(array $field): bool
    {
        return array_key_exists('type', $field)
            && $field['type'] === 'string'
            && array_key_exists('format', $field)
            && array_key_exists($field['format'], $this->formatMap);
    }

    public function apply(array $field): array
    {
        $formatter = $this->formatMap[$field['format']];

        if (is_callable($formatter)) {
            return $formatter($field);
        }

        return [new $formatter];
    }
}
