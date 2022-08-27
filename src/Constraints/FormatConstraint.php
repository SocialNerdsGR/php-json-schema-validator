<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

use Symfony\Component\Validator\Constraints as Assert;

final class FormatConstraint implements ConstraintInterface
{
    const FORMAT_MAP = [
        'date' => 'date',
        'time' => 'time',
        'date-time' => 'date-time',
        'duration' => 'duration',
        'regex' => 'regex',
        'email' => Assert\Email::class,
        'hostname' => 'hostname',
        'ipv4' => 'ipv4',
        'ipv6' => 'ipv6',
        'uri' => 'uri',
        'uuid' => Assert\Uuid::class,
        'json' => 'json',
    ];

    public function isSatisfied(array $field): bool
    {
        return array_key_exists('type', $field)
            && $field['type'] === 'string'
            && array_key_exists('format', $field)
            && array_key_exists($field['format'], self::FORMAT_MAP);
    }

    public function apply(array $field): array
    {
        $formatter = self::FORMAT_MAP[$field['format']];
        return [new $formatter];
    }
}
