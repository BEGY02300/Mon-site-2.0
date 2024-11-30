<?php
include 'db.php';

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$username = $_POST['username'];
$avatar = 'uploads/default-avatar.png'; // Avatar par défaut

// Vérifier si le pseudo ou l'email existe déjà
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
$stmt->execute([$email, $username]);
if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => false, 'message' => 'Email ou pseudo déjà utilisé.']);
    exit;
}

// Insérer un nouvel utilisateur
$stmt = $pdo->prepare("INSERT INTO users (email, password, username, avatar) VALUES (?, ?, ?, ?)");
$stmt->execute([$email, $password, $username, $avatar]);

echo json_encode(['success' => true, 'message' => 'Inscription réussie !']);
?>
