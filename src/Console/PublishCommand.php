<?php

namespace Pys\Lottie\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    protected $signature = 'lottie:publish';

    protected $description = 'Publish Lottie configuration and asset';

    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'lottie-config',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'lottie-asset',
            '--force' => true,
        ]);
    }
}
