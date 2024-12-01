<?php

declare(strict_types=1);

function formatDollarAMount(float $amount): string
{
    $isNegative = $amount < 0;

    return ($amount < 0 ? '-' : '') . '$' . number_format(abs($amount), 2);
}

function calculateTotals(array $transactions): array
{
    $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];

    foreach ($transactions as $transaction) {
        $totals['netTotal'] += $transaction['amount'];

        if ($transaction['amount'] >= 0) {
            $totals['totalIncome'] += $transaction['amount'];
        } else {
            $totals['totalExpense'] += $transaction['amount'];
        }
    }

    return $totals;
}