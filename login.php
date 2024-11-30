<?php
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Rechercher l'utilisateur par email
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    echo json_encode([
        'success' => true,
        'message' => 'Connexion réussie !',
        'username' => $user['username'],
        'avatar' => $user['avatar']
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Identifiants invalides.']);
}
?>
