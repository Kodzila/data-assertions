<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions\Tests\Field;

use Kodzila\DataAssertions\EntityAssertion;
use PHPUnit\Framework\TestCase;

final class IriCollectionTest extends TestCase
{
    public function testSuccess(): void
    {
        $data = [
            'title' => 'aaa',
            'sub' => [
                '/api/projects/d79736bf-6984-4f22-91b6-fb8f11b902b3',
                '/api/projects/d79736bf-6984-4f22-91b6-fb8f11b902b3',
                '/api/projects/d79736bf-6984-4f22-91b6-fb8f11b902b3',
                '/api/projects/d79736bf-6984-4f22-91b6-fb8f11b902b3',
            ],
        ];

        $this->expectNotToPerformAssertions();
        EntityAssertion::build($data)->field('sub')->iriCollection();
    }

    public function testEntityCollection(): void
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

        $this->expectException(\InvalidArgumentException::class);
        EntityAssertion::build($data)->field('sub')->iriCollection();
    }
}
