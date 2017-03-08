<?php
/**
 * Configuration loader
 * Also documents the configuration file
 */
$rawConfig = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'config.json');
$uncommentedConfig = preg_replace("#// .+$#", '', $rawConfig);
$config = json_decode($uncommentedConfig, true);
$filter = array_flip(array(
    "Title",
    "Url",          // adresse url se terminant par un "/"
    "FacebookImageUrl",
    "Description",
    "UrlRewriting", // passer à '0' si votre hébergeur ne gère pas convenablement la réécriture d'url et que les liens entre les chapitres ne fonctionnent pas. Dans ce cas, remplacez le fichier .htaccess par "htaccess_pour_free-fr" si vous êtes hébergé chez Free.fr, ou essayez de supprimer ce fichier.
    "Preload",      // nombre d'images à précharger à partir de l'image courante
    "ShowTitle",    // remplacer par '0' pour n'afficher aucun titre
                    // remplacer par '2' pour afficher le titre de l'épisode sous la jauge de lecture
    "Support",      // remplacer par '0' pour supprimer l'écran de commentaires en fin d'épisode
                    // remplacer par '1' pour afficher les commentaires propres à chaque épisode en fin d'épisode
                    // remplacer par '2' pour afficher les commentaires propres à chaque épisode sous l'épisode
    "ShowUpdt",     // remplacer par '1' pour que les fichiers mise à jour au sein d'un épisode soient mis en valeur sur la jauge
    "Credits",
    "ImageWidth",
    "ImageHeight",
    "BgColor",      // couleur de fond
    // Code RVB de la couleur 1
    "C1R",
    "C1V",
    "C1B",
    // Code RVB de la couleur 2
    "C2R",
    "C2V",
    "C2B",
    "HlColor", // Couleur de surbrillance
    "Lang", // langue par défaut, remplacer par 'en' pour publier en anglais
    "Languages", // langues disponibles
    "IDGoogleAnalytics",
));

$filteredConfig = array_intersect_key($config, $filter);
extract($filteredConfig);
unset($filteredConfig);
unset($_config);
