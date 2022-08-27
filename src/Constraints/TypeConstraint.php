<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

use Symfony\Component\Validator\Constraints as Assert;

final class TypeConstraint implements ConstraintInterface
{
    const TYPES_MAP = [
        'number' => 'numeric',
        'integer' => 'int',
        'int' => 'int',
        'float' => 'float',
        'double' => 'double',
        'boolean' => 'bool',
        'string' => 'string',
        'array' => 'array'
    ];

    public function isSatisfied(array $field): bool
    {
        return array_key_exists('type', $field) && array_key_exists($field['type'], self::TYPES_MAP);
    }

    public function apply(array $field): array
    {
        return [new Assert\Type(self::TYPES_MAP[$field['type']])];
    }
}
