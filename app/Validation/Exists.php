<?php

namespace App\Validation;

use CodeIgniter\Database\BaseConnection;

class Exists
{
    protected BaseConnection $db;

    public function __construct()
    {
        // Load the database connection
        $this->db = \Config\Database::connect();
    }

    /**
     * Checks if a value exists in a specified table and column.
     *
     * @param string $value The value to check.
     * @param string $field The parameter string in the format 'table,column'.
     * @param array $data Other data (not used).
     * @return bool
     */
    public function exists(string $value, string $field, array $data): bool
    {
        // Split the parameter to get the table and column
        [$table, $column] = explode(',', $field);

        // Query the database to check if the value exists
        return $this->db->table($table)->where($column, $value)->countAllResults() > 0;
    }
}