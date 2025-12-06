<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

// Connect to database
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get request values
$country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);
$lookup  = filter_input(INPUT_GET, 'lookup', FILTER_SANITIZE_STRING);

if ($lookup === 'cities') {
    if (empty($country)) {
        echo "<p>Please enter a country to look up its cities.</p>";
        exit;
    }

    $stmt = $conn->prepare(
        "SELECT cities.name, cities.district, cities.population
         FROM cities
         JOIN countries ON cities.country_code = countries.code
         WHERE countries.name LIKE :country"
    );
    $stmt->execute([':country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$results) {
        echo "<p>No cities were found for that country.</p>";
        exit;
    }
    ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>District</th>
                <th>Population</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['district']); ?></td>
                    <td><?= htmlspecialchars($row['population']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    exit;
}

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
