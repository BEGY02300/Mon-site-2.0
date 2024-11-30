<?php
include 'db.php';

$userId = $_POST['userId'];
$newUsername = $_POST['newUsername'];
$newAvatar = $_FILES['newAvatar'];

// Vérifier si le nouveau pseudo est déjà utilisé
if (!empty($newUsername)) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND id != ?");
    $stmt->execute([$newUsername, $userId]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Pseudo déjà utilisé.']);
        exit;
    }
}

// Gérer le téléchargement de la nouvelle image
if (!empty($newAvatar['name'])) {
    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($newAvatar['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Vérifier les types de fichiers autorisés
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        echo json_encode(['success' => false, 'message' => 'Format de fichier non autorisé.']);
        exit;
    }

    // Déplacer le fichier vers le dossier "uploads"
    if (!move_uploaded_file($newAvatar['tmp_name'], $targetFile)) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors du téléchargement de l\'image.']);
        exit;
    }
    
    $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
    $stmt->execute([$targetFile, $userId]);
}

// Mettre à jour le pseudo
if (!empty($newUsername)) {
    $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
    $stmt->execute([$newUsername, $userId]);
}

echo json_encode(['success' => true, 'message' => 'Mise à jour réussie !']);
?>
