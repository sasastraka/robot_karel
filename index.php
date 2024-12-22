<?php
session_start();

// Inicializace herního pole
if (!isset($_SESSION['grid'])) {
    $_SESSION['grid'] = array_fill(0, 5, array_fill(0, 5, ' '));  // 5x5 mřížka
    $_SESSION['x'] = 0;  // Počáteční pozice Karla (x)
    $_SESSION['y'] = 0;  // Počáteční pozice Karla (y)
    $_SESSION['direction'] = 0; // Směr Karla: 0 - nahoru, 1 - vpravo, 2 - dolů, 3 - vlevo
}

// Funkce pro zobrazení herního pole
function render_grid() {
    $grid = $_SESSION['grid'];
    $x = $_SESSION['x'];
    $y = $_SESSION['y'];
    
    // Na pozici Karla vložíme žlutý čtverec
    $grid[$y][$x] = 'K';  // Zobrazíme Karla na aktuální pozici
    $output = '<table>';
    foreach ($grid as $row) {
        $output .= '<tr>';
        foreach ($row as $cell) {
            // Pokud je Karel v dané buňce, použijeme speciální třídu
            if ($cell === 'K') {
                $output .= "<td class='karel'>$cell</td>";
            } else {
                $output .= "<td class='cell'>$cell</td>";
            }
        }
        $output .= '</tr>';
    }
    $output .= '</table>';
    return $output;
}

// Funkce pro posun robota
function move_robot($steps) {
    $x = $_SESSION['x'];
    $y = $_SESSION['y'];
    $direction = $_SESSION['direction'];

    for ($i = 0; $i < $steps; $i++) {
        if ($direction == 0) $y--;  // Nahoru
        if ($direction == 1) $x++;  // Vpravo
        if ($direction == 2) $y++;  // Dolů
        if ($direction == 3) $x--;  // Vlevo

        // Ověření, že Karel nepřeskočil hranice mřížky
        $x = max(0, min(4, $x));
        $y = max(0, min(4, $y));
    }

    $_SESSION['x'] = $x;
    $_SESSION['y'] = $y;
}

// Funkce pro otočení Karla
function turn_left($times) {
    $direction = $_SESSION['direction'];
    $_SESSION['direction'] = ($direction - $times + 4) % 4; // Otočení vlevo
}

// Funkce pro položení písmena na pozici
function place_letter($letter) {
    $x = $_SESSION['x'];
    $y = $_SESSION['y'];
    $_SESSION['grid'][$y][$x] = strtoupper($letter);
}

// Funkce pro resetování hry
function reset_game() {
    // Vyčistíme celé herní pole
    $_SESSION['grid'] = array_fill(0, 5, array_fill(0, 5, ' '));  // 5x5 mřížka
    $_SESSION['x'] = 0;  // Reset pozice Karla
    $_SESSION['y'] = 0;
    $_SESSION['direction'] = 0;  // Reset směru
}

// Zpracování příkazů
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['command'])) {
        $command = strtoupper(trim($_POST['command']));
        $params = explode(' ', $command);

        switch ($params[0]) {
            case 'KROK':
                $steps = isset($params[1]) ? (int)$params[1] : 1;
                move_robot($steps);  // Posun Karla
                break;
            case 'VLEVOBOK':
                $times = isset($params[1]) ? (int)$params[1] : 1;
                turn_left($times);  // Otočení vlevo
                break;
            case 'POLOZ':
                if (isset($params[1])) {
                    place_letter($params[1]);  // Pokládání písmena
                }
                break;
            case 'RESET':
                reset_game();  // Resetování pole a pozice Karla
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robot Karel</title>

    <!-- Link na Google Fonts pro moderní fonty -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Link na externí CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Robot Karel</h1>
    <div id="grid-container">
        <?php echo render_grid(); ?>  <!-- Zobrazení aktuálního herního pole -->
    </div>

    <form method="POST">
        <input type="text" name="command" placeholder="Zadejte příkaz" required>
        <button type="submit">Proveď příkaz</button>
    </form>

    <br>
    <form method="POST">
        <button type="submit" name="command" value="RESET">Resetuj hru</button>
    </form>

    <p><strong>Směr Karla:</strong> 
    <?php
        $direction = $_SESSION['direction'];
        switch ($direction) {
            case 0: echo "Nahoru"; break;
            case 1: echo "Vpravo"; break;
            case 2: echo "Dolů"; break;
            case 3: echo "Vlevo"; break;
        }
    ?>
    </p>
</body>
</html>

