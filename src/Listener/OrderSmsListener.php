<?php


namespace App\Listener;


use App\Event\OrderEvent;
use App\Logger;
use App\Texter\Sms;
use App\Texter\SmsTexter;

class OrderSmsListener
{
    protected $texter;
    protected $logger;

    public function __construct(SmsTexter $texter, Logger $logger)
    {
        $this->texter = $texter;
        $this->logger = $logger;
    }

    public function sendSmsToCustomer(OrderEvent $event)
    {
        $order = $event->getOrder();
        // Après enregistrement on veut aussi envoyer un SMS au client
        // voir src/Texter/Sms.php et /src/Texter/SmsTexter.php
        $sms = new Sms();
        $sms->setNumber($order->getPhoneNumber())
            ->setText("Merci pour votre commande de {$order->getQuantity()} {$order->getProduct()} !");
        $this->texter->send($sms);

        // Après SMS au client, on veut logger ce qui se passe :
        // voir src/Logger.php
        $this->logger->log("SMS de confirmation envoyé à {$order->getPhoneNumber()} !");
    }

    public function sendSmsToStock(OrderEvent $event)
    {

        $order = $event->getOrder();

        // Avant d'enregistrer, on veut envoyer un email à l'administrateur :
        // voir src/Mailer/Email.php et src/Mailer/Mailer.php
        $sms = new Sms();
        $sms->setNumber($order->getPhoneNumber())
            ->setText("Merci de vérifier le stock pour le produit {$order->getProduct()} et la quantité {$order->getQuantity()} !");
        $this->texter->send($sms);

        // Avant d'enregistrer, on veut logger ce qui se passe :
        // voir src/Logger.php
        $this->logger->log("SMS de confirmation envoyé à {$order->getPhoneNumber()} !");

    }
}