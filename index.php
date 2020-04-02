<?php

use App\Controller\OrderController;

require __DIR__.'/config/bootstrap.php';

// Notre controller qui a besoin de tous ces services
$controller = $container->get(OrderController::class);

// Notre controller qui a besoin de tous ces services
//$controller = new OrderController($database, $mailer, $smsTexter, $logger,$dispatcher);

// Si le formulaire a été soumis
if (!empty($_POST)) {
    // On demande au controller de gérer la commande
    $controller->handleOrder();
    // Et on arrête là.
    return;
}

// Sinon, on affiche simplement le formulaire
$controller->displayOrderForm();
