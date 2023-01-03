<?php


namespace App\Dto;


class UserDto implements \JsonSerializable
{
    private string $name;

    private ?int $role_id;

    private bool $deleted;

    private int $id;

    public function __construct(int $id, string $name, int $role_id = null, bool $deleted = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->role_id = $role_id;
        $this->deleted = $deleted;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function getDeleted(): bool
    {
        return $this->deleted;
    }


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getRoleId(): ?int
    {
        return $this->role_id;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }


}
