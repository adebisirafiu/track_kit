<?php
namespace App;

class Request {
    private $path;
    private $method;
    private $data;

    public function __construct() {
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    }

    public function getPath() {
        return $this->path;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getData() {
        return $this->data;
    }
}
