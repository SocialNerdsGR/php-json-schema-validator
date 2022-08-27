<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator;

use SocialNerds\JsonSchemaValidator\Constraints\EnumConstraint;
use SocialNerds\JsonSchemaValidator\Constraints\FormatConstraint;
use SocialNerds\JsonSchemaValidator\Constraints\StringConstraint;
use SocialNerds\JsonSchemaValidator\Constraints\TypeConstraint;
use Symfony\Component\Validator\Constraints as Assert;

final class Parser
{
    const CONSTRAINTS = [
        TypeConstraint::class,
        StringConstraint::class,
        FormatConstraint::class,
        EnumConstraint::class
    ];

    private array $collection = [];

    private readonly ConstaintResolver $resolver;

    public function __construct()
    {
        $this->resolver = new ConstaintResolver();
    }
    
    public function parse(array $schema): Assert\Collection
    {
        foreach ($schema['properties'] as $key => $field) {
            $this->apply($key, $field);
        }

        foreach (array_keys($schema['properties']) as $fieldName) {
            if (in_array($fieldName, $schema['required'])) {
                $this->collection[$fieldName] = new Assert\Required($this->collection[$fieldName]);
            } else {
                $this->collection[$fieldName] = new Assert\Optional($this->collection[$fieldName]);
            }
        }
        
        return new Assert\Collection($this->collection);
    }

    private function apply(string $key, array $field): void
    {
        if ($field['type'] === 'object') {
            $this->collection[$key] = $this->parse($field);
        }

        foreach (self::CONSTRAINTS as $constraintClass) {
            $constaint = $this->resolver->resolve($constraintClass);
            if ($constaint->isSatisfied($field)) {
                $this->collection[$key] = array_merge($this->collection[$key] ?? [], $constaint->apply($field));
            }
        }
    }
}
