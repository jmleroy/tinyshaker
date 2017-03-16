﻿<?php
/**
 * Default values (adapted from the file previously named config.txt)
 * DO NOT CHANGE THEM!
 * This file is possibly overriden when you update Tinyshaker
 * Instead override them by creating a config.json
 * (use config_example.json as model)
 *
 * Valeurs par défaut (adaptées du fichier nommé précédemment config.txt)
 * NE MODIFIEZ PAS CES VALEURS!
 * Ce fichier est susceptible d'être écrasé en cas de mise à jour de Tinyshaker
 * À la place, surchargez ces valeurs en créant un fichier config.json
 * (utilisez config_example.json comme modèle)
 */

$Title = "Tinyshaker - JavaScript Turbo Media by JiF";

//url address with a trailing slash
//adresse url se terminant par un "/"
$Url = "http://julien.falgas.fr/tinyshaker/";
$FacebookImageUrl = "http://julien.falgas.fr/tinyshaker/thumbnail.png";
$Description = "Script PHP/Javascript de publication en ligne de récit sous forme de diaporama.";

//set to '0' if your host does not manage url rewriting properly
//and if the links between chapters do not work. You may use
//"htaccess_example" to set up an .htaccess file at the root
//of your site to enable URL rewriting.
//
//passer à '0' si votre hébergeur ne gère pas convenablement
//la réécriture d'url et que les liens entre les chapitres
//ne fonctionnent pas. Vous pouvez créer un fichier .htaccess
//sur base de "htaccess_example" pour activer la réécriture d'URL.
$UrlRewriting = '1';

//number of pictures to preload starting from current picture
//nombre d'images à précharger à partir de l'image courante
$Preload = '5';

//'0' displays no title
//'1' displays the title
//'2' displays the episode title also under the reader navigation
//'0' pour n'afficher aucun titre
//'0' pour afficher le titre
//'2' pour afficher le titre de l'épisode sous la jauge de lecture
$ShowTitle = '1';

//app id for integration of facebook-driven comments
//must be specified to show comments
//
//identifiant facebook pour intégrer des commentaires via facebook
//doit être spécifié pour montrer les commentaires
$FacebookCommentsAppId = '';
//'0' to delete the comments screen at the end of the episode
//'1' to display comments of every episode at the end of the episode
//'2' to display comments of every episode under the episode
//'3' to display comments of every episode ---
//
//'0' pour supprimer l'écran de commentaires en fin d'épisode
//'1' pour afficher les commentaires propres à chaque épisode en fin d'épisode
//'2' pour afficher les commentaires propres à chaque épisode sous l'épisode
//'3' pour afficher les commentaires propres à chaque épisode ---
$Support = '3';

//'1' to highlight updated files inside an episode in the navigation bar
//'1' pour que les fichiers mise à jour au sein d'un épisode soient mis en valeur sur la jauge
$ShowUpdt = '0';

$Credits = 'By <a href="http://julien.falgas.fr">Julien Falgas</a>, inspired by <a href="http://www.scriptiny.com/">Michael Leigeber</a>\'s <a href="http://www.scriptiny.com/2010/09/fading-slideshow-script/">TinyFader</a><br/>Grenade design by <a href="http://www.fredboot.com">Fred Boot</a> Icons by <a href="http://paulrobertlloyd.com/">Paul Robert Lloyd</a>';

$ImageWidth = '800px';
$ImageHeight = '450px';

//background colour
//couleur de fond
$BgColor = '#353435';
//main colour
//couleur principale
$Color = '#454445';
//highlight colour
//couleur de surbrillance
$HlColor = '#55BBCC';

//default language
//langue par défaut
$Lang = "fr";

//available languages
//langues disponibles
$Languages = array(
    'fr',
    'en',
);

//language codes
//codes langues
$LanguageCodes = array(
    'fr' => 'fr_FR',
    'en' => 'en_US',
);

