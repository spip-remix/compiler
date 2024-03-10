<?php

/**
* @param int nb_seconde
* calcule le nombre de minutes et de secondes à partir d'un entier
* retourne la durée au format 00:00
*
* [(#DUREE|min_sec)]
*
* @author Touti <touti@free.fr>
*/
function filtre_min_sec($nb_seconde){
    $nb_minute = floor($nb_seconde / 60);

    if( $nb_minute < 1 ){
        return '00:'.$nb_seconde;
    }

    elseif( $nb_minute >= 1 ){
        $nb_seconde = ( $nb_seconde - ( $nb_minute * 60 ) );
        return $nb_minute.':'.$nb_seconde;
    }
}

/**
 * [(#DUREE|min_sec|marqueur_des_jours)]
 * [(#DUREE|min_sec|marqueur_des_jours{j})]
 */
function marqueur_des_jours($duree, $marqueur = 'd')
{
    return str_replace(' ', $marqueur . ' ', $duree);
}

/**
 * [(#BALISE|avec_parametres{un})]
 * [(#BALISE|avec_parametres{un,deux})]
 */
function avec_parametres($duree, $parametre1, $parametre2 = null)
{
    return $duree.$parametre1.$parametre2;
}
