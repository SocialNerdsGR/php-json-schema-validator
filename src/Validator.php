<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface as VI;

final class Validator implements ValidatorInterface
{
    private readonly VI $validator;
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
