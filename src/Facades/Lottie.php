<?php

namespace Pys\Lottie\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method  string prefix()
 * @method  \Illuminate\Contracts\Filesystem\Filesystem fs()
 * @method  array paths()
 * @method  void registerComponents()
 * @method  void registerComponent()
 * @method  string render(array $data)
 *
 * @see \Pys\Lottie\LottieManager
 */
class Lottie extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lottie';
    }
}
