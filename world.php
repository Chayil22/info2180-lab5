<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

// Connect to database
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get search term if provided
$country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);

// Query with or without filter
if (!empty($country)) {
    $stmt = $conn->prepare(
        "SELECT name, continent, independence_year, head_of_state 
         FROM countries 
         WHERE name LIKE :country"
    );
    $stmt->execute([':country' => "%$country%"]);
} else {
    $stmt = $conn->query(
        "SELECT name, continent, independence_year, head_of_state 
         FROM countries"
    );
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
    <thead>
        <tr>
            <th>Country</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['continent']); ?></td>
                <td><?= htmlspecialchars($row['independence_year']); ?></td>
                <td><?= htmlspecialchars($row['head_of_state']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
