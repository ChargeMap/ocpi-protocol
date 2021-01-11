<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Utils;

use BadMethodCallException;

/**
 * Collects flags about set properties when calling 'with' methods and exposes them via 'has' methods.
 * The child class must have protected/private '_with' methods for each property to use this feature, otherwise 'has' method will return false.
 * The postfix of 'has' method must be the same as of '_with' to return the correct value.
 *
 * Conventions for using partial models:
 * If a property's value is null and 'has' method returns false, the value MUST NOT be modified
 * If a property's value is null and 'has' method returns true, the value MUST be set to null (except for array properties)
 * If a property's value is not null and 'has' method returns true, the value MUST be set to this value
 * If an array property's value is an empty array OR null and 'has' method returns true, the value MUST be set to an empty array
 * Note: the implementation of any serialization MUST fit these conventions
 */
abstract class PartialModel
{
    private array $setProperties = [];

    public function __call(string $name, array $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }
        if (substr($name, 0, 4) === 'with') {
            $methodName = '_' . $name;
            if (!method_exists($this, $methodName)) {
                throw new BadMethodCallException("Method $name does not exist");
            }
            $return = call_user_func_array([$this, $methodName], $arguments);
            $this->setProperties[] = substr($name, 4);
            return $return;
        }
        if (substr($name, 0, 3) === 'has') {
            return in_array(substr($name, 3), $this->setProperties);
        }
        throw new BadMethodCallException("Method $name does not exist");
    }
}
