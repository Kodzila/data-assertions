<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions\Tests\Field;

use Kodzila\DataAssertions\EntityAssertion;
use PHPUnit\Framework\TestCase;

final class EntityCollectionTest extends TestCase
{
    public function testSuccess(): void
    {
        $data = [
            'title' => 'aaa',
            'sub' => [
                [
                    'title' => 'test',
                ],
                [
                    'title' => 'test',
                ]
            ],
        ];

        $this->expectNotToPerformAssertions();
        EntityAssertion::build($data)->field('sub')->entityCollection();
    }

    public function testListOfStrings(): void
    {
        $data = [
            'title' => 'aaa',
            'sub' => [
                'a',
                'b',
                'c',
            ],
        ];

        $this->expectException(\InvalidArgumentException::class);
        EntityAssertion::build($data)->field('sub')->entityCollection();
    }

    public function testEntity(): void
    {
        $data = [
            'title' => 'aaa',
            'sub' => [
                'title' => 'bbb',
            ],
        ];

        $this->expectException(\InvalidArgumentException::class);
        EntityAssertion::build($data)->field('sub')->entityCollection();
    }
}
