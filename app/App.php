<?php

declare(strict_types = 1);

class App {
    private $transactions = [];
    private $transactionFile = __DIR__ . '/../transaction_files/transactions.csv';

    public function __construct() {
        if (!file_exists($this->transactionFile)) {
            $this->createSampleTransactions();
        }
    }

    private function createSampleTransactions() {
        if (!is_dir(dirname($this->transactionFile))) {
            mkdir(dirname($this->transactionFile), 0777, true);
        }

        $sampleData = [
            ['date', 'description', 'amount'],
            ['2024-03-15', 'Заработная плата за март 📈', '150000'],
            ['2024-03-16', 'Покупка продуктов в "Перекрёсток" 🛒', '-7500'],
            ['2024-03-16', 'Оплата ЖКХ (квартира) 🏠', '-8500'],
            ['2024-03-17', 'Дивиденды от инвестиций Сбер 💰', '25000'],
            ['2024-03-18', 'Ресторан "Пушкин" с семьей 🍽️', '-12500'],
            ['2024-03-19', 'Яндекс.Такси (работа-дом) 🚕', '-800'],
            ['2024-03-20', 'Премия за успешный проект ⭐', '50000'],
            ['2024-03-20', 'Оплата фитнес-клуба (годовой) 🏃‍♂️', '-45000'],
            ['2024-03-21', 'Возврат налогового вычета 📑', '13000'],
            ['2024-03-21', 'Покупка техники М.Видео 🛍️', '-89999']
        ];

        $fp = fopen($this->transactionFile, 'w');
        foreach ($sampleData as $row) {
            fputcsv($fp, $row, ',', '"', '\\');
        }
        fclose($fp);
    }

    public function processTransactions() {
        if (($handle = fopen($this->transactionFile, "r")) !== false) {
            // Skip the header row
            fgetcsv($handle, 1000, ',', '"', '\\');
            
            while (($data = fgetcsv($handle, 1000, ',', '"', '\\')) !== false) {
                $this->transactions[] = [
                    'date' => $data[0],
                    'description' => $data[1],
                    'amount' => (float) $data[2]
                ];
            }
            fclose($handle);
        }

        return $this->transactions;
    }

    public function calculateTotals() {
        $totals = [
            'income' => 0,
            'expenses' => 0,
            'net' => 0
        ];

        foreach ($this->transactions as $transaction) {
            if ($transaction['amount'] >= 0) {
                $totals['income'] += $transaction['amount'];
            } else {
                $totals['expenses'] += abs($transaction['amount']);
            }
        }

        $totals['net'] = $totals['income'] - $totals['expenses'];

        return $totals;
    }
} 