<?php

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

require __DIR__.'/../vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__.'/../templates');


$twig = new Environment($loader, [
    'debug' => true,
    'strict_variables' => true,
]);

$twig->addExtension(new DebugExtension());

$formData = [
    'login' => '',
    'password' => '',
];

$errors = [];

if ($_POST) {
    foreach($formData as $key => $value) {
        if(isset($_POST[$key])) {
            $formData[$key]=$_POST[$key];
        }
    }


    $minLengthLogin = 3;
    $maxLengthLogin = 190;

    if (empty($_POST['login'])) {
        $errors['login'] = 'Merci de ne pas laisser ce champ vide';
    }  elseif (strlen($_POST['login']) < 3 || strlen($_POST['login']) > 190) {
        $errors['login'] = "Merci de renseigner un login dont la longueur est comprise entre {$minLengthLogin} et {$maxLengthLogin} caractères inclus";
    }

    $minLengthPass = 8;
    $maxLengthPass = 32;

    if (empty($_POST['password'])) {
        $errors['password'] = 'Merci de ne pas laisser ce champ vide';
    } elseif (strlen($_POST['password']) < 8 || strlen($_POST['password']) > 32) {
        $errors['password'] = "Merci de renseigner un mot de passe dont la longueur est comprise entre {$minLengthPass} et {$maxLengthPass} caractères inclus";
    } elseif (preg_match('/[^A-Za-z0-9]/', $_POST['password']) >= 1) {
        $errors['password'] = "Merci de renseigner un mot de passe avec minimum 1 caractère spécial";
    }

}

echo $twig->render('login.html.twig', [
    'errors' => $errors,
    'formData' => $formData,
]);