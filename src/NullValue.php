<?php

namespace Naski\Config;

/**
 * Représente une valeur qui n'existe pas
 *
 * Utilisé pour retourner du vide sous toutes les dimentions,
 * même si les dimentions précédentes n'existent pas
 */
class NullValue implements \ArrayAccess
{

    public function __toString()
    {
        return '';
    }

    public function offsetGet($key)
    {
        return new self();
    }

    public function offsetSet($offset, $value) { }

    public function offsetExists($offset)
    {
        return false;
    }

    public function offsetUnset($offset) { }

}
