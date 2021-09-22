<?php

declare(strict_types=1);

namespace webbird\common;

trait PropertyGeneratorTrait
{
    /**
     * 
     * @param string $methodName
     * @param array $arguments
     * @return mixed
     * @throws \UnexpectedValueException
     */
    public function __call(string $methodName, array $arguments): mixed
    {
        $matches = [];
        $result = \false;
        if (preg_match('~^(set|get)([A-Z])(.*)$~', $methodName, $matches)) {
            $property = strtolower($matches[2]) . $matches[3];
            switch($matches[1]) {
                case 'set':
                    $this->$property = $arguments[0];
                    $result = true;
                    break;
                case 'get':
                    $result = property_exists($this, $property)
                            ? $this->{$property}
                            : \null;
                    break;
                default:
                    throw new \UnexpectedValueException(sprintf(
                        'Method [%s] does not exist',
                        $methodName
                    ));
            }
        }
        return $result;
    }   // end function __call()

    /**
     * 
     * @param string $property
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __get(string $property) : mixed
    {
        $method = 'get' . \ucfirst($property);
        if (\method_exists($this, $method)) {
            $reflection = new \ReflectionMethod($this, $method);
            if (!$reflection->isPublic()) {
                throw new \BadMethodCallException("The called method is not public.");
            }
        }
        if (\property_exists($this, $property)) {
            return $this->{$property};
        }
        return \null;
    }   // end function __get()

    /**
     * 
     * @param string $property
     * @param mixed $value
     * @throws \BadMethodCallException
     */
    public function __set(string $property, mixed $value)
    {
        $method = 'set' . \ucfirst($property);
        if (\method_exists($this, $method)) {
            $reflection = new \ReflectionMethod($this, $method);
            if (!$reflection->isPublic()) {
                throw new \BadMethodCallException("The called method is not public.");
            }
        }
        # to allow optional properties, we do not check for existance here
        $this->$property = $value;
    }   // end function __set()

    /**
     * 
     * @return array
     */
    public function specialKeys() : array
    {
        return array();
    }   // end function specialKeys()

    /**
     * 
     * @param mixed $optional
     * @return void
     */
    public function getParameters(mixed $optional) : void
    {
        if(is_array($optional)) {
            $specials = $this->specialKeys();
            foreach($optional as $key => $value) {
                if(array_key_exists($key,$specials) && $value instanceof $specials[$key]) {
                    $this->$key = $value;
                } else {
                    $this->{$key} = $value;
                }
            }
        }
    }   // end function getParameters()
    
}
