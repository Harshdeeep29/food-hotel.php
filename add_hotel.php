<?php
include 'db.php';

$success = false;  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];

    $query = $pdo->prepare("INSERT INTO hotel (name, location) VALUES (:name, :location)");
    $query->execute(['name' => $name, 'location' => $location]);

    $success = true;  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Hotel</title>
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
        .form-control {
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
        <h1 class="text-center mb-4">Add New Hotel</h1>
        <div class="form-container mx-auto" style="max-width: 600px;">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="name" class="form-label">Hotel Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        placeholder="Enter hotel name" 
                        required
                    >
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input 
                        type="text" 
                        name="location" 
                        id="location" 
                        class="form-control" 
                        placeholder="Enter location" 
                        required
                    >
                </div>
                <button type="submit" class="btn btn-primary w-100">Add Hotel</button>
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
                    Hotel <strong><?= htmlspecialchars($name ?? '') ?></strong> at location <strong><?= htmlspecialchars($location ?? '') ?></strong> has been successfully added!
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
