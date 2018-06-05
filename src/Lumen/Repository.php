<?php

namespace Jarhen\Modules\Lumen;

use Jarhen\Modules\Json;
use Jarhen\Modules\Repository as BaseRepository;

class Repository extends BaseRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createModule(...$args)
    {
        return new Module(...$args);
    }
}
