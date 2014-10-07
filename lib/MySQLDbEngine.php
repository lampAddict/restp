<?php

namespace lib;

class MySQLDbEngine {

private $_server     = '';
private $_user       = '';
private $_pass       = '';
private $_database   = '';
private $_pre         = '';

private $affected_rows = 0;

private $link_id = 0;
private $query_id = 0;

/**
 * @param        $server
 * @param        $user
 * @param        $pass
 * @param        $database
 * @param string $pre
 */
function __construct($server, $user, $pass, $database, $pre=''){
	$this->_server = $server;
	$this->_user = $user;
	$this->_pass = $pass;
	$this->_database = $database;
	$this->_pre = $pre;

    $this->connect();
}

/**
 *
 */
private function connect() {

	$this->link_id = mysql_connect($this->_server, $this->_user, $this->_pass);

	if ( !$this->link_id ) {
		$this->show_error_msg("Could not connect to server: <b>$this->server</b>.");
	}

	if( !mysql_select_db($this->_database, $this->link_id) ) {
		$this->show_error_msg("Could not open database: <b>$this->database</b>.");
	}
}

/**
 * @param $sql
 *
 * @return int|resource
 */
public function query($sql) {

	$this->query_id = mysql_query($sql);

	if ( !$this->query_id ) {
		$this->show_error_msg("<b>MySQL Query fail:</b> $sql");
		return 0;
	}
	
	$this->affected_rows = mysql_affected_rows($this->link_id);
	return $this->query_id;
}

/**
 * @param $query_id
 *
 * @return array
 */
public function fetch_array($query_id = -1) {

	if ( $query_id > 0 ) {
		$this->query_id = $query_id;
		$record = mysql_fetch_assoc($this->query_id);
	}else{
		$this->show_error_msg("Invalid query_id: <b>$this->query_id</b>. Records could not be fetched.");
	}
	return $record;
}

/**
 * @param $sql
 *
 * @return array
 */
public function fetch_all_array($sql) {

    $out = array();
	$query_id = $this->query($sql);
	while ( $row = $this->fetch_array($query_id) ){
		$out[] = $row;
	}
	return $out;
}

/**
 * @param $tableName
 * @param $fields
 *
 * @return int
 */
public function createTable($tableName, $fields){

    $fsql = '';
    $index = '';
    foreach( $fields as $fname=>$field ){
        $fsql .= '`'.$fname.'` ' . $field->getType() . ' NOT NULL ' . ($fname == 'id' ? 'AUTO_INCREMENT' : '') . ',';
        if( $fname == 'id' )
            $index = 'INDEX `ind` (`id`)';
    }
    $fsql .= $index;
    $fsql = rtrim($fsql, ',');

    $fsql = '(' . $fsql . ') ENGINE=MyISAM COLLATE="utf8_general_ci";';

    $this->query('CREATE TABLE IF NOT EXISTS ' . $tableName . '' . $fsql);
    return $this->query_id;
}

/**
 * @param string $msg
 */
protected function show_error_msg($msg = ''){
    error_log($msg . ' ' .mysql_error());
}

}
