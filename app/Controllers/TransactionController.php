<?php

namespace App\Controllers;

use App\View;

class TransactionController
{
    public function index(): View
    {
        return View::make('transactions/index');
    }

    public function upload(): void
    {
        $filePath = STORAGE_PATH . '/' . $_FILES["receipt"]["name"][0];

        move_uploaded_file($_FILES["receipt"]["tmp_name"][0], $filePath);

        header('Location: /transactions/table');
        exit(); // чтобы убедиться, что код не выполняется дальше
    }

    public function table(): View
    {
        return View::make('transactions/transactions');
    }
}