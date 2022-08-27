<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator;

use SocialNerds\JsonSchemaValidator\Constraints\ConstraintInterface;

final class ConstaintResolver
{
    private array $cache = [];

    public function resolve(string $class): ConstraintInterface
    {
        if (array_key_exists($class, $this->cache)) {
            return $this->cache[$class];
        }

        return new $class;
    }
}
