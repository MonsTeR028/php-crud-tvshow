<?php

declare(strict_types=1);

use Entity\Poster;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;

try {
    if(empty($_GET['posterId']) || !is_numeric($_GET['posterId'])) {
        http_response_code(400);
        exit();
    }
    $poster = Poster::findById((int) $_GET['posterId']);
    header('Content-Type: image/jpeg');
    echo $poster->getJpeg();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    header('Content-Type: image/jpeg');
    echo "img/default.png";
} catch (Exception) {
    http_response_code(500);
}
