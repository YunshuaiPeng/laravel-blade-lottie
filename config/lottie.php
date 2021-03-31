<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Disk
    |--------------------------------------------------------------------------
    |
    | This value is used to identify which disk you use to store your lottie files.
    |
    */

    'disk' => 'public',

    /*
    |--------------------------------------------------------------------------
    | Root Path
    |--------------------------------------------------------------------------
    |
    | The root path on which lottie files stored.
    |
    */

    'root' => 'lottiefiles',

    /*
    |--------------------------------------------------------------------------
    | Laravel Blade Component Prefix
    |--------------------------------------------------------------------------
    |
    | Your can custom the prefix any string you want. As long as on the prefix
    | matches the component name. For example "<x-atom/>", "<x-lottie-atom/>"
    | or "<x-yourPrefix-atom/>"
    |
    */

    'prefix' => 'lottie',

    /*
    |--------------------------------------------------------------------------
    | Default Class
    |--------------------------------------------------------------------------
    |
    | The custom class will be append to lottie container as it is.
    |
    */

    'class' => 'h-16 w-16',

    /*
    |--------------------------------------------------------------------------
    | Lottie Option
    |--------------------------------------------------------------------------
    |
    | Based on lottie official document.
    | See https://github.com/airbnb/lottie-web/blob/4195af343b46dcc431a0beebe2d7ad80ddf6c7cb/index.d.ts#L79
    |
    */

    'option' => [

        /*
         * Supported Renderer: "svg", "canvas", "html"
         */
        'renderer' => 'svg',

        /*
         * Loop Play
         */
        'loop' => false,

        /*
         * Autoplay
         */
        'autoplay' => true,

        /*
         * Data Source. Supported: "url", "content"
         */
        'data_source' => 'url',
    ],

];
