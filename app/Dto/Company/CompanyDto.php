<?php


namespace App\Dto\Company;


class CompanyDto implements \JsonSerializable
{
    private ?int $id;
    private string $name;
    private string $description;
    private bool $deleted;

    public function __construct(?int $id, string $name, string $description, bool $deleted)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->deleted = $deleted;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

