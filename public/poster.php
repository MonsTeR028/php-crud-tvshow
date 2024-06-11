<?php

declare(strict_types=1);

use Entity\Poster;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;

try {
    if(empty($_GET['posterId']) || !is_numeric($_GET['posterId'])) {
        throw new ParameterException("Paramètre invalide");
    }
    $poster = Poster::findById((int) $_GET['posterId']);
    header('Content-Type: image/jpeg');
    echo $poster->getJpeg();

} catch (ParameterException|EntityNotFoundException) {
    header('Content-Type: image/jpeg');
    readfile("img/default.png");
} catch (Exception) {
    http_response_code(500);
}
