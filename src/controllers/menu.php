<?php
require_once(__DIR__ . '/../models/plats.php');

function menu()
{
    $platRepository = new PlatRepository();
    $plats = $platRepository->getPlats();

    require('templates/menu.php');
}

function seePlat(int $id){
    
}