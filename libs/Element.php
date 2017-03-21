<?php

//namespace Tinyshaker;

class Element
{
    protected $path;
    protected $name;
    protected $data;
    protected $type;
    protected $alt;
    protected $time;
    protected $new = false;

    /**
     * Element constructor.
     * @param string $filePath
     * @param string|object $nameOrJson
     */
    public function __construct($filePath, $nameOrJson)
    {
        $this->path = $filePath;

        if (is_object($nameOrJson)) {
            $json = $nameOrJson;

            if (!isset($json->data)) {
                return null;
            }

            $base64Match = preg_match('#^data:(.+);base64,#', $json->data);
            $httpMatch = preg_match('#^(http(s)?://)#', $json->data);
            if ($base64Match) {
                // $json->data is a raw source encoded in base64 (directly readable by a browser)
                $mimeType = $base64Match[0];
                $this->source = $json->data;
                $this->type = substr(strrchr($mimeType, '/'), 1);
                $this->alt = isset($json->alt) ? $json->alt : $mimeType;
                $this->time = strtotime(isset($json->time) ? $json->time : 'now');
            } elseif ($httpMatch) {
                // $json->data is an URI
                $this->source = $json->data;
                $this->type = substr(strrchr($json->data, '.'), 1, 3);
                $this->alt = isset($json->alt) ? $json->alt : substr(strrchr($json->data, '/'), 1);
                $this->time = strtotime(isset($json->time) ? $json->time : 'now');
            } else {
                // $json->data is a file name
                $this->source = $this->path . $json->data;
                $this->type = substr(strrchr($this->name, '.'), 1);
                $this->alt = preg_replace('/\.' . $this->type . '$/', '', $this->name);
                $this->time = filemtime($this->path . $this->name);
            }

            $this->new = !empty($json->new) ? true : (strpos($this->source, '_new') !== false);
        } else {
            //init element from the file path and name itself
            $this->name = $nameOrJson;
            $this->source = $this->path . $this->name;
            $this->type = substr(strrchr($this->name, '.'), 1);
            $this->alt = preg_replace('/\.' . $this->type . '$/', '', $this->name);
            $this->time = filemtime($this->path . $this->name);
            $this->new = (strpos($this->source, '_new') !== false);
        }

    }

    public function isNew()
    {
        return $this->new;
    }

    public function isType($typeToCompare)
    {
        return $this->type == $typeToCompare;
    }

    public function __get($name)
    {
        return property_exists($this, $name) ? $this->$name : null;
    }
}
