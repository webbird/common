<?php

declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace webbird\common;

/**
 * Description of ValidatorTrait
 *
 * @author bmartino
 */
trait ValidatorTrait 
{
    /**
     * 
     * @param string $path
     * @return string
     */
    public function fixPath(string $path) : string
    {
        $fixed = preg_replace('~/\./~', '/', str_replace( '\\', '/', preg_replace( '~/{1,}$~', '', $path )));
        // resolve /../
        // loop through all the parts, popping whenever there's a .., pushing otherwise.
        $parts      = array();
        foreach ( explode('/', preg_replace('~/+~', '/', $fixed)) as $part )
        {
            if ($part === ".." || $part === '')
            {
                array_pop($parts);
            }
            elseif ($part!="")
            {
                $parts[] = $part;
            }
        }
        $new_path = implode("/", $parts);
        // windows
        if (!preg_match('/^[a-z]\:/i', $new_path)) {
            $new_path = '/' . $new_path;
        }
        return $new_path;
    }   // end function fixPath()
}
