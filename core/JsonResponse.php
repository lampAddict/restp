<?php

namespace core;

class JsonResponse {

    const UNKNOWN_ACTION            = 0x0001;

    public $error = 0;
    public $data;

    function __construct(JsonRequest $request) {
        $this->data = new \ArrayObject();
    }

    function __toString() {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }

} 