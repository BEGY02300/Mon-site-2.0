<?php
// Fonction pour valider si l'image est appropriée via DeepAI
function validateImageWithDeepAI($imageFile) {
    // Remplace par ta clé API DeepAI
    $apiKey = "773c57e2-7f89-48c0-901a-b7acfc0d0633"; // Utilise ta propre clé ici

    // URL de l'API NSFW Detection de DeepAI
    $url = "https://api.deepai.org/api/nsfw-detector";

    // Initialisation de CURL
    $ch = curl_init();
    
    // Configuration des options CURL pour envoyer l'image
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Api-Key: $apiKey"
    ]);
    
    // Ajouter l'image dans la requête
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'image' => new CURLFile($imageFile)
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Exécution de la requête
    $response = curl_exec($ch);

    // Vérification des erreurs de CURL
    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    // Décodage de la réponse JSON
    $result = json_decode($response, true);

    // Vérifie si le score NSFW est au-dessus de 0.5, ce qui signifie que l'image est inappropriée
    if (isset($result['output']['nsfw_score'])) {
        $nsfwScore = $result['output']['nsfw_score'];
        
        // Si le score NSFW est supérieur à 0.5, l'image est considérée comme inappropriée
        if ($nsfwScore > 0.5) {
            return false; // L'image est inappropriée
        }
    }

    return true; // L'image est appropriée
}

// Exemple d'utilisation de la fonction avec une image téléchargée
$imagePath = 'chemin/vers/ton/image.jpg';  // Remplace ce chemin par celui de ton image

if (validateImageWithDeepAI($imagePath)) {
    echo "L'image est appropriée.";
} else {
    echo "L'image contient du contenu inapproprié.";
}
?>
