<?php

namespace Pys\Lottie;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Pys\Lottie\Components\LottieComponent;

class LottieManager
{
    /**
     * Get the blade component prefix.
     *
     * @return string
     */
    public function prefix(): string
    {
        return config('lottie.prefix');
    }

    /**
     * Get the file system.
     *
     * @return Filesystem
     */
    public function fs(): Filesystem
    {
        return Storage::disk(config('lottie.disk'));
    }

    /**
     * Get all lottie file paths relative to the root path.
     *
     * @return array
     */
    public function paths(): array
    {
        return $this->fs()->files(config('lottie.root'));
    }

    /**
     * Register all components.
     */
    public function registerComponents(): void
    {
        foreach ($this->paths() as $path) {
            $this->registerComponent(basename($path, '.json'));
        }
    }

    /**
     * Register component with the given name.
     *
     * @param string $name
     */
    public function registerComponent(string $name): void
    {
        Blade::component($name, LottieComponent::class, $this->prefix());
    }

    /**
     * Rendering HTML.
     *
     * @param array $data
     * @return string
     */
    public function render(array $data): string
    {
        return ComponentRenderer::make($data['componentName'], $data['attributes'])->toHtml();
    }
}
