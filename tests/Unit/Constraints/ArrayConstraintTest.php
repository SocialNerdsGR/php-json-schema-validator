<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;

class ArrayConstraintTest extends TestCase
{
    private readonly ArrayConstraint $constraint;

    public function setUp(): void
    {
        $this->constraint = new ArrayConstraint();
    }

    public function test_should_apply_when_type_is_array(): void
    {
        $this->assertTrue($this->constraint->isApplicable(['type' => 'array']));
    }

    public function test_should_not_apply_when_type_is_not_array(): void
    {
        $this->assertFalse($this->constraint->isApplicable(['type' => 'string']));
    }

    public function test_should_handle_missing_type_field(): void
    {
        $this->assertFalse($this->constraint->isApplicable(['test' => 'string']));
    }

    public function test_should_return_empty_constraints_array_when_no_specifications_exist(): void
    {
        $this->assertEquals(
            [
                new Assert\All(['constraints' => []]),
            ],
            $this->constraint->apply([])
        );
    }

    public function test_should_use_items_field_to_apply_constraints(): void
    {
        $this->assertEquals(
            [
                new Assert\All(['constraints' => [
                    new Assert\Type('string'),
                ]]),
            ],
            $this->constraint->apply(['items' => ['type' => 'string']])
        );
    }

    public function test_should_parse_any_of_key(): void
    {
        $this->assertEquals(
            [
                new Assert\All(['constraints' => [
                    new Assert\AtLeastOneOf(
                        [
                            new Assert\Type('string'),
                            new Assert\Type('int'),
                        ]
                    ),
                ]]),
            ],
            $this->constraint->apply(['$anyOf' => [
                ['type' => 'string'],
                ['type' => 'integer'],
            ]])
        );
    }

    public function test_should_parse_any_of_with_objects(): void
    {
        $this->assertEquals(
            [
                new Assert\All(['constraints' => [
                    new Assert\AtLeastOneOf(
                        [
                            new Assert\Collection([
                                'fields' => [
                                    'name' => new Assert\Optional([
                                        new Assert\Type('string'),
                                    ]),
                                ],
                                'allowExtraFields' => true,
                            ]),
                            new Assert\Collection([
                                'fields' => [
                                    'email' => new Assert\Optional([
                                        new Assert\Type('string'),
                                        new Assert\Email(),
                                    ]),
                                ],
                                'allowExtraFields' => true,
                            ]),
                        ]
                    ),
                ]]),
            ],
            $this->constraint->apply(['$anyOf' => [
                [
                    'type' => 'object',
                    'properties' => [
                        'name' => [
                            'type' => 'string',
                        ],
                    ],
                ],
                [
                    'type' => 'object',
                    'properties' => [
                        'email' => [
                            'type' => 'string',
                            'format' => 'email',
                        ],
                    ],
                ],
            ]])
        );
    }

    public function test_array_of_objects(): void
    {
        $this->assertEquals(
            [
                new Assert\All(['constraints' => [
                    new Assert\Collection([
                        'fields' => [
                            'name' => new Assert\Optional([
                                new Assert\Type('string'),
                            ]),
                        ],
                        'allowExtraFields' => true,
                    ]),
                ]]),
            ],
            $this->constraint->apply(['items' => [
                'type' => 'object',
                'properties' => [
                    'name' => [
                        'type' => 'string',
                    ],
                ],
            ], ])
        );
    }
}
