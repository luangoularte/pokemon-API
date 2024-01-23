<?php 

$cachePokemon = "pokemons.txt";

$pagina = $_GET["pagina"] ?? null;

$limite = 15;

$inicio = ($pagina * $limite) - $limite;

$pokemonNome = isset($_GET["pokemonNome"]);

$url = "https://pokeapi.co/api/v2/pokemon?limit=150&offset=$inicio";
$pokemons = json_decode(file_get_contents($url));





?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Pokemons</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <h1>Lista Pokemons:</h1>
    <h2>
        
        <ol start=<?=$inicio+1?>>
            <?php  
            
            $array1 = $pokemons->results;
            
            $array1 = array_slice($array1, $inicio, $limite);
    
            foreach($array1 as $dados){
                $nome = ucfirst($dados->name);
                    echo "
                        <li><a href=\"?pokemonNome=$nome/stat\">$nome</a></li>
                    \n";
                }

            
            //if para verificar se array1 ja esta contido em cachePokemon   
            file_put_contents($cachePokemon, var_export($array1, true), FILE_APPEND);


            //endpoint stats

            $pokemonStats = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/$pokemonNome"));
            
            if ($pokemonStats) {
                echo "<h3>Estatísticas de $pokemonNome:</h3>";
                echo "<ul>";
                
                $arrayStats = $pokemonStats->stats;

                foreach ($arrayStats as $stats) {
                    echo "<li>{$stats->stat->name}: {$stats->base_stat}</li>";
                }
                echo "</ul>";
            
            }
            ?>
        </ol>
    </h2>
    
    
    <div class="paginacao">
        
    
        <a href="?pagina=1">Início</a>

        <?php if($pagina>1): ?>
            <a href="?pagina=<?=$pagina-1?>"><<</a>
        <?php endif ?>

        <?=$pagina?>

        <?php if($pagina<10): ?>
            <a href="?pagina=<?=$pagina+1?>">>></a>
        <?php endif ?>

        <a href="?pagina=10">Fim</a>

        

    </div>

</body>
</html>