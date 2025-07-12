<!DOCTYPE html>
<html>
<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }
        
        table th, table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .amount {
            text-align: right;
        }
        
        .income {
            color: green;
        }
        
        .expense {
            color: red;
        }
        
        .summary {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Check #</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($transactions)): ?>
                <?php foreach($transactions as $transaction): ?>
                    <tr>
                        <td><?= $transaction['date'] ?></td>
                        <td><?= $transaction['check'] ?></td>
                        <td><?= $transaction['description'] ?></td>
                        <td class="amount <?= $transaction['amount'] >= 0 ? 'income' : 'expense' ?>">
                            $<?= number_format(abs($transaction['amount']), 2) ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>

    <div class="summary">
        <p>Total Income: $<?= number_format($totals['income'], 2) ?></p>
        <p>Total Expense: $<?= number_format($totals['expense'], 2) ?></p>
        <p>Net Total: $<?= number_format($totals['net'], 2) ?></p>
    </div>
</body>
</html> 