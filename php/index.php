<?php

$host = 'db'; //Nom donné dans le docker-compose.yml
$user = 'YOUR_SQL_USER';
$password = 'YOUR_SQL_USER_PSW';
$dbname = 'YOUR_DATE_BASE_NAME';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
$pdo->exec("CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);");

try {
    $nom = 'halabina';
    $email = 'halabina@gmail.com';

    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email) VALUES (:nom, :email)");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    echo "User inserted successfully.";
} catch(PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM utilisateurs");
$stmt->execute();
$utilisateurs = $stmt->fetchAll();


echo "<table>";
echo "<tr><th>ID</th><th>Nom</th><th>Email</th></tr>";
foreach ($utilisateurs as $utilisateur) {
    echo "<tr>";
    echo "<td>" . $utilisateur['id'] . "</td>";
    echo "<td>" . $utilisateur['nom'] . "</td>";
    echo "<td>" . $utilisateur['email'] . "</td>";
    echo "</tr>";
}
echo "</table>";


// foreach ($utilisateurs as $utilisateur) {
//     $to = $utilisateur['email'];
//     $subject = "Nouvelle offre spéciale !";
//     $message = "Cher " . $utilisateur['nom'] . ",\n\nNous avons une nouvelle offre spéciale pour vous !\n\nCordialement,\nL'équipe de notre site Web";
//     $headers = "From: notre-site-web@example.com\r\n";
//     mail($to, $subject, $message, $headers);
// }

?>