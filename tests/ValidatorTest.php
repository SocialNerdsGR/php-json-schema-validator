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
        $validator = new Validator();
        $r = $validator->validate([
            'checked' => true,
            'id' => 1,
            'name' => 'thanos',
            'price' => 100.0,
            'person' => [
                'id' => 1,
                'address' => [
                    'street' => '1',
                ],
            ],
            'email' => 'nick@gmail.com',
            'uuid' => 'c94b88aa-9910-47b1-bb66-75365d7ff0a9',
            'color' => 'red',
            'components' => [
                [
                    'email' => 'test@test.com',
                ],
                [
                    'name' => 'test',
                ],
            ],
        ], $schema);
        foreach ($r as $violation) {
            var_dump($violation->getMessage(), $violation->getPropertyPath());
        }

        $this->assertTrue(true);
    }
}
