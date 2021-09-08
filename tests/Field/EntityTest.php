<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions\Tests\Field;

use Kodzila\DataAssertions\EntityAssertion;
use PHPUnit\Framework\TestCase;

final class EntityTest extends TestCase
{
    public function testSuccess(): void
    {
        $data = [
            'title' => 'aaa',
            'sub' => [
                'title' => 'bbb',
            ],
        ];

        $this->expectNotToPerformAssertions();
        EntityAssertion::build($data)->field('sub')->entity();
    }

    public function testFailure(): void
    {
        $data = [
            'title' => 'aaa',
            'sub' => '/api/projects/d79736bf-6984-4f22-91b6-fb8f11b902b3',
        ];

        $this->expectException(\InvalidArgumentException::class);
        EntityAssertion::build($data)->field('sub')->entity();
    }

    public function testNestingSuccess(): void
    {
        $data = [
            'title' => 'aaa',
            'sub' => [
                '@id' => '/api/projects/d79736bf-6984-4f22-91b6-fb8f11b902b3',
            ],
        ];

        $this->expectNotToPerformAssertions();
        $sub = EntityAssertion::build($data)->field('sub')->entity();
        $sub->field('@id')->iri();
    }

    public function testNestingFailure(): void
    {
        $data = [
            'title' => 'aaa',
            'sub' => [
                'sub2' => [
                    '/api/projects/d79736bf-6984-4f22-91b6-fb8f11b902b3',
                ],
            ],
        ];

        $sub = EntityAssertion::build($data)->field('sub')->entity();
        $this->expectException(\InvalidArgumentException::class);
        $sub->field('2sub')->iri();
    }
}
