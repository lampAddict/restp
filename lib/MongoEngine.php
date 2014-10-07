<?php

namespace lib;

class MongoEngine {

    public $_client;

    /**
     *
     */
    function __construct(){
        $this->_client = new \MongoClient();
    }
}