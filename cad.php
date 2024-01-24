<?php 



$pokemonNome = $_GET["pokemonNome"];
$cacheStats = "$pokemonNome.txt";



if(!file_exists($cacheStats)){
    $pokemonStats = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/$pokemonNome", true));
} else {
    $pokemonStats = json_decode(file_get_contents($cacheStats));
}


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>STATS</title>
</head>
<body>

    <h1>Estatísticas de <?=ucfirst($pokemonNome)?>:</h1>
    
    <h2>
        <ul>
            <?php
        
                $arrayStats = $pokemonStats->stats;
                foreach ($arrayStats as $stats) {
                    echo "<li>" . ucfirst($stats->stat->name) . ": $stats->base_stat</li>";
                }
                
                file_put_contents($cacheStats, var_export($arrayStats, true));
            ?>
        </ul>
    </h2>

</body>
</html>