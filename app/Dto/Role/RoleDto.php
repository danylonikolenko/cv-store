<?php


namespace App\Dto\Role;


class RoleDto implements \JsonSerializable
{

    private ?int $id;
    private string $name;
    private ?string $description;
    private bool $deleted;
    private array $permissions;

    public function __construct(
        ?int    $id,
        string  $name,
        array   $permission_ids,
        ?string $description,
        bool    $deleted = false)
    {
        $this->name = $name;
        $this->permissions = $permission_ids;
        $this->description = $description;
        $this->deleted = $deleted;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): string|null
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function getDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function getPermissionsIds(): array
    {
        return array_keys($this->permissions);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}
