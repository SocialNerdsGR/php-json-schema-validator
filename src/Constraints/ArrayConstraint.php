<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

use SocialNerds\JsonSchemaValidator\Parser;
use Symfony\Component\Validator\Constraints as Assert;

final class ArrayConstraint implements ConstraintInterface
{
    public function isApplicable(array $field): bool
    {
        return isset($field['type']) && $field['type'] === 'array';
    }

    public function apply(array $field): array
    {
        $constaints = [];

        if (isset($field['$anyOf'])) {
            $constaints = [
                new Assert\AtLeastOneOf($this->handleMultiple($field['$anyOf'])),
            ];
        }

        if (isset($field['items'])) {
            $parser = new Parser();
            $constaints = $parser->parse($field['items'] ?? []);
        }

        return [
            new Assert\All(
                ['constraints' => $constaints]
            ),
        ];
    }

    private function handleMultiple(array $items): array
    {
        $constraints = [];
        foreach ($items as $item) {
            $parser = new Parser();
            $constraints[] = $parser->parse($item);
        }

        return $constraints;
    }
}
