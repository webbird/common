<?php

declare(strict_types=1);

namespace webbird\common;

use Sirius\Validation\Validator As Validator;

/**
 * Description of ValidatorTrait
 *
 * @author bmartino
 */
trait ValidatorTrait 
{
    protected static \Sirius\Validation\Validator $v;
    
    /**
     * accessor to Sirius\Validation\Validator
     * 
     * @param type $selector
     * @param type $name
     * @param type $options
     * @param type $messageTemplate
     * @param type $label
     * @return type
     */
    public function add(
        $selector, 
        $name = null, 
        $options = null, 
        $messageTemplate = null, 
        $label = null
    )
    {
        if(!is_object(self::$v)) {
            self::$v = new Validator();
        }
        return self::$v->add($selector,$name,$options,$messageTemplate,$label);
    }
    
    /**
     * accessor to Sirius\Validation\Validator
     * 
     * @param mixed $data
     * @return type
     */
    public function validate(mixed $data=null)
    {
        if(!is_object(self::$v)) {
            self::$v = new Validator();
        }
        return self::$v->validate($data);
    }
    
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
