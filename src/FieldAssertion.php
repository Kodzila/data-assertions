<?php

declare(strict_types=1);

namespace Kodzila\DataAssertions;

use Webmozart\Assert\Assert;

final class FieldAssertion
{
    private string $fieldName;

    /**
     * @var mixed
     */
    private $fieldData;

    /**
     * @param mixed $fieldData
     */
    private function __construct(string $fieldName, $fieldData)
    {
        $this->fieldName = $fieldName;
        $this->fieldData = $fieldData;
    }

    /**
     * @param mixed $fieldData
     */
    public static function build(string $fieldName, $fieldData): self
    {
        return new self($fieldName, $fieldData);
    }

    public function iri(): void
    {
        Assert::string($this->fieldData, sprintf(
            'Field %s is not an iri',
            $this->fieldName,
        ));
    }

    public function entity(): EntityAssertion
    {
        try {
            return EntityAssertion::build($this->fieldData);
        } catch (\InvalidArgumentException $exception) {
            throw new \InvalidArgumentException(sprintf(
                'Field %s is not an entity',
                $this->fieldName,
            ));
        }
    }

    public function entityCollection(): EntityCollectionAssertion
    {
        try {
            return EntityCollectionAssertion::build($this->fieldData);
        } catch (\InvalidArgumentException $exception) {
            throw new \InvalidArgumentException(sprintf(
                'Field %s is not an entity collection. Issue: %s',
                $this->fieldName,
                $exception->getMessage(),
            ));
        }
    }

    public function iriCollection(): void
    {
        Assert::isArray($this->fieldData, sprintf(
            'Field %s is not an iri collection. Issue: %s',
            $this->fieldName,
            'is not an array',
        ));
        Assert::allString($this->fieldData, sprintf(
            'Field %s is not an iri collection. Issue: %s',
            $this->fieldName,
            'is not all strings',
        ));
    }

    public function string(): void
    {
        Assert::string($this->fieldData, sprintf(
            'Field %s is not a string',
            $this->fieldName,
        ));
    }

    public function nullableString(): void
    {
        Assert::nullOrString($this->fieldData, sprintf(
            'Field %s is not a nullable string',
            $this->fieldName,
        ));
    }

    public function int(): void
    {
        Assert::integer($this->fieldData, sprintf(
            'Field %s is not an integer',
            $this->fieldName,
        ));
    }

    public function nullableInt(): void
    {
        Assert::nullOrInteger($this->fieldData, sprintf(
            'Field %s is not an nullable integer',
            $this->fieldName,
        ));
    }

    public function bool(): void
    {
        Assert::boolean($this->fieldData, sprintf(
            'Field %s is not a boolean',
            $this->fieldName,
        ));
    }

    public function nullableBool(): void
    {
        Assert::nullOrBoolean($this->fieldData, sprintf(
            'Field %s is not a nullable boolean',
            $this->fieldName,
        ));
    }
}
