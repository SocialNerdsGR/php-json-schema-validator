<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

use Symfony\Component\Validator\Constraints as Assert;

final class EnumConstraint implements ConstraintInterface
{
    public function isSatisfied(array $field): bool
    {
        return array_key_exists('enum', $field);
    }

    public function apply(array $field): array
    {
        $values = is_array($field['enum']) ? $field['enum'] : [$field['enum']];

        return [new Assert\Choice($values)];
    }
}
