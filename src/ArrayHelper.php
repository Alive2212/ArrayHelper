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
    protected $resultValue = [];
    protected $resultKey = [];

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

    public function getKey($key)
    {
        return $this->resultKey[$key];
    }

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

//    public function getDeepNew($array,$key,$returnedArray = null,$delimiter='.')
//    {
//        $response = null;
//        $keyValues = explode($delimiter,$key);
////        if(!is_null($returnedArray)){
//            if ($this->isMapArray($array)){
//
//            }else{
//                foreach ( as $item) {
//
//                }
//            }
////        }
//    }
//
    public
    function isMapArray($array)
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