<?php
include 'db.php';

$username = $_POST['username'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['available' => false, 'message' => 'Pseudo non disponible.']);
} else {
    echo json_encode(['available' => true, 'message' => 'Pseudo disponible.']);
}
?>
