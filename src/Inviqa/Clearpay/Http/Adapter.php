<?php

namespace Inviqa\Clearpay\Http;

interface Adapter
{
    /**
     * @param string $uri
     * @param array  $options
     *
     * @return mixed
     */
    public function get(string $uri, $options = []);

    /**
     * @param string $uri
     * @param array  $options
     *
     * @return mixed
     */
    public function post(string $uri, $options = []);
}
