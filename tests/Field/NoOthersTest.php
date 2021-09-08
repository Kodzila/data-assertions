<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions\Tests\Field;

use Kodzila\DataAssertions\EntityAssertion;
use PHPUnit\Framework\TestCase;

final class NoOthersTest extends TestCase
{
    public function testSuccess(): void
    {
        $data = [
            'field1' => 'aaa',
            'field2' => 'bbb',
        ];

        $this->expectNotToPerformAssertions();
        $assertion = EntityAssertion::build($data);
        $assertion->field('field1');
        $assertion->field('field2');
        $assertion->noOthers();
    }

    public function testLess(): void
    {
        $data = [
            'field1' => 'aaa',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $assertion = EntityAssertion::build($data);
        $assertion->field('field1');
        $assertion->field('field2');
        $assertion->noOthers();
    }

    public function testMore(): void
    {
        $data = [
            'field1' => 'aaa',
            'field2' => 'bbb',
            'field3' => 'ccc',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $assertion = EntityAssertion::build($data);
        $assertion->field('field1');
        $assertion->field('field2');
        $assertion->noOthers();
    }

    public function testMoreDouble(): void
    {
        $data = [
            'field1' => 'aaa',
            'field2' => 'bbb',
            'field3' => 'ccc',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $assertion = EntityAssertion::build($data);
        $assertion->field('field1');
        $assertion->field('field2');
        $assertion->field('field2');
        $assertion->noOthers();
    }
}
