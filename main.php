<?php

function foo($ArrayOfIntervals) {
    //si le paramettres d'entré est invalide stoper ici et remonter une erreur.
    if(
        !isset($ArrayOfIntervals) || 
        empty($ArrayOfIntervals) || 
        count($ArrayOfIntervals) < 1 ) {
        return print_r("error: no valid parametters");
    }

    //si il n'y en a que 1 le renvoyer simplement
    if (count($ArrayOfIntervals) == 1) {
        return print_r($ArrayOfIntervals);
    }

    // Trier les valeur pour commencer par l'intervalle le plus bas. 
    // Pour ne pas ce prendre la tete quand il y auras de multiples intervalles.
    usort($ArrayOfIntervals, function($a, $b) {
        return $a[0] - $b[0];
    });
    // resultat [[1, 4], [3, 6], [3, 4], [3, 6], [6, 10], [15, 20], [16, 17]].

    //ici j'ajoute le premier intervalle.
    $listsOfInterval = [$ArrayOfIntervals[0]];
    //je sauvegarde l'index pour pouvoir l'agrandir quand on vas fusionner les intervalles suivant et ou en créer un nouveau.
    $IndexIntervals = 0;

    // maintenant je les parcourt 
    foreach($ArrayOfIntervals as $interval) {

        // comme le tableau est trier nous avons juste besoin de vérifier
        // que le premier point de l'intervalle sois inferieur ou egale
        // au dernier point de l'intervalle actuel.
        // exemple [1,4] [3,6] 3 est est inferieur a 4 donc on l'absorbe.
        
        $maxInteval = $listsOfInterval[$IndexIntervals][1];
        if($interval[0] <= $maxInteval) {
            //si le point final de l'intervalle est superieur a l'intervalle actuel on je remplace
            if($interval[1] >= $maxInteval) {
                $listsOfInterval[$IndexIntervals][1] = $interval[1];
            }
        }
        // un nouvel intervalle à ajouter.
        else {
            $listsOfInterval[] = $interval;
            $IndexIntervals++;
        }
    }

    return print_r($listsOfInterval);

}

echo "<br>test error :<br>";
foo([]);
echo "<br>test juste return parametters :<br>";
foo([[0, 7]]);
echo "<br>test 1 :<br>";
foo([[0, 3], [6, 10]]);
echo "<br>test 2 :<br>";
foo([[0, 5], [3, 10]]);
echo "<br>test 3 :<br>";
foo([[0, 5], [2, 4]]);
echo "<br>test 4 :<br>";
foo([[7, 8], [3, 6], [2, 4]]);
echo "<br>test 5 :<br>";
foo([[3, 6], [3, 4], [15, 20], [16, 17], [1, 4], [6, 10], [3, 6]]);
