<?php

namespace App\Services;


abstract class BaseService
{
    private array $result;
    private array $keys;

    public function parseRequest(array $request, array $needle): array
    {
        foreach ($request as $key => $value) {
            if (is_array($value)) {
                $this->keys[] = $key;
                $request[$key] = $this->parseRequest($value, $needle);
            } else {
                if (in_array($key, $needle)) {
                    if (!empty($this->keys)) {
                        $this->result[last($this->keys)][$key] = $value;
                    } else {
                        $this->result[$key] = $value;
                    }
                }
            }
        }

        return $this->result;
    }

    protected function getQueryClausesFromRequest(array $needle, array $params): array
    {
        $clauses = [];
        foreach ($params as $key => $value) {
            if (in_array($key, $needle) && $value != null) {
                $clauses[] = [$key, '=', $value];
            }
        }
        return $clauses;
    }

}
