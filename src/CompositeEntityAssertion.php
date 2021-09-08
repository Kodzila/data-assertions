<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions;

interface CompositeEntityAssertion
{
    public function validate(EntityAssertion $entityAssertion): void;
}
