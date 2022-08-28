<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

use SocialNerds\JsonSchemaValidator\Parser;
use Symfony\Component\Validator\Constraints as Assert;

final class ArrayConstraint implements ConstraintInterface
{
    public function isApplicable(array $field): bool
    {
        return $field['type'] === 'array';
    }

    public function apply(array $field): array
    {
        $parser = new Parser();
        $itemsConstraints = $parser->parse($field['items'] ?? []);

        return [
            new Assert\All([
                $itemsConstraints,
            ]),
        ];
    }
}
