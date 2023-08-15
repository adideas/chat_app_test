<?php

namespace Adideas\ChatApp\ChatApp\Contract;

use Adideas\ChatApp\ChatApp\Client\Guzzle;
use Illuminate\Support\Facades\App;

/**
 * @method __construct()
 */
abstract class ApiMethod
{
    protected string $_METHOD = 'GET';
    protected string $_URL = '';
    protected array $_HEADERS = [];
    protected static ?Client $_CLIENT = null;

    public function toArray(): array
    {
        $data = [];

        foreach (get_class_vars(static::class) as $key => $value) {
            if ($key[0] != '_') {
                $data[$key] = $this->{$key};
            }
        }

        return $data;
    }

    abstract public function transform(string $result): mixed;

    public function getURL(): string
    {
        return $this->_URL;
    }

    public function getHEADERS(): array
    {
        return $this->_HEADERS;
    }

    public function getMETHOD(): string
    {
        return $this->_METHOD;
    }

    public function isGET(): bool
    {
        return $this->_GET;
    }

    public function run(): mixed
    {
        if (!static::$_CLIENT) {
            try {
                $class = App::getInstance()
                    ->get('config')
                    ->get('chat_app.client', Guzzle::class);
            } catch (\Throwable $exception) {
                $class = Guzzle::class;
            }

            self::$_CLIENT = new $class();
        }

        $client = self::$_CLIENT;

        return $client($this);
    }
}
