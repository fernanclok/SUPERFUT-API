<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 1);
if (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
    $a = $_GET['busqueda'];
  
    
    function traducirPalabra($a) {
        $diccionario = file_get_contents("diccionario.txt"); 

        $lineas = explode("\n", $diccionario); 

        foreach ($lineas as $linea) {
            $datos = explode("-", $linea); 

            if (trim(strtolower($datos[0])) == trim(strtolower($a))) { 
                return utf8_decode(trim($datos[1])); 
            }
        }
        return $a; 
    }

    $palabra = traducirPalabra($a);
} else {
    header('Location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>superFUT</title>
    <link rel="stylesheet" href="css/equipos2.css">
</head>
<body>
    <nav class="menu">
        <ul>
            <a href="index.php" class="boton">inicio</a>
        </ul> 
    </nav>
<form method="GET" name="filtroEquipo">
   <label name="filtro">Filtro por equipo</label>   
   <select name="equipos">
    <option selected value disabled>Seleccione</option>
    <option value="">Todo</option>
    <?php
    
        //$bus = $_GET['busqueda'];
        $arch =file_get_contents("https://www.thesportsdb.com/api/v1/json/3/search_all_teams.php?s=Soccer&c=".$palabra."");
        $data2=json_decode($arch,true);
            if(isset($data2['teams'])) {
                $items = $data2['teams'];
                foreach($items as $item) {
                    $idTeam = isset($item['idTeam']) ? $item['idTeam'] :'';
                    $strTeam = isset($item['strTeam']) ? $item['strTeam'] : '';
                    echo '<option value="'.$idTeam.'">'.$strTeam.'</option>';
                }
            }
    ?>
    <input type="submit" value="enviar"/>
   </select>
   <select name="busqueda">
    <?php
        echo '<option value="'.$palabra.'">'.$palabra.'</option>';
    ?>
   </select>
  </form>
  <nav class="general">
<?php

//$bus = $_GET['busqueda'];
$equi=$_GET['equipo'];

$archivo=file_get_contents("https://www.thesportsdb.com/api/v1/json/3/search_all_teams.php?s=Soccer&c=".$palabra."");
$data3=json_decode($archivo,true);
    if(!empty($equi)) {
    $items = $data3['teams'];
    foreach( $items as $item3) {
        if($equi == $item3['idTeam']) {
    $idTeam2 = isset($item['idTeam']) ? $item['idTeam'] :'';
    $strTeamBadge = isset($item3['strTeamBadge']) ? $item3['strTeamBadge'] : '';
    $strTeam = isset($item3['strTeam']) ? $item3['strTeam'] : '';
    $intFormedYear = isset($item3['intFormedYear']) ? $item3['intFormedYear'] : '';
    $strLeague = isset($item3['strLeague']) ? $item3['strLeague'] : '';
    $strStadium = isset($item3['strStadium']) ? $item3['strStadium'] : '';
    $trStadiumLocation = isset($item3['trStadiumLocation']) ? $item3['trStadiumLocation'] : '';
    $intStadiumCapacity = isset($item3['intStadiumCapacity']) ? $item3['intStadiumCapacity'] : '';
    $strWebsite = isset($item3['strWebsite']) ? $item3['strWebsite'] : '';
    
    echo '
    <div class="info">
        <ul class="informacion">
            <h1 class="equipo">'.$strTeam.'</h1>
        fundado: '.$intFormedYear.' <br>
        liga a la que pertenece: '.$strLeague.' <br>
        estadio: '.$strStadium.' <br>
        localicacion del estadio: '.$trStadiumLocation.' <br>
        capacidad del estadio: '.$intStadiumCapacity.' <br>
        sitio web: <a href=https://'.$strWebsite.' target="_blank">'.$strWebsite.'</a>
        </ul>
        <img class="bandera" src="'.$strTeamBadge.'">
    </div>
    ';
            }
        }
    } 

    else if(isset($data3['teams'])) {
        $items = $data3['teams'];
        foreach( $items as $item3) {
        $idTeam2 = isset($item['idTeam']) ? $item['idTeam'] :'';
        $strTeamBadge = isset($item3['strTeamBadge']) ? $item3['strTeamBadge'] : '';
        $strTeam = isset($item3['strTeam']) ? $item3['strTeam'] : '';
        $intFormedYear = isset($item3['intFormedYear']) ? $item3['intFormedYear'] : '';
        $strLeague = isset($item3['strLeague']) ? $item3['strLeague'] : '';
        $strStadium = isset($item3['strStadium']) ? $item3['strStadium'] : '';
        $trStadiumLocation = isset($item3['trStadiumLocation']) ? $item3['trStadiumLocation'] : '';
        $intStadiumCapacity = isset($item3['intStadiumCapacity']) ? $item3['intStadiumCapacity'] : '';
        $strWebsite = isset($item3['strWebsite']) ? $item3['strWebsite'] : '';
            
        echo '
              <div class="info">
            <ul class="informacion">
                <h1 class="equipo">'.$strTeam.'</h1>
            fundado: '.$intFormedYear.' <br>
            liga a la que pertenece: '.$strLeague.' <br>
            estadio: '.$strStadium.' <br>
            localicacion del estadio: '.$trStadiumLocation.' <br>
            capacidad del estadio: '.$intStadiumCapacity.' <br>
            sitio web: <a href="'.$strWebsite.'" target="_blank">'.$strWebsite.'</a>
            </ul>
            <img class="bandera" src="'.$strTeamBadge.'">
        </div>
        ';
            }
        }
?>
</nav>
</body>
</html>