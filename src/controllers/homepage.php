<?php
require_once(__DIR__ . '/../models/plats.php');

function homepage()
{
    $platRepository = new PlatRepository();
    $plats = $platRepository->getPlats();

    require('templates/homepage.php');
}

function seePlat(int $id){
    
}