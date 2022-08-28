<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator;

use Symfony\Component\Validator\ConstraintViolationListInterface;

interface SchemaValidator
{
    public function validate(array $payload, array $schema): ConstraintViolationListInterface;
}
