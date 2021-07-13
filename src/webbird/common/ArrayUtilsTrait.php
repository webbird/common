<?php

declare(strict_types=1);

namespace webbird\common;

trait ArrayUtilsTrait
{
    /**
     * prepend a string to every key
     * 
     * @param array $arr
     * @param string $prepend
     * @return array
     */
    public function prependToKeys(array $arr, string $prepend) : array
    {
        $prepended = array_combine(
            array_map(function($key) use ($prepend) { return $prepend.$key; }, array_keys($arr)),
            $arr
        );
        return $prepended;
    }
    
    /**
     * append a string to every key
     * 
     * @param array $arr
     * @param string $append
     * @return array
     */
    public function appendToKeys(array $arr, string $append) : array
    {
        $appended = array_combine(
            array_map(function($key) use ($append) { return $append.$key; }, array_keys($arr)),
            $arr
        );
        return $appended;
    }
    
    /**
     * wrap every key into string
     * 
     * Example: 
     *     Key   : 'key'
     *     Wrap  : '%'
     *     Result: '%key%'
     * 
     * @param array $arr
     * @param string $wrap
     * @return array
     */
    public function wrapKeys(array $arr, string $wrap) : array
    {
        $wrapped = array_combine(
            array_map(function($key) use ($wrap) { return $wrap.$key.$wrap; }, array_keys($arr)),
            $arr
        );
        return $wrapped;
    }
    
    /**
     * sort an array
     *
     * @access public
     * @param  array   $arr            - array to sort
     * @param  mixed   $index          - key to sort by
     * @param  string  $order          - 'asc' (default) || 'desc'
     * @param  boolean $natsort        - default: false
     * @param  boolean $case_sensitive - sort case sensitive; default: false
     * @return array   sorted array
     **/
    public function sortby(array $arr, mixed $index, string $order='asc', bool $natsort=false, bool $case_sensitive=false ) : array
    {
        $so = ($order=='asc') ? SORT_ASC : SORT_DESC;
        $flags = SORT_REGULAR; // default
        if($natsort) {
            $flags = SORT_NATURAL;
        }
        if(!$case_sensitive) {
            $flags = $flags | SORT_FLAG_CASE;
        }
        $columns = array_column($arr, $index);
        return \array_multisort($columns, $so, $flags, $arr);
    }   // end function sortby()
}
