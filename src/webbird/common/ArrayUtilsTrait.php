<?php

declare(strict_types=1);

namespace webbird\common;

trait ArrayUtilsTrait
{
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
