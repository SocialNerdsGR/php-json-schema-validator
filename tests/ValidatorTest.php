<?php

declare(strict_types=1);

namespace SocialNerds\JsonSchemaValidator;

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function test()
    {
        $file = file_get_contents('/project/code/tests/schema.json', true);

        $schema = json_decode($file, true);
        $validator = new Validator();
        $r = $validator->validate([
            // 'checked' => true,
            'id' => 1,
            'name' => 'thanos',
            'price' => 100.0,
            'email' => 'nick@gmail.com',
            'uuid' => 'c94b88aa-9910-47b1-bb66-75365d7ff0a9',
            'color' => 'red',
            'person' => [
                'email' => 'ggg',
            ],
        ], $schema);
        foreach ($r as $violation) {
            var_dump($violation->getMessage(), $violation->getPropertyPath());
        }

        $this->assertTrue(true);
    }
}
