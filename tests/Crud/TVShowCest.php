<?php

namespace Crud;

use Entity\Exception\EntityNotFoundException;
use Entity\TVShow;
use Support\CrudTester;

class TVShowCest
{
    public function findById(CrudTester $I)
    {
        $
    }

    public function findByIdThrowsExceptionIfTVShowDoesNotExist(CrudTester $I)
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            TVShow::findById(PHP_INT_MAX);
        });
    }


}
