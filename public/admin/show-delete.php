<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\TVShow;

try {
    if(isset($_GET['showId']) && ctype_digit($_GET['showId'])) {
        $showId = (int)$_GET['showId'];
        $show = TVShow::findById($showId);
        $show->delete();
        header('Location: ../index.php');
        exit();
    } else {
        throw new ParameterException("Problème avec l'identifiant de  l'artiste");
    }
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}