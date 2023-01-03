<?php


namespace App\Dto\Response;


class ResponseDto
{

    private bool $status;

    private mixed $result;

    private int $statusCode;

    private mixed $description;

    private array $additionalParams;

    public function __construct(bool $status, $result, mixed $description = '', $statusCode = 200, array $additionalParams = [])
    {
        $this->status = $status;
        $this->statusCode = $statusCode;
        $this->description = $description;
        $this->result = $result;
        $this->additionalParams = $additionalParams;
    }

    /**
     * @return array
     */
    public function getAdditionalParams(): array
    {
        return $this->additionalParams;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return array|string|object
     */
    public function getResult(): array|string|object
    {
        return $this->result;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getDescription(): mixed
    {
        return $this->description;
    }


}
