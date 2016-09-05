<?php

namespace Apollo16\Core\Route;

use Apollo16\Core\Contracts\Route\Binder as BinderContract;
use Illuminate\Contracts\Routing\Registrar;
use RuntimeException;

/**
 * Route binder.
 *
 * @author      mohammad.anang  <m.anangnur@gmail.com>
 */

abstract class Binder implements BinderContract
{
    /**
     * Route path prefix.
     *
     * @var string
     */
    protected $prefix = '/';

    /**
     * Registered route name.
     *
     * @var string
     */
    protected $name;

    /**
     * Register route binding.
     *
     * @param \Illuminate\Contracts\Routing\Registrar $route
     * @return mixed
     */
    abstract public function bind(Registrar $route);

    /**
     * Get route prefix.
     *
     * @param string $path
     * @return string
     */
    public function prefix($path = '/')
    {
        $qualifiedPath = $this->prefix.'/'.ltrim($path, '/');

        return str_replace('//', '/', $qualifiedPath);
    }

    /**
     * Get route name.
     *
     * @param null|string $suffix
     * @return string
     */
    public function name($suffix = null)
    {
        if(empty($suffix)) {
            return $this->name;
        }

        return $this->name.'.'.$suffix;
    }

    /**
     * Use controller method.
     *
     * @param $method
     * @return string
     */
    public function uses($method)
    {
        if(!method_exists($this, 'controller')) {
            throw new RuntimeException('Controller is not defined.');
        }

        return $this->controller().'@'.$method;
    }
}