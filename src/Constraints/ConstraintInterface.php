<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

interface ConstraintInterface
{
    public function isApplicable(array $field): bool;

    public function apply(array $field): array;
}
