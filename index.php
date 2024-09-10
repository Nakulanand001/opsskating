<?php
require_once 'include/SimpleXLSX.php';

$file_path = 'include/main.xlsx';

if ($xlsx = SimpleXLSX::parse($file_path)) {
    $rows = $xlsx->rows();

    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $event = isset($_GET['event']) ? $_GET['event'] : '';

    $filtered_players = [];
    foreach ($rows as $row) {
        $age_group = $row[19]; // Assuming age group is in column T (index 19)
        $game_name = $row[16]; // Assuming game name is in column Q (index 16)
        $game_type = $row[17]; // Assuming game type is in column R (index 17)

        $combined_event = $game_name . ' - ' . $game_type;

        if (($category === '' || $age_group === $category) &&
            ($event === '' || $combined_event === $event)) {
            $filtered_players[] = $row;
        }
    }
} else {
    echo SimpleXLSX::parseError();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Tournament - Player List</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Available Players</h1>
        <form id="filter-form">
            <select name="category" id="category">
                <option value="">Select Age Group</option>
                <option value="Under 17">Under 17</option>
                <option value="Under 14">Under 14</option>
            </select>

            <select name="event" id="event">
                <option value="">Select Event</option>
                <option value="Skating - 1000 MTRS In-Line">Skating - 1000 MTRS In-Line</option>
                <option value="Skating - 500 MTRS In-Line">Skating - 500 MTRS In-Line</option>
            </select>

            <button type="submit">Filter</button>
        </form>

        <table>
            <tr>
                <th>Player ID</th>
                <th>Name</th>
                <th>School</th>
                <th>Class</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Game</th>
                <th>Type</th>
                <th>Level</th>
                <th>Age Group</th>
                <th>Region</th>
            </tr>
            <?php foreach ($filtered_players as $player): ?>
            <tr>
                <td><?php echo htmlspecialchars($player[1]); ?></td> <!-- Player ID -->
                <td><?php echo htmlspecialchars($player[9]); ?></td> <!-- Student Name -->
                <td><?php echo htmlspecialchars($player[5]); ?></td> <!-- School Name -->
                <td><?php echo htmlspecialchars($player[11]); ?></td> <!-- Class -->
                <td><?php echo htmlspecialchars($player[12]); ?></td> <!-- DOB -->
                <td><?php echo htmlspecialchars($player[13]); ?></td> <!-- Gender -->
                <td><?php echo htmlspecialchars($player[16]); ?></td> <!-- Game Name -->
                <td><?php echo htmlspecialchars($player[17]); ?></td> <!-- Game Type -->
                <td><?php echo htmlspecialchars($player[18]); ?></td> <!-- Game Level -->
                <td><?php echo htmlspecialchars($player[19]); ?></td> <!-- Age Group -->
                <td><?php echo htmlspecialchars($player[20]); ?></td> <!-- Region -->
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
