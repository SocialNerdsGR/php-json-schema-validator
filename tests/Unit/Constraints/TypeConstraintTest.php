<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator\Constraints;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;

class TypeConstraintsTest extends TestCase
{
    private readonly TypeConstraint $constraint;

    public function setUp(): void
    {
        $this->constraint = new TypeConstraint();
    }

    /**
     * @dataProvider provideValidTypes()
     */
    public function test_should_apply_when_type_field_exists($key): void
    {
        $this->assertTrue($this->constraint->isApplicable(['type' => $key]));
    }

    public function test_should_apply_when_type_field_does_notexist(): void
    {
        $this->assertFalse($this->constraint->isApplicable(['format' => 'uuid']));
    }

    /**
     * @dataProvider provideValidTypes()
     */
    public function test_should_apply_type_constraint($given, $expected): void
    {
        $this->assertEquals([new Assert\Type($expected)], $this->constraint->apply(['type' => $given]));
    }

    public function provideValidTypes(): array
    {
        return [
            ['number', 'numeric'],
            ['integer', 'int'],
            ['int', 'int'],
            ['float', 'float'],
            ['double', 'double'],
            ['boolean', 'bool'],
            ['string', 'string'],
            ['array', 'array'],
        ];
    }
}
