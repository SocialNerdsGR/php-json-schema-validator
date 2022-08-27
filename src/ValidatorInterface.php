<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator;

use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ValidatorInterface
{
    public function validate(array $payload, array $schema): ConstraintViolationListInterface;
}
