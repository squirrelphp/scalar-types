Squirrel Scalar Types
=====================

[![Build Status](https://img.shields.io/travis/com/squirrelphp/scalar_types.svg)](https://travis-ci.com/squirrelphp/scalar_types) [![Test Coverage](https://api.codeclimate.com/v1/badges/24a5dad790d20148e10a/test_coverage)](https://codeclimate.com/github/squirrelphp/scalar_types/test_coverage) ![PHPStan](https://img.shields.io/badge/style-level%209-success.svg?style=flat-round&label=phpstan) [![Packagist Version](https://img.shields.io/packagist/v/squirrelphp/scalar_types.svg?style=flat-round)](https://packagist.org/packages/squirrelphp/scalar_types) [![PHP Version](https://img.shields.io/packagist/php-v/squirrelphp/scalar_types.svg)](https://packagist.org/packages/squirrelphp/scalar_types) [![Software License](https://img.shields.io/badge/license-MIT-success.svg?style=flat-round)](LICENSE)

Make the coercive mode and strict mode behavior of PHP accessible explicitly via functions: Includes coercions and is_coerceable checks that work like the implicit scalar type coercions in PHP, and an easy way to enforce a specific scalar type mimicking the behavior of strict mode in PHP.

Installation
------------

    composer require squirrelphp/scalar_types

Table of contents
-----------------

- [Test if value can be coerced](#test-if-value-can-be-coerced)
- [Coerce value](#coerce-value)
- [Enforce a type for a value](#enforce-a-type-for-a-value)

Test if value can be coerced
----------------------------

All these functions have one mixed argument `$value` and return true or false:

### is_coerceable_to_int

Returns true if `$value` is one of the following:

- An integer
- A float without fractional part
- A numeric string without fractional part
- A boolean

For any other values it returns false.

### is_coerceable_to_float

Returns true if `$value` is one of the following:

- An integer
- A float
- A numeric string
- A boolean

For any other values it returns false.

### is_coerceable_to_bool

Returns true if `$value` is one of the following:

- An integer with value 0 or 1
- A float with value 0 or 1
- An empty string
- A string with value '0' or '1'
- A boolean

For any other values it returns false.

### is_coerceable_to_string

Returns true if `$value` is one of the following:

- An integer
- A float
- A string
- A boolean
- An object with the magic method __toString

For any other values it returns false.

Coerce value
------------

All these functions have one mixed argument `$value` and return the type they are coercing to, following the same logic as implicit type coercions in PHP.

### coerce_to_int

Coerce a value like PHP 8.2 would do it, which can lead to a TypeError for non-scalar and non-numeric values and a deprecation notice for a float or numeric string with a fractional part.

### coerce_to_float

Coerce a value like PHP 8.2 would do it, which can lead to a TypeError for non-scalar and non-numeric values.

### coerce_to_bool

Coerce a value like PHP 8.2 would do it, which can lead to a TypeError for non-scalar values and a deprecation notice for values other than "", "0", "1", 0, 1, 0.0 and 1.0.

### coerce_to_string

Coerce a value like PHP 8.2 would do it, which can lead to a TypeError for non-scalar values except if it is an object that implements the magic __toString method.

Enforce a type for a value
--------------------------

All these functions have one mixed argument `$value` and return the type they are enforcing, according to the same logic as strict mode in PHP.

### enforce_int

Returns `$value` as an integer if it is an integer. Throws a TypeError otherwise.

### enforce_float

Returns `$value` as a float if it is an integer or a float. Throws a TypeError otherwise.

### enforce_bool

Returns `$value` as a boolean if it is a boolean. Throws a TypeError otherwise.

### enforce_string

Returns `$value` as a string if it is a string. Throws a TypeError otherwise.