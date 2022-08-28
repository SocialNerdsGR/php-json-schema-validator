<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator;

use InvalidArgumentException;
use SocialNerds\JsonSchemaValidator\Constraints\ConstraintsCollection;
use Symfony\Component\Validator\Constraints as Assert;

final class Parser
{
    private array $collection = [];

    private readonly ConstraintResolver $resolver;
    private readonly ConstraintsCollection $constraints;

    public function __construct()
    {
        $this->resolver = new ConstraintResolver();
        $this->constraints = new ConstraintsCollection();
    }

    public function parse(array $schema): Assert\Collection
    {
        foreach ($schema['properties'] as $key => $field) {
            $this->apply($key, $field);
        }

        foreach (array_keys($schema['properties']) as $fieldName) {
            $this->applyRequired($fieldName, $schema['required'] ?? []);
        }

        return new Assert\Collection([
            'fields' => $this->collection,
            'allowExtraFields' => $schema['allowExrtaFields'] ?? true,
        ]);
    }

    private function apply(string $key, array $field): void
    {
        if (isset($field['type']) && $field['type'] === 'object') {
            $nestedParser = new Parser();
            $this->collection[$key] = $nestedParser->parse($field);
        }

        foreach ($this->constraints as $constraintClass) {
            $constaint = $this->resolver->resolve($constraintClass);
            if ($constaint->isApplicable($field)) {
                $this->collection[$key] = array_merge($this->collection[$key] ?? [], $constaint->apply($field));
            }
        }
    }

    private function applyRequired(string $fieldName, array $requiredFields): void
    {
        $isRequired = in_array($fieldName, $requiredFields);

        if ($isRequired) {
            $this->collection[$fieldName] = new Assert\Required($this->collection[$fieldName]);
        } else {
            $this->collection[$fieldName] = new Assert\Optional($this->collection[$fieldName]);
        }
    }
}
