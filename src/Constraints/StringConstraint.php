<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

use Symfony\Component\Validator\Constraints as Assert;

final class StringConstraint implements ConstraintInterface
{
    const STRING_MAP = [
        'minLength' => 'min',
        'maxLength' => 'min',
    ];

    public function isSatisfied(array $field): bool
    {
        return array_key_exists('type', $field)
          && $field['type'] === 'string'
          && count(array_intersect_key($field, self::STRING_MAP));
    }

    public function apply(array $field): array
    {
        $constaints = [];
        foreach (self::STRING_MAP as $key => $value) {
            if (array_key_exists($key, $field)) {
                $constaints[$value] = $field[$key];
            }
        }

        return [
          new Assert\Length($constaints)
        ];
    }
}
