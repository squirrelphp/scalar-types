<?php

if (!function_exists('enforce_int')) {
    /** @param mixed $value */
    function enforce_int($value): int
    {
        if (!is_int($value)) {
            throw new TypeError('Value passed to enforce_int does not contain int: ' . var_export($value, true));
        }

        return $value;
    }
}

if (!function_exists('enforce_float')) {
    /** @param mixed $value */
    function enforce_float($value): float
    {
        if (!is_int($value) && !is_float($value)) {
            throw new TypeError('Value passed to enforce_float does not contain int or float: ' . var_export($value, true));
        }

        return $value;
    }
}

if (!function_exists('enforce_bool')) {
    /** @param mixed $value */
    function enforce_bool($value): bool
    {
        if (!is_bool($value)) {
            throw new TypeError('Value passed to enforce_bool does not contain bool: ' . var_export($value, true));
        }

        return $value;
    }
}

if (!function_exists('enforce_string')) {
    /** @param mixed $value */
    function enforce_string($value): string
    {
        if (!is_string($value)) {
            throw new TypeError('Value passed to enforce_string does not contain string: ' . var_export($value, true));
        }

        return $value;
    }
}
