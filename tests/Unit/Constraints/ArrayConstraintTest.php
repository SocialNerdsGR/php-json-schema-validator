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

    public function test_should_return_empty_constraints_array_no_specifications_exist(): void
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
}
