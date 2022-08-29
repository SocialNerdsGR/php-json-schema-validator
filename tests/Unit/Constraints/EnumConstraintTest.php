<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;

class EnumConstraintsTest extends TestCase
{
    private readonly EnumConstraint $constraint;

    public function setUp(): void
    {
        $this->constraint = new EnumConstraint();
    }

    public function test_should_apply_when_enum_field_exists(): void
    {
        $this->assertTrue($this->constraint->isApplicable(['enum' => [1, 2, 3]]));
    }

    public function test_should_not_apply_when_enum_field_does_not_exist(): void
    {
        $this->assertFalse($this->constraint->isApplicable(['items' => [1, 2, 3]]));
    }

    public function test_should_apply_enum_array(): void
    {
        $this->assertEquals([new Assert\Choice([1, 2, 3])], $this->constraint->apply(['enum' => [1, 2, 3]]));
    }

    public function test_should_apply_enum_single_value(): void
    {
        $this->assertEquals([new Assert\Choice([1])], $this->constraint->apply(['enum' => 1]));
    }
}
