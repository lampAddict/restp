<?php

namespace config;

use core\IRequestHandler;
use core\JsonRequestHandler;
use lib\MySQLDbEngine;
use lib\MongoEngine;

class Config {
    /**
     * @var IRequestHandler[]
     */
    public $handlers;

    /**
     * @var MySQLDbEngine
     */
    public $engine;

    /**
     * @var MongoEngine
     */
    public $mongo;

    const DBNAME = 'test';

    function __construct() {
        $this->handlers = array(
            new JsonRequestHandler(array(
                'get_user_rate' => array('\ctl\Main::getUserRate', false),
                'import_data' => array('\ctl\Main::importData', false),
                'get_mongo_user_rate' => array('\ctl\Main::getMongoUserRate', false),
            ))
        );

        $this->engine = new MySQLDbEngine( 'localhost', 'root', 'master', Config::DBNAME, $pre='' );
        $this->mongo = new MongoEngine();
    }

} 