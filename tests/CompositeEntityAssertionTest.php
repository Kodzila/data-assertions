<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions\Tests;

use Kodzila\DataAssertions\CompositeEntityAssertion;
use Kodzila\DataAssertions\EntityAssertion;
use PHPUnit\Framework\TestCase;

final class CompositeEntityAssertionTest extends TestCase
{
    /**
     * Test scenario: we want to encapsulate a rule that an entity should have a createdAt and author fields.
     */
    public function test(): void
    {
        $redactorAssertion = new class implements CompositeEntityAssertion {

            public function validate(EntityAssertion $entityAssertion): void
            {
                $entityAssertion->field('author')->iri();
                $entityAssertion->field('createdAt')->string();
            }
        };

        $goodData = [
            'title' => 'Nice content',
            'author' => '/api/people/d79736bf-6984-4f22-91b6-fb8f11b902b3',
            'createdAt' => '2020-09-14T11:49:00+02:00',
        ];

        EntityAssertion::build($goodData)->assertComposite($redactorAssertion);

        $missingData = [
            'title' => 'Wrong content',
            'createdAt' => '2020-09-14T11:49:00+02:00',
        ];

        $this->expectException(\InvalidArgumentException::class);
        EntityAssertion::build($missingData)->assertComposite($redactorAssertion);
    }

}
