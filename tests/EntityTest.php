<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions\Tests;

use Kodzila\DataAssertions\EntityAssertion;
use PHPUnit\Framework\TestCase;

final class EntityTest extends TestCase
{
    public function testValidEntity(): void
    {
        $data = [
            'title' => 'aaa',
            'name' => 1,
            'sub' => [
                'title' => 1,
            ]
        ];

        $this->expectNotToPerformAssertions();
        EntityAssertion::build($data);
    }

    public function testList(): void
    {
        $data = [0, 1, 2, 3];
        $this->expectException(\InvalidArgumentException::class);
        EntityAssertion::build($data);
    }

    public function testMixed(): void
    {
        $data = [
            'title' => 'aaa',
            1 => 'test',
        ];
        $this->expectException(\InvalidArgumentException::class);
        EntityAssertion::build($data);
    }

    public function testCollection(): void
    {
        $data = [
            [
                'title' => 'aaa',
            ],
            [
                'title' => 'bbb',
            ],
        ];
        $this->expectException(\InvalidArgumentException::class);
        EntityAssertion::build($data);
    }

}
