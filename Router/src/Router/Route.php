<?php

namespace App\Router;

class Route {

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable){
        
        $this->path = trim($path, '/');

        $this->callable = $callable; 
    }

    public function with($param, $regex){
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'] , $this->path);
        $regex = "#$path^$#i";
        if(preg_match($regex, $url, $matches));{
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function paramMatch($match){
        if(isset($this->params[$match[1]])){
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';

    }


    public function call(){
        return call_user_func_array($this->callable, $this->matches);
    }

    public function getUrl($params){
        $path = $this->path;
        foreach ($params as $k => $v){
            $path = str_replace(":sk", $v, $path);
        }
        return $path;
    }
}