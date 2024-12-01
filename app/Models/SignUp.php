<?php

namespace App\Models;

use App\Model;

class SignUp extends Model
{
    public function __construct(protected Transaction $transactionModel)
    {
        parent::__construct();
    }

    public function register(array $array): void
    {
        try {
            $this->db->beginTransaction();
            $this->transactionModel->create($array);

            $this->db->commit();
        } catch (\Throwable $e) {
            if ($this->db->inTransaction()) {
                echo $e->getMessage();
                $this->db->rollBack();
            }
        }
    }
}
