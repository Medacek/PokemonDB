<?php
// nastavení databáze
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pokemon1";

// připojení
$conn = new mysqli($servername, $username, $password, $dbname);

// kontrola připojení
if ($conn->connect_error) {
    die("connection failed :c" . $conn->connect_error);
}

// inicializace proměnných
$result = "";
if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
    // Prepare the statement for exact matches only
    $stmt = $conn->prepare("SELECT pokedex_number, title, imagepath FROM pikmin WHERE pokedex_number = ? OR title = ?");
    $stmt->bind_param("ss", $searchTerm, $searchTerm); // Bind the same search term for both conditions
    $stmt->execute();
    $result = $stmt->get_result();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon gen 1 database</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #2C3333;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        .list-group-item {
            background-color: transparent;
            border: none;
            color: white;
        }
        .search-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .cool-tlacitko {
            background-color: #395B64;
            color: white;
            border: none;
        }
        .logo {
            max-width: 300px;
            margin-top: 0px;
        }
        .main-title {
            font-size: 3rem;
            color: white;
            margin-top: 20px;
        }
        .title-text {
            color: #A5C9CA;
            font-size: 2rem;
            margin-top: 10px;
        }
        .title8 {
            color: whitesmoke;
            font-size: 1rem;
            margin-top: 10px;
        }
        .results-title {
        color: #E7F6F2;
        margin-top: 20px;
    }
        input[type="text"] {
            width: 300px;
            padding: 10px;
        }
        input[type="submit"] {
            padding: 10px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
<div class="container">
<h1 class="title-text">Welcome to the</h1>
<a href="index.php">
    <img src="img/logo.png" alt="Pokémon Logo" class="logo">
    </a>
    <h1 class="title-text">Gen 1 Database!</h1>
    <p class="title-text">Find your favorite Pokémon below!</p>

    <div class="search-form">
        <form method="POST" action="">
            <div class="form-group d-flex justify-content-center">
                <input type="text" name="search" class="form-control" placeholder="Search..." required style="width: 300px; margin-right: 10px;">
                <button type="submit" class="btn cool-tlacitko">Search</button>
            </div>
        </form>
    </div>
    <p class="title8">search Pokémon by their name or pokédex ID (e.g. Bulbasaur OR #001)</p>

    <?php if (isset($_POST['search'])): // Check if the search form was submitted ?>
    <?php if ($result && $result->num_rows > 0): ?>
        <h2 class="results-title">Results:</h2>
        <ul class="list-group">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <h3><?php echo htmlspecialchars($row['pokedex_number']) . ' ' . htmlspecialchars($row['title']); ?></h3>
                    <img src="<?php echo htmlspecialchars($row['imagepath']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="img-fluid">
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <h2>No results found.</h2> <!-- Message for no results -->
    <?php endif; ?>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>