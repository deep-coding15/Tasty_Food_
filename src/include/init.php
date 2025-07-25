<?php

require_once __DIR__ . '/SecureSession.php'; // ou le bon chemin

$_session = new SecureSession(); // la session démarre ici de façon sécurisée

if (!$_session->has('utilisateur')) {
    // Si l'utilisateur n'est pas connecté, on initialise une session vide
    $_session->set('utilisateur', [
        'id'         => null,
        'nom'        => null,
        'prenom'     => null,
        'login'      => null,
        'email'      => null,
        'is_active'  => false,
        'img_profil' => null,
        'telephone'  => null,
        'role'       => 'visiteur',
    ]);
    //echo 'session utilisateur';
    //var_dump($_session->get('utilisateur')); // pour déboguer, à retirer en production
    $_utilisateur = $_session->get('utilisateur');
} else {
    // Si l'utilisateur est connecté, on peut récupérer ses informations
    $_utilisateur = $_session->get('utilisateur');
}
//var_dump($_utilisateur); // pour déboguer, à retirer en production
$_session->set('MESSAGE', null); // Initialisation d'un message de confirmation ou d'echec de session vide