<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Учёт транзакций</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1d21;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #e1e1e1;
        }
        .transaction-card {
            background: #2d3035;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.2);
            margin-bottom: 20px;
            transition: all 0.3s ease;
            color: #e1e1e1;
        }
        .transaction-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }
        .income {
            border-left: 5px solid #00b894;
        }
        .expense {
            border-left: 5px solid #ff7675;
        }
        .amount {
            font-size: 1.2em;
            font-weight: bold;
        }
        .total-card {
            background: #2d3035;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.2);
        }
        .total-card h4 {
            color: #a0a0a0;
            font-size: 1.1em;
            margin-bottom: 10px;
        }
        .text-success {
            color: #00b894 !important;
        }
        .text-danger {
            color: #ff7675 !important;
        }
        .text-muted {
            color: #878787 !important;
        }
        .description {
            color: #e1e1e1;
        }
        h1 {
            color: #e1e1e1;
            margin-bottom: 1.5rem;
            font-weight: 300;
        }
        .date {
            font-size: 0.9em;
        }
        /* Добавляем красивое свечение для карточек при наведении */
        .transaction-card:hover.income {
            box-shadow: 0 5px 20px rgba(0,184,148,0.2);
        }
        .transaction-card:hover.expense {
            box-shadow: 0 5px 20px rgba(255,118,117,0.2);
        }
    </style>
</head>
<body>
<?php
require_once __DIR__ . '/../app/App.php';

$app = new App();
$transactions = $app->processTransactions();
$totals = $app->calculateTotals();

function formatRubles($amount) {
    return number_format($amount, 2, ',', ' ') . ' ₽';
}
?>

<div class="container py-5">
    <h1 class="text-center mb-5">Учёт транзакций</h1>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="total-card">
                <h4>Общий доход</h4>
                <div class="amount text-success">
                    <?= formatRubles($totals['income']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="total-card">
                <h4>Общий расход</h4>
                <div class="amount text-danger">
                    <?= formatRubles($totals['expenses']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="total-card">
                <h4>Баланс</h4>
                <div class="amount <?= $totals['net'] >= 0 ? 'text-success' : 'text-danger' ?>">
                    <?= formatRubles($totals['net']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="transactions">
        <?php foreach ($transactions as $transaction): ?>
            <div class="transaction-card p-3 <?= $transaction['amount'] >= 0 ? 'income' : 'expense' ?>">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="date text-muted">
                            <?= date('d.m.Y', strtotime($transaction['date'])) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="description">
                            <?= htmlspecialchars($transaction['description']) ?>
                        </div>
                    </div>
                    <div class="col-md-3 text-end">
                        <div class="amount <?= $transaction['amount'] >= 0 ? 'text-success' : 'text-danger' ?>">
                            <?= formatRubles($transaction['amount']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 