<?php
// Connect to the database
$pdo = new PDO('mysql:host=localhost;dbname=url_shortener', 'root', '');

// Function to generate a unique short code
function generateShortCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $shortCode = '';
    for ($i = 0; $i < $length; $i++) {
        $shortCode .= $characters[rand(0, $charactersLength - 1)];
    }
    return $shortCode;
}

// Check if a URL has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['url'])) {
    $originalUrl = $_POST['url'];
    $shortCode = generateShortCode();

    // Insert into the database
    $stmt = $pdo->prepare("INSERT INTO links (original_url, short_code) VALUES (?, ?)");
    $stmt->execute([$originalUrl, $shortCode]);

    $shortUrl = "http://localhost/shorten.php?code=" . $shortCode;

    echo "Short URL: <a href='$shortUrl' target='_blank'>$shortUrl</a>";
}
?>

<!-- Simple HTML form to submit a URL -->
<form method="POST" action="">
    <label for="url">Enter URL to shorten:</label>
    <input type="text" name="url" id="url" required>
    <input type="submit" value="Shorten URL">
</form>
