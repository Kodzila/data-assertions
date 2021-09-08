<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions\Tests\Field;

use Kodzila\DataAssertions\EntityAssertion;
use PHPUnit\Framework\TestCase;

final class IriTest extends TestCase
{
    public function testSuccess(): void
    {
        $data = [
            'content' => '/api/projects/d79736bf-6984-4f22-91b6-fb8f11b902b3',
        ];

        $this->expectNotToPerformAssertions();
        EntityAssertion::build($data)->field('content')->iri();
    }

    public function testFailure(): void
    {
        $data = [
            'content' => [
                '@id' => 'd79736bf-6984-4f22-91b6-fb8f11b902b3',
                'title' => 'Test',
            ],
        ];

        $this->expectException(\InvalidArgumentException::class);
        EntityAssertion::build($data)->field('content')->iri();
    }
}
