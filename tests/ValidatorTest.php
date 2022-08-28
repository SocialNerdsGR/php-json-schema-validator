<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator;

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function test()
    {
        $file = file_get_contents(__DIR__ . '/schema.json', true);

        $schema = json_decode($file, true);
        $validator = new JsonSchemaValidator();
        $r = $validator->validate([
            'components' => [
                [
                    'type' => 'a',
                    'children' => [], // not validated
                ],
                [
                    'type' => 'b',
                    'children' => [],
                ],
                [
                    'type' => 'c',
                    'children' => [],
                ],
            ],
        ], $schema);
        foreach ($r as $violation) {
            var_dump($violation->getMessage(), $violation->getPropertyPath());
        }

        $this->assertTrue(true);
    }
}
