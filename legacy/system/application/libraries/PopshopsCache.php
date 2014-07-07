<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Caching library using common popshops.cache_storage implementation
 */
class PopshopsCache
{
    protected $ci;
    protected $storage;

    public function __construct()
    {
        $this->ci = get_instance();
        $this->ci->load->helper('bridge');
        $container = silex();
        $this->storage = $container['popshops.cache_storage'];
    }

    /**
     * Caching for library
     */
    public function library($library, $method, $arguments = array(), $expires = null)
    {
        if (!class_exists(ucfirst($library))) {
            $this->ci->load->library($library);
        }

        return $this->load($library, $method, $arguments, $expires);
    }

    /**
     * Caching for model
     */
    public function model($model, $method, $arguments = array(), $expires = null)
    {
        if (!class_exists(ucfirst($library))) {
            $this->ci->load->model($model);
        }

        return $this->load($model, $method, $arguments, $expires);
    }

    protected function load($class, $method, $arguments, $expires)
    {
        $key = sprintf('WWW_%s_%s_%s',
            strtolower($class),
            strtolower($method),
            md5(strtolower(serialize($arguments)))
        );

        if ($this->storage->contains($key)) {
            return $this->storage->fetch($key);
        }

        // get result
        $result = call_user_func_array([$this->ci->$class, $method], $arguments);

        // create cache
        $this->storage->save($key, $result, $expires);

        return $result;
    }
}
