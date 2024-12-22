<?php
session_start();

if (!isset($_SESSION['grid'])) {
    $_SESSION['grid'] = array_fill(0, 5, array_fill(0, 5, ' '));  
    $_SESSION['x'] = 0;  
    $_SESSION['y'] = 0; 
    $_SESSION['direction'] = 0; 
}

function render_grid() {
    $grid = $_SESSION['grid'];
    $x = $_SESSION['x'];
    $y = $_SESSION['y'];
    
    $grid[$y][$x] = 'K';  
    $output = '<table>';
    foreach ($grid as $row) {
        $output .= '<tr>';
        foreach ($row as $cell) {
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

function move_robot($steps) {
    $x = $_SESSION['x'];
    $y = $_SESSION['y'];
    $direction = $_SESSION['direction'];

    for ($i = 0; $i < $steps; $i++) {
        if ($direction == 0) $y--;  
        if ($direction == 1) $x++;  
        if ($direction == 2) $y++;  
        if ($direction == 3) $x--;  

        $x = max(0, min(4, $x));
        $y = max(0, min(4, $y));
    }

    $_SESSION['x'] = $x;
    $_SESSION['y'] = $y;
}

function turn_left($times) {
    $direction = $_SESSION['direction'];
    $_SESSION['direction'] = ($direction - $times + 4) % 4; 
}

function place_letter($letter) {
    $x = $_SESSION['x'];
    $y = $_SESSION['y'];
    $_SESSION['grid'][$y][$x] = strtoupper($letter);
}

function reset_game() {
    $_SESSION['grid'] = array_fill(0, 5, array_fill(0, 5, ' '));  
    $_SESSION['x'] = 0;  
    $_SESSION['y'] = 0;
    $_SESSION['direction'] = 0;  
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['command'])) {
        $command = strtoupper(trim($_POST['command']));
        $params = explode(' ', $command);

        switch ($params[0]) {
            case 'KROK':
                $steps = isset($params[1]) ? (int)$params[1] : 1;
                move_robot($steps);  
                break;
            case 'VLEVOBOK':
                $times = isset($params[1]) ? (int)$params[1] : 1;
                turn_left($times);  
                break;
            case 'POLOZ':
                if (isset($params[1])) {
                    place_letter($params[1]);  
                }
                break;
            case 'RESET':
                reset_game();  
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

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Robot Karel</h1>
    <div id="grid-container">
        <?php echo render_grid(); ?>  
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

