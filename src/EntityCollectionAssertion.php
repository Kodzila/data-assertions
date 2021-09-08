<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions;

use Webmozart\Assert\Assert;

final class EntityCollectionAssertion
{
    private array $entityCollectionData;

    private function __construct(array $entityCollectionData)
    {
        $this->entityCollectionData = $entityCollectionData;
        // Validate we can build entities
        $this->assertions();
    }

    /**
     * @param mixed $data
     */
    public static function build($data): self
    {
        Assert::isArray($data);

        return new self($data);
    }

    /**
     * @param callable(EntityAssertion):void $entityAssertion
     */
    public function each(callable $entityAssertion): void
    {
        foreach ($this->assertions() as $entity) {
            $entityAssertion($entity);
        }
    }

    /**
     * @return EntityAssertion[]
     */
    private function assertions(): array
    {
        return array_map(
            fn ($entityData): EntityAssertion => EntityAssertion::build($entityData),
            $this->entityCollectionData,
        );
    }
}
