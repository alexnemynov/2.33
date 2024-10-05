<?php

namespace App\Controllers;

use App\Models\Transaction;
use app\Models\User;
use App\View;

class TransactionController
{
    public function index(): View
    {
        return View::make('transactions/index');
    }

    public function upload(): void
    {
        foreach ($_FILES["transaction_files"]["name"] as $key => $value) {
            move_uploaded_file(
                $_FILES["transaction_files"]["tmp_name"][$key],
                STORAGE_PATH . '/' . $_FILES["transaction_files"]["name"][$key]);
        }

        header('Location: /transactions/table');
        exit(); // чтобы убедиться, что код не выполняется дальше
    }

    public function table(): View
    {


        $transactionModel = new Transaction();

        return View::make('transactions/transactions');
    }
}