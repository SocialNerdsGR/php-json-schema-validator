<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class JsonSchemaValidator implements SchemaValidator
{
    private readonly ValidatorInterface $validator;
    private readonly Parser $parser;

    public function __construct()
    {
        $this->parser = new Parser();
        $this->validator = Validation::createValidatorBuilder()->getValidator();
    }

    public function validate(array $payload, array $schema): ConstraintViolationListInterface
    {
        $constraints = $this->parser->parse($schema);

        return $this->validator->validate($payload, $constraints);
    }
}
