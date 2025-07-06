<?php
require_once('src/models/plats.php');

function homepage()
{
    $platRepository = new PlatRepository();
    $plats = $platRepository->getPlats();

    require('templates/homepage.php');
}