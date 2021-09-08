<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions\Tests\Field;

use Kodzila\DataAssertions\EntityAssertion;
use PHPUnit\Framework\TestCase;

final class FieldTest extends TestCase
{
    public function testFieldExists(): void
    {
        $data = [
            'content' => 'aaa',
        ];

        $this->expectNotToPerformAssertions();
        EntityAssertion::build($data)->field('content');
    }

    public function testFieldNotExists(): void
    {
        $data = [
            'content' => 'aaa',
        ];

        $this->expectException(\InvalidArgumentException::class);
        EntityAssertion::build($data)->field('other');
    }

    public function testNoField(): void
    {
        $data = [
            'content' => 'aaa',
        ];

        EntityAssertion::build($data)->noField('other');
        $this->expectException(\InvalidArgumentException::class);
        EntityAssertion::build($data)->noField('content');
    }
}
