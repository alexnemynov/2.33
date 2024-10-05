<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\FileNotExistException;

class ReadCSV
{
    public function __construct(private string $dirPath)
    {
    }

    public function run(): array
    {
        $files = static::getTransactionFiles($this->dirPath);
        $transactions = [];
        foreach ($files as $file) {
            $transactions = array_merge($transactions, static::getTransactions($file));
        }

        return $transactions;
//        $totals = calculateTotals($transactions);
    }

    private static function getTransactionFiles(string $dirPath): array
    {
        $files = [];

        foreach (scandir($dirPath) as $file) {
            if (is_dir($file)) {
                continue;
            } else {
                $files[] = $dirPath . DIRECTORY_SEPARATOR . $file;
            }
        }
        return $files;
    }

    /**
     * @throws FileNotExistException
     */
    private static function getTransactions(string $fileName, ?callable $transactionHandler = null): array
    {
        if (! file_exists($fileName)) {
            throw new FileNotExistException("File does not exist: $fileName");
        }

        $file = fopen($fileName, 'r');
        $transactions = [];

        fgetcsv($file);
        while (($transaction = fgetcsv($file)) !== false) {
            if ($transactionHandler !== null) {
                $transactions[] = $transactionHandler($transaction);
            }
            $transactions[] = static::parseTransaction($transaction);
        }
        fclose($file);
        return $transactions;
    }

    private static function parseTransaction(array $transactionRow): array
    {
        [$date, $checkNumber, $description, $amount] = $transactionRow;
        $amount = (float) str_replace(['$', ','], '', $amount);
        return [
            'date' => $date,
            'checkNumber' => $checkNumber,
            'description' => $description,
            'amount' => $amount,
        ];
    }
}