<?php
/**
 * Created by PhpStorm.
 * User: alive
 * Date: 10/6/17
 * Time: 11:48 AM
 */

namespace Alive2212\ArrayHelper;


use PhpParser\Node\Expr\Cast\Double;
use phpseclib\Math\BigInteger;

class ArrayHelper
{
    /**
     * @var array
     */
    protected $resultValue = [];

    /**
     * @var array
     */
    protected $resultKey = [];

    /**
     * ArrayHelper constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $array
     * @param int $parentCode
     * @param $parentKey
     * @return $this
     */
    public function serializeArray($array, $parentCode = 0, $parentKey = '')
    {
        $parentCode *= 100;
        $itemCode = 1;
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->serializeArray($value, $parentCode + $itemCode, $parentKey . '.' . $key);
            } else {
                $this->resultValue = array_add($this->resultValue, $parentCode + $itemCode, $value);
                $this->resultKey = array_merge($this->resultKey, [substr($parentKey . '.' . $key, 1) => $parentCode + $itemCode]);
            }
            $itemCode++;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getValue()
    {
        return $this->resultValue;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return $this->resultKey;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getKey($key)
    {
        return $this->resultKey[$key];
    }

    /**
     * @param $array
     * @param $keys
     * @param string $delimiter
     * @return null
     */
    public function getDeep($array, $keys, $delimiter = '.')
    {
        if (is_array($keys)) {

        } else {
            $keyValues = explode($delimiter, $keys);

            foreach ($keyValues as $keyValue) {
                if (isset($array[$keyValue])) {
                    $array = $array[$keyValue];
                } else {
                    return null;
                }
            }
        }
        return $array;
    }

    /**
     * @param $array
     * @return bool
     */
    public function isMapArray($array)
    {
        $result = false;
        foreach ($array as $key => $value) {
            if (!is_numeric($key)) {
                $result = true;
            }
        }
        return $result;
    }
}