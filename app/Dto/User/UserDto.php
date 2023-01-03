<?php


namespace App\Dto\User;


class UserDto implements \JsonSerializable
{

    private string $email;
    private ?int $role_id;
    private bool $deleted;
    private int $id;

    public function __construct(int $id, string $email, int $role_id = null, bool $deleted = false)
    {
        $this->id = $id;
        $this->email = $email;
        $this->role_id = $role_id;
        $this->deleted = $deleted;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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
