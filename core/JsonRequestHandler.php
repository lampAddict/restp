<?php

namespace core;

class JsonRequestHandler implements IRequestHandler {

    private $handlerCfg;

    function __construct($handlersCfg) {
        $this->handlerCfg = $handlersCfg;
    }

    /**
     * @return bool
     */
    public function handle() {

        $_COOKIE = array();

        if (isset($_POST['json']) && $_POST['json']) $json = $_POST['json'];
        else $json = file_get_contents('php://input');

        if (!$json) return;

        $request = new JsonRequest($json);

        Dispatcher::obj()->request = $request;

        foreach($this->handlerCfg as $action => $methodArr) {

            $methodString = $methodArr[0];

            if ($request->requestName == $action) {

                header('Content-type: application/json; charset=utf-8');

                $matches = array();
                preg_match('/(?<class>.*)::(?<method>.*)$/', $methodString, $matches);
                $classname = $matches['class'];
                $method = $matches['method'];

                $ctl = new $classname($request);
                $response = $ctl->$method();

                echo $response;

                return true;
            }
        }

        $response = new JsonResponse($request);
        $response->error = JsonResponse::UNKNOWN_ACTION;

        echo $response;

        return false;
    }

} 