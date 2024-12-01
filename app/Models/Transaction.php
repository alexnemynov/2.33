<?php

namespace App\Models;

use App\Model;

class Transaction extends Model
{

    public function create(array $transactions): void
    {
        foreach ($transactions as $transactionRow) {
            $date = date('Y-m-d', strtotime($transactionRow['date']));
            $checkNumber = empty($transactionRow['checkNumber'])? null : (int) $transactionRow['checkNumber'];
            $stmt = $this->db->prepare(
                "INSERT INTO transactions (date, checkNumber, description, amount) 
                   VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([$date, $checkNumber, $transactionRow['description'], $transactionRow['amount']]);
        }
    }

    public function find_all(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM transactions');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}