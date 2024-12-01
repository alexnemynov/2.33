<?php

namespace App\Controllers;

use App\Exceptions\FileNotExistException;
use App\Exceptions\TransactionsNotExistException;
use App\Models\SignUp;
use App\Models\Transaction;
use App\ReadCSV;
use App\View;

class TransactionController
{
    public function index(): View
    {
        return View::make('transactions/index');
    }

    /**
     * @throws TransactionsNotExistException
     */
    public function upload(): void
    {
        if (empty($_FILES["transaction_files"])) {
            throw new TransactionsNotExistException('Transaction have not sent');
        }

        foreach ($_FILES["transaction_files"]["name"] as $key => $value) {
            if (! str_ends_with($value, ".csv")) {
                throw new TransactionsNotExistException('Transaction is in invalid format');
            }
            move_uploaded_file(
                $_FILES["transaction_files"]["tmp_name"][$key],
                STORAGE_PATH . '/' . $_FILES["transaction_files"]["name"][$key]);
        }

        header('Location: /transactions/table');
        exit(); // чтобы убедиться, что код не выполняется дальше
    }

    public function table(): View
    {
        $transactions = (new ReadCSV(STORAGE_PATH))->run();
        $transactionModel = new Transaction();
        (new SignUp($transactionModel))->register($transactions);

        return View::make(
            'transactions/transactions',
            ['transactions' => $transactionModel->find_all(), 'totals' => calculateTotals($transactions)]
        );
    }
}