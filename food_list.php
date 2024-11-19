<?php
include 'db.php';

$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'id';

$query = $pdo->prepare("
    SELECT food.id, food.name, food.price, hotel.name AS hotel_name 
    FROM food 
    JOIN hotel ON food.hotel_id = hotel.id 
    WHERE food.name LIKE :search 
    ORDER BY $sort ASC
");
$query->execute(['search' => "%$search%"]);
$foods = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Food Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0fff4;  
            font-family: 'Arial', sans-serif;
        }
        h1 {
            color: #2d6a4f;
            font-weight: bold;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-primary {
            background-color: #40916c;
            border-color: #40916c;
        }
        .btn-primary:hover {
            background-color: #2d6a4f;
            border-color: #2d6a4f;
        }
        .form-select, .form-control {
            border: 1px solid #2d6a4f;
        }
    </style>
</head>
<body>
    <div class="container mt-5 p-4 rounded" style="background-color: #ffffff; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
        <h1 class="text-center mb-4">Food Listing</h1>

        <!-- Search Form -->
        <form method="GET" action="" class="mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-md-8">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search food items" 
                        value="<?= htmlspecialchars($search) ?>"
                    >
                </div>
                <div class="col-md-2">
                    <select name="sort" class="form-select">
                        <option value="id" <?= $sort == 'id' ? 'selected' : '' ?>>Default</option>
                        <option value="name" <?= $sort == 'name' ? 'selected' : '' ?>>Name</option>
                        <option value="price" <?= $sort == 'price' ? 'selected' : '' ?>>Price</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>

        <!-- Food Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Hotel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($foods) > 0): ?>
                        <?php foreach ($foods as $food): ?>
                        <tr>
                            <td><?= $food['id'] ?></td>
                            <td><?= htmlspecialchars($food['name']) ?></td>
                            <td>$<?= number_format($food['price'], 2) ?></td>
                            <td><?= htmlspecialchars($food['hotel_name']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-muted">No food items found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
