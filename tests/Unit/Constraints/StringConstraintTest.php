<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;

class StringConstraintsTest extends TestCase
{
    private readonly StringConstraint $constraint;

    public function setUp(): void
    {
        $this->constraint = new StringConstraint();
    }

    public function test_should_apply_when_length_field_exists(): void
    {
        $this->assertTrue($this->constraint->isApplicable(['type' => 'string', 'minLength' => 2]));
    }

    public function test_should_apply_when_pattern_field_exists(): void
    {
        $this->assertTrue($this->constraint->isApplicable(['type' => 'string', 'pattern' => 'test']));
    }

    public function test_should_apply_when_all_fields_exist(): void
    {
        $this->assertTrue($this->constraint->isApplicable([
            'type' => 'string',
            'minLength' => 2,
            'maxLength' => 6,
            'pattern' => 'test',
        ]));
    }

    public function test_should_not_apply_when_type_field_is_missing(): void
    {
        $this->assertFalse($this->constraint->isApplicable([
            'minLength' => 2,
            'maxLength' => 6,
            'pattern' => 'test',
        ]));
    }

     public function test_should_not_apply_when_type_field_is_not_string(): void
     {
         $this->assertFalse($this->constraint->isApplicable([
             'type' => 'integer',
             'minLength' => 2,
             'maxLength' => 6,
             'pattern' => 'test',
         ]));
     }
}
