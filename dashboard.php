<?php
include 'db.php';

$hotel_count = $pdo->query("SELECT COUNT(*) AS count FROM hotel")->fetchColumn();
$food_count = $pdo->query("SELECT COUNT(*) AS count FROM food")->fetchColumn();

$monthly_data = $pdo->query("
    SELECT 
        MONTH(created_at) AS month, COUNT(*) AS count 
    FROM hotel 
    GROUP BY MONTH(created_at)
")->fetchAll(PDO::FETCH_ASSOC);

$months = [];
$counts = [];
foreach ($monthly_data as $data) {
    $months[] = date("F", mktime(0, 0, 0, $data['month'], 10)); 
    $counts[] = $data['count'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f0fff4;  
            font-family: 'Arial', sans-serif;
        }
        h1 {
            color: #2d6a4f;
            font-weight: bold;
        }
        .card {
            background-color: #ffffff;
            border: 1px solid #40916c;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .card h3 {
            color: #2d6a4f;
        }
        #chart-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5 p-4 rounded">
        <h1 class="text-center mb-4">Dashboard</h1>

        <!-- Counts -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card p-3">
                    <h3>Total Hotels</h3>
                    <p class="fs-1"><?= $hotel_count ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3">
                    <h3>Total Food Items</h3>
                    <p class="fs-1"><?= $food_count ?></p>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div id="chart-container">
            <canvas id="chart"></canvas>
        </div>
        <script>
            const ctx = document.getElementById('chart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($months) ?>,
                    datasets: [{
                        label: 'New Hotels Added',
                        data: <?= json_encode($counts) ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#2d6a4f'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#2d6a4f'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#2d6a4f'
                            }
                        }
                    }
                }
            });
        </script>
    </div>
</body>
</html>
