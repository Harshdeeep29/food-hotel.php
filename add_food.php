<?php
include 'db.php';

$success = false;  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hotel_id = $_POST['hotel_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    $query = $pdo->prepare("INSERT INTO food (hotel_id, name, price) VALUES (:hotel_id, :name, :price)");
    $query->execute(['hotel_id' => $hotel_id, 'name' => $name, 'price' => $price]);

    $success = true;  
}

 
$hotels = $pdo->query("SELECT * FROM hotel")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Food</title>
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
        .form-container {
            background-color: #ffffff;
            border: 1px solid #40916c;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #40916c;
            border-color: #40916c;
        }
        .btn-primary:hover {
            background-color: #2d6a4f;
            border-color: #2d6a4f;
        }
        .form-label {
            color: #2d6a4f;
            font-weight: bold;
        }
        .form-control, .form-select {
            border: 1px solid #40916c;
        }
    </style>
    <script>
         
        document.addEventListener('DOMContentLoaded', function () {
            <?php if ($success): ?>
                new bootstrap.Modal(document.getElementById('successModal')).show();
            <?php endif; ?>
        });
    </script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Add New Food Item</h1>
        <div class="form-container mx-auto" style="max-width: 600px;">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="hotel_id" class="form-label">Hotel</label>
                    <select name="hotel_id" id="hotel_id" class="form-select" required>
                        <option value="" disabled selected>Select a Hotel</option>
                        <?php foreach ($hotels as $hotel): ?>
                            <option value="<?= $hotel['id'] ?>"><?= htmlspecialchars($hotel['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Food Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        placeholder="Enter food name" 
                        required
                    >
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input 
                        type="number" 
                        step="0.01" 
                        name="price" 
                        id="price" 
                        class="form-control" 
                        placeholder="Enter price" 
                        required
                    >
                </div>
                <button type="submit" class="btn btn-primary w-100">Add Food</button>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Food item <strong><?= htmlspecialchars($name ?? '') ?></strong> has been successfully added!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
