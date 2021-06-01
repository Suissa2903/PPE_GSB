<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$mois = getMois(date('d/m/Y'));

$moisPrecedent=getMoisPrecedent($mois);
$pdo->clotureFiche($moisPrecedent);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);// recupere le contenu de action
switch ($action) {
case 'selectionnerVetM':
     
   $lesVisiteurs=$pdo->getVisiteurss();
   
   $lesClesVisiteurs = array_keys($lesVisiteurs);//tableau de clés
   $visiteurASelectionner = $lesClesVisiteurs[0];
   $lesMois=$pdo->getMoisValide();
   $lesClesMois = array_keys($lesMois);//tableau de clés
   $moisASelectionner = $lesClesMois[0];
   include  'vues/v_listeVisiteur.php';
break;


case'afficheFrais':
    case 'afficherFrais':    
   
    
   
  
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois=$pdo-> getMoisValide();
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    echo $idVisiteur;
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);


    
    $lesVisiteurs= $pdo->getVisiteurss();
    $visiteurASelectionner= $idVisiteur;
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    $moisASelectionner =$leMois;
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
    
     include  'vues/v_suivifiche.php';
    
break;
case 'miseEnPaiement':
    echo "vdtete";
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    $lesVisiteurs=$pdo->getVisiteurss();
    $visiteurASelectionner=$idVisiteur;  
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);//on recupere ce qui a ete selectionné ds la liste deroulante de nummois(qui se trouve dans v_listemois).
    $lesMois = $pdo->getMoisValide();
    $moisASelectionner = $leMois;
    $etat="RB";
    $pdo->majEtatFicheFrais($idvisiteur, $mois, $etat);
    
    
    ?>
    <div class="alert alert-info" role="alert">
        <p>La fiche a bien été remboursée! <a href="index.php">Cliquez ici</a>
            pour revenir à la page d'accueil.</p>
    </div>
    <?php
    
break;
}


