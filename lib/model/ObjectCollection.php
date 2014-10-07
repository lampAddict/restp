<?php

namespace lib\model;

class ObjectCollection implements \ArrayAccess, \Iterator{

    /**
     * @var Object[]
     */
    protected $items = array();

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset) {
        return isset($this->items);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset) {
        return $this->items[$offset];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value) {
        $this->items[$offset] = $value;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset) {
        unset($this->items[$offset]);
    }

    /**
     * @var
     */
    protected $curItem;

    /**
     * @param string $fieldName
     * @param bool $isDescending
     */
    public function order($fieldName, $isDescending = false) {
        usort($this->items, function($a, $b) use ($fieldName, $isDescending) {
            $res = 0;
            if($a->$fieldName < $b->$fieldName) $res = -1;
            elseif ($a->$fieldName > $b->$fieldName) $res = 1;

            if ($isDescending) $res = $res * -1;
            return $res;
        });

        return $this;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return Object Can return any type.
     */
    public function current() {
        return $this->items[$this->curItem];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next() {
        $this->curItem = $this->curItem + 1;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key() {
        return $this->curItem;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid() {
        return isset($this->items[$this->curItem]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind() {
        $this->curItem = 0;
    }

    /**
     * @return array
     */
    public function toArray($name = null) {
        $res = array();
        foreach($this as $object) {
            if ($name) $res[] = $object->$name;
            else $res[] = $object->toArray();
        }
        return $res;
    }

    public function walk($lambda) {
        foreach($this->items as &$object) $lambda($object);
    }

    function __get($name) {
        $res = array();
        foreach($this as $object) if (isset($object->$name)) $res[] = $object->$name;
        return $res;
    }

    /**
     * @param Object $obj
     */
    public function add(Object $obj) {
        $this->items[] = $obj;
    }

    /**
     * @return int
     */
    public function count() {
        return count($this->items);
    }

    public function findByField($field, $value) {
        foreach($this->items as $item) if (isset($item[$field]) && $item[$field] == $value) return $item;

        return false;
    }
}