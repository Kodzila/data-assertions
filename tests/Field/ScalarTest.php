<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions\Tests\Field;

use Kodzila\DataAssertions\EntityAssertion;
use PHPUnit\Framework\TestCase;

final class ScalarTest extends TestCase
{
    public function testSuccess(): void
    {
        $data = [
            'int' => 1,
            'string' => 'text',
            'bool' => false
        ];

        $this->expectNotToPerformAssertions();
        $assertion = EntityAssertion::build($data);
        $assertion->field('int')->int();
        $assertion->field('string')->string();
        $assertion->field('bool')->bool();
    }
}
