<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\ExistsInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Eloquent\UpdateOrCreateInterface;
use App\Contracts\Interfaces\Eloquent\WhereInterface;

interface NewsPhotoInterface extends GetInterface, StoreInterface, UpdateInterface, ShowInterface, DeleteInterface, WhereInterface, ExistsInterface, UpdateOrCreateInterface
{

}
