<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions;

use Webmozart\Assert\Assert;

final class EntityAssertion
{
    /**
     * @param array<string, mixed>
     */
    private array $entityData;

    /**
     * @var string[]
     */
    private array $assertedFields = [];

    private function __construct(array $entityData)
    {
        $data = [];

        foreach ($entityData as $key => $value) {
            Assert::string($key);
            $data[$key] = $value;
        }

        $this->entityData = $data;
    }

    /**
     * @param mixed $data
     */
    public static function build($data): self
    {
        Assert::isArray($data);

        return new self($data);
    }

    public function field(string $name): FieldAssertion
    {
        Assert::keyExists($this->entityData, $name, sprintf(
            'Field %s does not exist. Only: %s',
            $name,
            implode(', ', array_keys($this->entityData)),
        ));

        $res = FieldAssertion::build($name, $this->entityData[$name]);

        $this->assertedFields[] = $name;

        return $res;
    }

    public function noField(string $name): void
    {
        Assert::keyNotExists($this->entityData, $name, sprintf(
            'Field %s exist but it was not supposed to. All fields: %s',
            $name,
            implode(', ', array_keys($this->entityData)),
        ));
    }

    public function noOthers(): void
    {
        $allFields = array_keys($this->entityData);
        $assertedFields = array_unique($this->assertedFields);

        $notAsserted = [];

        foreach ($allFields as $fieldName) {
            foreach ($assertedFields as $assertedFieldName) {
                if ($fieldName === $assertedFieldName) {
                    continue 2;
                }
            }

            $notAsserted[] = $fieldName;
        }

        if (count($notAsserted) === 0) {
            return;
        }

        throw new \InvalidArgumentException(sprintf(
            'Entity has some other fields that asserted: %s',
            implode(', ', $notAsserted),
        ));
    }

    /**
     * Expose a way to encapsulate some assertions in an extensible way.
     */
    public function assertComposite(CompositeEntityAssertion $compositeEntityAssertion): void
    {
        $compositeEntityAssertion->validate($this);
    }
}
