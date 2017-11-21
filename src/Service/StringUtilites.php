<?php

namespace Nordkirche\Ndk\Service;

class StringUtilites
{

    /**
     * Converts CamelCaseString to camel_case_string
     *
     * @param string $string
     *
     * @return string
     */
    public static function decamelize(string $string)
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1_', $string));
    }

    /**
     * Converts camel_case_string to CamelCaseString
     *
     * @param string $string
     *
     * @return string
     */
    public static function camelize(string $string)
    {
        return str_replace('_', '', ucwords($string, '_'));
    }
}
