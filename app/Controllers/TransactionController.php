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
        foreach ($_FILES["transaction_files"]["name"] as $key => $value) {
            if (! str_ends_with($value, ".csv")) {
                throw new TransactionsNotExistException('Transaction have not sent or is in invalid format');
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
        if (! (new SignUp($transactionModel))->register($transactions)) {
            http_response_code(404);

            echo View::make('error/404');
        };

        return View::make(
            'transactions/transactions',
            ['transactions' => $transactionModel->find_all(), 'totals' => calculateTotals($transactions)]
        );
    }
}