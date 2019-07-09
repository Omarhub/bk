<?php

namespace Webkul\Theme;

use Illuminate\Support\Facades\Event;

class ViewRenderEventManager
{
    /**
     * Contains all themes
     *
     * @var array
     */
    protected $templates = [];

    /**
     * Paramters passed with event
     *
     * @var array
     */
    protected $params;

    /**
     * Fires event for rendering template
     *
     * @param string     $eventName
     * @param array|null $params
     * @return string
     */
    public function handleRenderEvent($eventName, $params = null)
    {
        $this->params = $params ?? [];

        Event::fire($eventName, $this);

        return $this->templates;
    }

    /**
     * Add templates for render
     *
     * @param string $template
     * @return void
     */
    public function addTemplate($template)
    {
        array_push($this->templates, $template);
    }

    /**
     * Renders templates
     *
     * @return string
     */
    public function render()
    {
        $string = "";

        foreach ($this->templates as $template) {
            if (view()->exists($template)) {
                $string .= view($template, $this->params)->render();
            }
        }

        return $string;
    }
}