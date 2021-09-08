<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions\Tests;

use Kodzila\DataAssertions\EntityAssertion;
use Kodzila\DataAssertions\EntityCollectionAssertion;
use PHPUnit\Framework\TestCase;

final class EntityCollectionTest extends TestCase
{
    public function testCollectionOfNoEntities(): void
    {
        $data = [0, 1, 2];
        $this->expectException(\InvalidArgumentException::class);
        EntityCollectionAssertion::build($data);
    }

    public function testIriIntegrationSuccess(): void
    {
        $data = [
            [
                'content' => '/api/projects/d79736bf-6984-4f22-91b6-fb8f11b902b3',
            ],
            [
                'content' => '/api/projects/d79736bf-6984-4f22-91b6-fb8f11b902b3',
            ],
        ];

        $this->expectNotToPerformAssertions();
        EntityCollectionAssertion::build($data)->each(function (EntityAssertion $assertion) {
            $assertion->field('content')->iri();
        });
    }

    public function testIriIntegrationFailure(): void
    {
        $data = [
            [
                'content' => '/api/projects/d79736bf-6984-4f22-91b6-fb8f11b902b3',
            ],
            [
                'content' => [
                    '@id' => '/api/projects/d79736bf-6984-4f22-91b6-fb8f11b902b3',
                    'title' => 'Test',
                ],
            ],
        ];

        $this->expectException(\InvalidArgumentException::class);
        EntityCollectionAssertion::build($data)->each(function (EntityAssertion $assertion) {
            $assertion->field('content')->iri();
        });
    }
}
