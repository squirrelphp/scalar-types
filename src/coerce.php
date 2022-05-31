<?php

if (!function_exists('coerce_to_int')) {
    /** @param mixed $value */
    function coerce_to_int($value): int
    {
        if (!is_scalar($value)) {
            throw new TypeError('Non-scalar type ' . gettype($value) . ' cannot be coerced to int');
        }

        // Needed because booleans are not numeric and would fail the next if block
        if (is_bool($value)) {
            return (int)$value;
        }

        if (!is_numeric($value)) {
            throw new TypeError('Non-numeric value "' . $value . '" cannot be coerced to int');
        }

        if ((float)$value != (int)$value) {
            trigger_error('Float with fractional part cannot be coerced to int without information loss: ' . $value, E_USER_DEPRECATED);
        }

        return (int)$value;
    }
}

if (!function_exists('coerce_to_float')) {
    /** @param mixed $value */
    function coerce_to_float($value): float
    {
        if (!is_scalar($value)) {
            throw new TypeError('Non-scalar type ' . gettype($value) . ' cannot be coerced to float');
        }

        // Needed because booleans are not numeric and would fail the next if block
        if (is_bool($value)) {
            return (float)$value;
        }

        if (!is_numeric($value)) {
            throw new TypeError('Non-numeric value "' . $value . '" cannot be coerced to float');
        }

        return (float)$value;
    }
}

if (!function_exists('coerce_to_bool')) {
    /** @param mixed $value */
    function coerce_to_bool($value): bool
    {
        if (!is_scalar($value)) {
            throw new TypeError('Non-scalar type ' . gettype($value) . ' cannot be coerced to bool');
        }

        if (
            is_string($value)
            && $value !== ''
            && $value !== '0'
            && $value !== '1'
        ) {
            trigger_error('Implicit conversion from string "' . $value . '" to true, only "", "0" and "1" are allowed', E_USER_DEPRECATED);
        }

        if (
            is_int($value)
            && $value !== 0
            && $value !== 1
        ) {
            trigger_error('Implicit conversion from int ' . $value . ' to true, only 0 and 1 are allowed', E_USER_DEPRECATED);
        }

        if (
            is_float($value)
            && $value != 0
            && $value != 1
        ) {
            trigger_error('Implicit conversion from float ' . $value . ' to true, only 0 and 1 are allowed', E_USER_DEPRECATED);
        }

        return (bool)$value;
    }
}

if (!function_exists('coerce_to_string')) {
    /** @param mixed $value */
    function coerce_to_string($value): string
    {
        if (is_object($value) && method_exists($value, '__toString')) {
            return $value->__toString();
        }

        if (!is_scalar($value)) {
            throw new TypeError('Non-scalar type ' . gettype($value) . ' cannot be coerced to string');
        }

        return (string)$value;
    }
}

if (!function_exists('is_coerceable_to_int')) {
    /** @param mixed $value */
    function is_coerceable_to_int($value): bool
    {
        if (!is_scalar($value)) {
            return false;
        }

        if (is_bool($value)) {
            return true;
        }

        if (!is_numeric($value)) {
            return false;
        }

        if ((float)$value != (int)$value) {
            return false;
        }

        return true;
    }
}

if (!function_exists('is_coerceable_to_float')) {
    /** @param mixed $value */
    function is_coerceable_to_float($value): bool
    {
        if (!is_scalar($value)) {
            return false;
        }

        if (is_bool($value)) {
            return true;
        }

        if (!is_numeric($value)) {
            return false;
        }

        return true;
    }
}

if (!function_exists('is_coerceable_to_bool')) {
    /** @param mixed $value */
    function is_coerceable_to_bool($value): bool
    {
        if (!is_scalar($value)) {
            return false;
        }

        if (
            is_string($value)
            && $value !== ''
            && $value !== '0'
            && $value !== '1'
        ) {
            return false;
        }

        if (
            is_int($value)
            && $value !== 0
            && $value !== 1
        ) {
            return false;
        }

        if (
            is_float($value)
            && $value != 0
            && $value != 1
        ) {
            return false;
        }

        return true;
    }
}

if (!function_exists('is_coerceable_to_string')) {
    /** @param mixed $value */
    function is_coerceable_to_string($value): bool
    {
        if (is_object($value) && method_exists($value, '__toString')) {
            return true;
        }

        if (!is_scalar($value)) {
            return false;
        }

        return true;
    }
}
