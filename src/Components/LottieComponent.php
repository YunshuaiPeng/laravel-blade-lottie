<?php

namespace Pys\Lottie\Components;

use Illuminate\View\Component;
use Pys\Lottie\Facades\Lottie;

class LottieComponent extends Component
{
    public function render()
    {
        return function (array $data) {
            return Lottie::render($data);
        };
    }
}
