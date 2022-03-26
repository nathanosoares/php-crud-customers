<?php

namespace Nathan\Kabum\Core\Database;

class QueryResult
{
    public function __construct(public array $row = [], public array $rows = [], public int $num_rows = 0)
    {
    }
}
