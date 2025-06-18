<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo 'Stripe key is: ' . $_ENV['STRIPE_SECRET_KEY'];
