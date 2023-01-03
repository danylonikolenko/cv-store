<?php


namespace App\Dto\Permission;


class PermissionDto implements \JsonSerializable
{

    private string $class_name;
    private string $function_name;
    private string $route;
    private ?string $description;
    private bool $deleted;
    private ?int $id;

    public function __construct(
        ?int    $id,
        string  $route,
        string  $class_name,
        string  $function_name,
        ?string $description = null,
        bool    $deleted = false)
    {
        $this->id = $id;
        $this->route = $route;
        $this->class_name = $class_name;
        $this->function_name = $function_name;
        $this->description = $description;
        $this->deleted = $deleted;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->class_name;
    }

    /**
     * @return string
     */
    public function getFunctionName(): string
    {
        return $this->function_name;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return string|null
     */
    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
