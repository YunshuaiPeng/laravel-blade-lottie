<?php

namespace Pys\Lottie;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\ComponentAttributeBag;
use Pys\Lottie\Facades\Lottie;

class ComponentRenderer implements Htmlable
{
    /**
     * The component name.
     *
     * @var string
     */
    public string $name;

    /**
     * The component attribute bag.
     *
     * @var ComponentAttributeBag
     */
    public ComponentAttributeBag $attributeBag;

    public function __construct(string $name, ComponentAttributeBag $attributeBag)
    {
        $this->name = $name;
        $this->attributeBag = $attributeBag;
    }

    /**
     * Create a component renderer instance.
     *
     * @param mixed ...$arguments
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Get the component name without prefix.
     *
     * @return string
     */
    public function nameWithoutPrefix(): string
    {
        return str_replace(
            Lottie::prefix() . '-',
            '',
            $this->name
        );
    }

    /**
     * Get the lottie file path.
     *
     * @param string $name
     * @return string
     */
    public function path(): string
    {
        $paths = array_filter(Lottie::paths(), function ($path) {
            return basename($path, '.json') === $this->nameWithoutPrefix();
        });

        return array_pop($paths);
    }

    /**
     * Get the raw content of lottie file.
     *
     * @return mixed
     */
    public function content()
    {
        return Lottie::fs()->get($this->path());
    }

    /**
     * Get the full url of the lottie file.
     *
     * @return mixed
     */
    public function url()
    {
        return Lottie::fs()->url($this->path());
    }

    /**
     * Get the base animation config.
     *
     * @return array
     */
    public function baseAnimationConfig(): array
    {
        return [
            'container' => '$el',

            'renderer' => config('lottie.option.renderer'),

            'loop' => $this->attributeBag->get('loop') ?? config('lottie.option.loop'),

            'autoplay' => $this->attributeBag->get('loop') ?? config('lottie.option.autoplay'),
        ];
    }

    /**
     * Build animation config with url.
     *
     * @return array
     */
    public function animationConfigWithUrl(): array
    {
        return array_merge(
            $this->baseAnimationConfig(),
            [
                'path' => $this->url(),
            ]
        );
    }

    /**
     * Build animation config with raw content.
     *
     * @return array
     */
    public function animationConfigWithContent(): array
    {
        return array_merge(
            $this->baseAnimationConfig(),
            [
                'animationData' => json_decode($this->content()),
            ]
        );
    }

    /**
     * Get the animation config.
     *
     * @return string
     */
    public function animationConfig(): string
    {
        if ($this->isDataFromUrl()) {
            $config = json_encode($this->animationConfigWithUrl());
        }

        if ($this->isDataFromContent()) {
            $config = json_encode($this->animationConfigWithContent());
        }

        return str_replace("\"\$el\"", "\$el", $config);
    }

    /**
     * Determine if the data source from the url.
     *
     * @return bool
     */
    public function isDataFromUrl(): bool
    {
        return config('lottie.option.data_source') === 'url';
    }

    /**
     * Determine if the data source from the content.
     *
     * @return bool
     */
    public function isDataFromContent(): bool
    {
        return config('lottie.option.data_source') === 'content';
    }

    /**
     * Get the attributes HTML.
     *
     * @return string
     */
    public function renderedAttributes(): string
    {
        return $this->attributeBag->class(config('lottie.class'))->toHtml();
    }

    /**
     * Get the component Html.
     *
     * @return string
     */
    public function toHtml(): string
    {
        return "<div x-data='{ animation: null }' x-init='() => { animation = lottie.loadAnimation({$this->animationConfig()}); }' {$this->renderedAttributes()}></div>";
    }
}
