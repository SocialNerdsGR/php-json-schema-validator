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

     public function test_should_apply_length_constraints(): void
     {
         $this->assertEquals([new Assert\Length(['min' => 1, 'max' => 10])], $this->constraint->apply(['minLength' => 1, 'maxLength' => 10]));
     }

     public function test_should_apply_pattern_constraints(): void
     {
         $this->assertEquals([new Assert\Regex('/name/')], $this->constraint->apply(['pattern' => '/name/']));
     }

    public function test_should_not_apply_invalid_pattern(): void
    {
        $this->assertEquals([], $this->constraint->apply(['pattern' => '\\']));
    }

     public function test_should_apply_all_constraints(): void
     {
         $this->assertEquals(
             [
                 new Assert\Length(['min' => 1, 'max' => 10]),
                 new Assert\Regex('/[a-z]/'),
             ],
             $this->constraint->apply(['pattern' => '/[a-z]/', 'minLength' => 1, 'maxLength' => 10])
         );
     }
}
