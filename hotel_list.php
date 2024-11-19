<?php
include 'db.php';

 $search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'id';

 $query = $pdo->prepare("SELECT * FROM hotel WHERE name LIKE :search ORDER BY $sort ASC");
$query->execute(['search' => "%$search%"]);
$hotels = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hotel Listing</title>
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
        <h1 class="text-center mb-4">Hotel Listing</h1>

        <!-- Search Form -->
        <form method="GET" action="" class="mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-md-8">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search hotels" 
                        value="<?= htmlspecialchars($search) ?>"
                    >
                </div>
                <div class="col-md-2">
                    <select name="sort" class="form-select">
                        <option value="id" <?= $sort == 'id' ? 'selected' : '' ?>>Default</option>
                        <option value="name" <?= $sort == 'name' ? 'selected' : '' ?>>Name</option>
                        <option value="location" <?= $sort == 'location' ? 'selected' : '' ?>>Location</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>

        <!-- Hotel Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($hotels) > 0): ?>
                        <?php foreach ($hotels as $hotel): ?>
                        <tr>
                            <td><?= $hotel['id'] ?></td>
                            <td><?= htmlspecialchars($hotel['name']) ?></td>
                            <td><?= htmlspecialchars($hotel['location']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-muted">No hotels found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
