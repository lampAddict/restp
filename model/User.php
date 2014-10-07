<?php

namespace model;

use core\Dispatcher;
use lib\MySQLDbObject;
use lib\model\IntegerField;
use lib\model\StringField;

/**
 * Class User
 * @package model
 */
class User extends MySQLDbObject{
    function __construct() {
        parent::__construct(Dispatcher::obj()->getConfig()->engine, 'user');
        $this->setField('id', new IntegerField('id'));
        $this->setField('name', new StringField('name'));
        //$this->createTable();
    }

    /**
     * @param $uid
     *
     * @return \lib\model\ObjectCollection
     */
    public function getUser($uid) {
        $this->sql = 'SELECT * FROM ' . $this->table . ' WHERE id = \'' . $uid . '\' LIMIT 1;';
        return $this->query();
    }

    /**
     * @return \lib\model\ObjectCollection
     */
    public function getAll(){
        $this->sql = 'SELECT * FROM ' . $this->table . ';';
        return $this->query();
    }
}