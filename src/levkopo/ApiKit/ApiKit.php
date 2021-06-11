<?php

namespace levkopo\ApiKit;

use JetBrains\PhpStorm\NoReturn;

class ApiKit {
    /**
     * @var callable[] Resolved methods
     */
    private array $methods = [];

    /**
     * @param string $name Name of method
     * @param callable $execute Method function returns response
     * @return $this
     */
    public function method(string $name, callable $execute): self {
        $this->methods[$name] = $execute;
        return $this;
    }

    /**
     * Starts api server
     */
    #[NoReturn] public function start(): void {
        $method = $this->methods[$_GET["method"]??$this->error("Method not specified")]
            ??$this->error("Method not resolved", 404);
        echo json_encode(["response"=>$method($this)]);
        die(200);
    }

    /**
     * @param string[] $needParameters Need parameters
     * @return array Parameters
     */
    public function params(array $needParameters): array {
        $response = [];
        foreach($needParameters as $needParameter)
            $response[] = $_GET[$needParameter]??
                $this->error("Parameter $needParameter not resolved", 404);

        return $response;
    }

    /**
     * Returns error in api server
     * @param string $message Message of error
     * @param int $code Code of error (default is 400)
     */
    #[NoReturn] public function error(string $message, int $code = 400): void {
        echo json_encode(["error" => ["code" => $code, "message" => $message]]);
        die($code);
    }

    protected final function __construct() {}
    public static function create(): self {
        return new self();
    }
}