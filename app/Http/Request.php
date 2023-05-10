<?php

namespace App\Http;

class Request extends \Symfony\Component\HttpFoundation\Request
{
    private array $jsonData;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->setJsonData();
    }

    public function isJson(): bool
    {
        return (isset($_SERVER['HTTP_CONTENT_TYPE']) && $_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') || $this->getContent() != '';
    }

    private function setJsonData(): void
    {
        if ($this->isJson()) {
            $this->jsonData = $this->toArray();
        }
    }

    public function jsonHas(string $key): bool
    {
        if (count($this->jsonData) == 0 ) return false;
        $currentTarget = $this->jsonData;
        foreach (explode('.', $key) as $ch) {
            if ($currentTarget[$ch]) {
                $currentTarget = $currentTarget[$ch];
            } else {
                return false;
            }
        }
        return true;
    }

    public function jsonGet(string $key)
    {
        if (count($this->jsonData) == 0 ) return null;

        if ($this->jsonHas($key)) {
            $currentTarget = $this->jsonData;
            foreach (explode('.', $key) as $ch) {
                if ($currentTarget[$ch]) {
                    $currentTarget = $currentTarget[$ch];
                } else {
                    return null;
                }
            }
            return $currentTarget;
        }
        return null;
    }
//    private $storage; // переменная хранящая данные GET и POST
//
//
//    // при создании объекта запроса мы пропускаем все данные
//    // через фильтр-функцию для очистки параметров от нежелательных данных
//    public function __construct() {
//        $this->storage = $this->cleanInput($_REQUEST);
//        $this->saveParamsFromBody();
//    }
//
//    // магическая функция, которая позволяет обращатья к GET и POST переменным
//    // по имени, например,
//    // запрос - myrusakov.ru/user.php?id=Qashbs36e
//    // в коде - echo $request -> id
//    public function __get($name) {
//        if (isset($this->storage[$name])) return $this->storage[$name];
//    }
//
//
//    // очистка данных от опасных символов
//    private function cleanInput($data) {
//        if (is_array($data)) {
//            $cleaned = [];
//            foreach ($data as $key => $value) {
//                $cleaned[$key] = $this->cleanInput($value);
//            }
//            return $cleaned;
//        }
//        return trim(htmlspecialchars($data, ENT_QUOTES));
//    }
//
//    private function saveParamsFromBody()
//    {
//        if (isset($_SERVER['HTTP_CONTENT_TYPE']) && $_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') {
//            $jsonData = $this->cleanInput(json_decode(file_get_contents('php://input'), true));
//            $this->storage = array_merge($this->storage, $jsonData);
//        }
//    }
//
//
//    // возвращаем содержимое хранилища
//    public function getRequestEntries()
//    {
//        return $this->storage;
//    }
}