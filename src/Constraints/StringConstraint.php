<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

use Symfony\Component\Validator\Constraints as Assert;

final class StringConstraint implements ConstraintInterface
{
    private const LENGTH_MAP = [
        'minLength' => 'min',
        'maxLength' => 'max',
    ];

    public function isApplicable(array $field): bool
    {
        return array_key_exists('type', $field)
            && $field['type'] === 'string'
            && (count(array_intersect_key($field, self::LENGTH_MAP)) || array_key_exists('pattern', $field));
    }

    public function apply(array $field): array
    {
        $constraints = [];
        if (array_intersect_key($field, self::LENGTH_MAP)) {
            $constraints[] = $this->applyLengthConstraints($field);
        }

        if (array_key_exists('pattern', $field) && @preg_match($field['pattern'], '') !== false) {
            $constraints[] = new Assert\Regex($field['pattern']);
        }

        return $constraints;
    }

    private function applyLengthConstraints(array $field): Assert\Length
    {
        $constaints = [];

        foreach (self::LENGTH_MAP as $key => $value) {
            if (array_key_exists($key, $field)) {
                $constaints[$value] = $field[$key];
            }
        }

        return new Assert\Length($constaints);
    }
}
