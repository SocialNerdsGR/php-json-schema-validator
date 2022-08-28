<?php

declare(strict_types=1);


namespace SocialNerds\JsonSchemaValidator\Constraints;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

final class ConstraintsCollection implements Countable, IteratorAggregate
{
    private const CONSTRAINTS = [
        TypeConstraint::class,
        StringConstraint::class,
        FormatConstraint::class,
        EnumConstraint::class,
        ArrayConstraint::class,
    ];

    public function count(): int
    {
        return count(self::CONSTRAINTS);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator(self::CONSTRAINTS);
    }
}
