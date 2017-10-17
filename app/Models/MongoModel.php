<?php
/**
 * Created by PhpStorm.
 * User: wuwentao
 * Date: 2017/10/16
 * Time: 16:37
 */

namespace App\Models;


use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;

class MongoModel implements \ArrayAccess
{

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @var string
     */
    protected $database;

    /**
     * @var string
     */
    protected $collections;

    /**
     * @var array
     */
    protected $data;

    /**
     * MongoModel constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        if (is_array($data)) {
            $this->data = $data;
        } else {
            $this->data = json_decode(json_encode($data, JSON_UNESCAPED_UNICODE), true);
        }
    }

    /**
     * @param $id
     * @param $database
     * @param $collection
     * @param array $options
     * @return MongoModel|null
     */
    public static function find($id, $database = null, $collection = null, $options = [])
    {
        $manager = self::createManager();
        if (!$database) {
            $database = config('database.mongodb.database');
        }
        if (!$collection) {
            $collection = config('database.mongodb.collection');
        }
        $filter = ['_id'=>$id];
        $query = new Query($filter, $options);
        $cur = $manager->executeQuery("$database.$collection", $query);
        $arr = $cur->toArray();
        if (count($arr) >= 1) {
            return new MongoModel($arr[0]);
        }
        return null;
    }

    /**
     * @return Manager
     */
    public static function createManager()
    {
        $host = config('database.mongodb.host');
        $port = config('database.mongodb.port');
        return new Manager("mongodb://$host:$port");
    }

    /**
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param string $database
     * @return MongoModel
     */
    public function setDatabase($database)
    {
        $this->database = $database;
        return $this;
    }

    /**
     * @return string
     */
    public function getCollections()
    {
        return $this->collections;
    }

    /**
     * @param string $collections
     * @return MongoModel
     */
    public function setCollections($collections)
    {
        $this->collections = $collections;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return MongoModel
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * is utilized for reading data from inaccessible members.
     *
     * @param $name string
     * @return mixed
     * @link http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return null;
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        if (isset($this->data[$offset])) {
            return $this->data[$offset];
        }
        return null;
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

}