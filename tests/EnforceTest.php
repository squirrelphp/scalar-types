<?php

namespace Squirrel\Coercions\Tests;

use TypeError;

class EnforceTest extends \PHPUnit\Framework\TestCase
{
    public function testEnforceToInt(): void
    {
        $values = [
            [
                'input' => 0,
                'output' => 0,
                'enforceable' => true,
            ],
            [
                'input' => -33,
                'output' => -33,
                'enforceable' => true,
            ],
            [
                'input' => 7835,
                'output' => 7835,
                'enforceable' => true,
            ],
            [
                'input' => 0.0,
                'output' => new TypeError('Value passed to enforce_int does not contain int: 0.0'),
                'enforceable' => false,
            ],
            [
                'input' => 39.5,
                'output' => new TypeError('Value passed to enforce_int does not contain int: 39.5'),
                'enforceable' => false,
            ],
            [
                'input' => -1.75,
                'output' => new TypeError('Value passed to enforce_int does not contain int: -1.75'),
                'enforceable' => false,
            ],
            [
                'input' => '0',
                'output' => new TypeError('Value passed to enforce_int does not contain int: \'0\''),
                'enforceable' => false,
            ],
            [
                'input' => 'failed',
                'output' => new TypeError('Value passed to enforce_int does not contain int: \'failed\''),
                'enforceable' => false,
            ],
            [
                'input' => '',
                'output' => new TypeError('Value passed to enforce_int does not contain int: \'\''),
                'enforceable' => false,
            ],
            [
                'input' => true,
                'output' => new TypeError('Value passed to enforce_int does not contain int: true'),
                'enforceable' => false,
            ],
            [
                'input' => false,
                'output' => new TypeError('Value passed to enforce_int does not contain int: false'),
                'enforceable' => false,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Value passed to enforce_int does not contain int:'),
                'enforceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Value passed to enforce_int does not contain int: array (' . "\n" . ')'),
                'enforceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Value passed to enforce_int does not contain int: (object) array(' . "\n" . ')'),
                'enforceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Value passed to enforce_int does not contain int: NULL'),
                'enforceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            try {
                $output = enforce_int($entry['input']);

                if ($entry['enforceable'] === false) {
                    $this->fail('Enforce to int did not throw exception for ' . $entry['input']);
                } else {
                    $this->assertSame($entry['output'] ?? null, $output);
                }
            } catch (TypeError $e) {
                if ($entry['enforceable'] === false) {
                    $expectedError = $entry['output'];
                    $this->assertInstanceOf(TypeError::class, $expectedError);

                    if ($expectedError->getMessage() === 'Value passed to enforce_int does not contain int:') {
                        $this->assertStringStartsWith('Value passed to enforce_int does not contain int:', $e->getMessage());
                    } else {
                        $this->assertSame($expectedError->getMessage(), $e->getMessage());
                    }
                } else {
                    $this->fail('Enforce to int did throw exception for ' . $entry['input']);
                }
            }
        }
    }

    public function testEnforceToFloat(): void
    {
        $values = [
            [
                'input' => 0,
                'output' => 0.0,
                'enforceable' => true,
            ],
            [
                'input' => -33,
                'output' => -33.0,
                'enforceable' => true,
            ],
            [
                'input' => 7835,
                'output' => 7835.0,
                'enforceable' => true,
            ],
            [
                'input' => 0.0,
                'output' => 0.0,
                'enforceable' => true,
            ],
            [
                'input' => 39.5,
                'output' => 39.5,
                'enforceable' => true,
            ],
            [
                'input' => -1.75,
                'output' => -1.75,
                'enforceable' => true,
            ],
            [
                'input' => '0',
                'output' => new TypeError('Value passed to enforce_float does not contain int or float: \'0\''),
                'enforceable' => false,
            ],
            [
                'input' => 'failed',
                'output' => new TypeError('Value passed to enforce_float does not contain int or float: \'failed\''),
                'enforceable' => false,
            ],
            [
                'input' => '',
                'output' => new TypeError('Value passed to enforce_float does not contain int or float: \'\''),
                'enforceable' => false,
            ],
            [
                'input' => true,
                'output' => new TypeError('Value passed to enforce_float does not contain int or float: true'),
                'enforceable' => false,
            ],
            [
                'input' => false,
                'output' => new TypeError('Value passed to enforce_float does not contain int or float: false'),
                'enforceable' => false,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Value passed to enforce_float does not contain int or float:'),
                'enforceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Value passed to enforce_float does not contain int or float: array (' . "\n" . ')'),
                'enforceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Value passed to enforce_float does not contain int or float: (object) array(' . "\n" . ')'),
                'enforceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Value passed to enforce_float does not contain int or float: NULL'),
                'enforceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            try {
                $output = enforce_float($entry['input']);

                if ($entry['enforceable'] === false) {
                    $this->fail('Enforce to float did not throw exception for ' . $entry['input']);
                } else {
                    $this->assertSame($entry['output'] ?? null, $output);
                }
            } catch (TypeError $e) {
                if ($entry['enforceable'] === false) {
                    $expectedError = $entry['output'];
                    $this->assertInstanceOf(TypeError::class, $expectedError);

                    if ($expectedError->getMessage() === 'Value passed to enforce_float does not contain int or float:') {
                        $this->assertStringStartsWith('Value passed to enforce_float does not contain int or float:', $e->getMessage());
                    } else {
                        $this->assertSame($expectedError->getMessage(), $e->getMessage());
                    }
                } else {
                    $this->fail('Enforce to float did throw exception for ' . $entry['input']);
                }
            }
        }
    }

    public function testEnforceToBool(): void
    {
        $values = [
            [
                'input' => 0,
                'output' => new TypeError('Value passed to enforce_bool does not contain bool: 0'),
                'enforceable' => false,
            ],
            [
                'input' => -33,
                'output' => new TypeError('Value passed to enforce_bool does not contain bool: -33'),
                'enforceable' => false,
            ],
            [
                'input' => 7835,
                'output' => new TypeError('Value passed to enforce_bool does not contain bool: 7835'),
                'enforceable' => false,
            ],
            [
                'input' => 0.0,
                'output' => new TypeError('Value passed to enforce_bool does not contain bool: 0.0'),
                'enforceable' => false,
            ],
            [
                'input' => 39.5,
                'output' => new TypeError('Value passed to enforce_bool does not contain bool: 39.5'),
                'enforceable' => false,
            ],
            [
                'input' => -1.75,
                'output' => new TypeError('Value passed to enforce_bool does not contain bool: -1.75'),
                'enforceable' => false,
            ],
            [
                'input' => '0',
                'output' => new TypeError('Value passed to enforce_bool does not contain bool: \'0\''),
                'enforceable' => false,
            ],
            [
                'input' => 'failed',
                'output' => new TypeError('Value passed to enforce_bool does not contain bool: \'failed\''),
                'enforceable' => false,
            ],
            [
                'input' => '',
                'output' => new TypeError('Value passed to enforce_bool does not contain bool: \'\''),
                'enforceable' => false,
            ],
            [
                'input' => true,
                'output' => true,
                'enforceable' => true,
            ],
            [
                'input' => false,
                'output' => false,
                'enforceable' => true,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Value passed to enforce_bool does not contain bool:'),
                'enforceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Value passed to enforce_bool does not contain bool: array (' . "\n" . ')'),
                'enforceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Value passed to enforce_bool does not contain bool: (object) array(' . "\n" . ')'),
                'enforceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Value passed to enforce_bool does not contain bool: NULL'),
                'enforceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            try {
                $output = enforce_bool($entry['input']);

                if ($entry['enforceable'] === false) {
                    $this->fail('Enforce to bool did not throw exception for ' . $entry['input']);
                } else {
                    $this->assertSame($entry['output'] ?? null, $output);
                }
            } catch (TypeError $e) {
                if ($entry['enforceable'] === false) {
                    $expectedError = $entry['output'];
                    $this->assertInstanceOf(TypeError::class, $expectedError);

                    if ($expectedError->getMessage() === 'Value passed to enforce_bool does not contain bool:') {
                        $this->assertStringStartsWith('Value passed to enforce_bool does not contain bool:', $e->getMessage());
                    } else {
                        $this->assertSame($expectedError->getMessage(), $e->getMessage());
                    }
                } else {
                    $this->fail('Enforce to bool did throw exception for ' . $entry['input']);
                }
            }
        }
    }

    public function testEnforceToString(): void
    {
        $values = [
            [
                'input' => 0,
                'output' => new TypeError('Value passed to enforce_string does not contain string: 0'),
                'enforceable' => false,
            ],
            [
                'input' => -33,
                'output' => new TypeError('Value passed to enforce_string does not contain string: -33'),
                'enforceable' => false,
            ],
            [
                'input' => 7835,
                'output' => new TypeError('Value passed to enforce_string does not contain string: 7835'),
                'enforceable' => false,
            ],
            [
                'input' => 0.0,
                'output' => new TypeError('Value passed to enforce_string does not contain string: 0.0'),
                'enforceable' => false,
            ],
            [
                'input' => 39.5,
                'output' => new TypeError('Value passed to enforce_string does not contain string: 39.5'),
                'enforceable' => false,
            ],
            [
                'input' => -1.75,
                'output' => new TypeError('Value passed to enforce_string does not contain string: -1.75'),
                'enforceable' => false,
            ],
            [
                'input' => '0',
                'output' => '0',
                'enforceable' => true,
            ],
            [
                'input' => 'failed',
                'output' => 'failed',
                'enforceable' => true,
            ],
            [
                'input' => '',
                'output' => '',
                'enforceable' => true,
            ],
            [
                'input' => true,
                'output' => new TypeError('Value passed to enforce_string does not contain string: true'),
                'enforceable' => false,
            ],
            [
                'input' => false,
                'output' => new TypeError('Value passed to enforce_string does not contain string: false'),
                'enforceable' => false,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Value passed to enforce_string does not contain string:'),
                'enforceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Value passed to enforce_string does not contain string: array (' . "\n" . ')'),
                'enforceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Value passed to enforce_string does not contain string: (object) array(' . "\n" . ')'),
                'enforceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Value passed to enforce_string does not contain string: NULL'),
                'enforceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            try {
                $output = enforce_string($entry['input']);

                if ($entry['enforceable'] === false) {
                    $this->fail('Enforce to string did not throw exception for ' . $entry['input']);
                } else {
                    $this->assertSame($entry['output'] ?? null, $output);
                }
            } catch (TypeError $e) {
                if ($entry['enforceable'] === false) {
                    $expectedError = $entry['output'];
                    $this->assertInstanceOf(TypeError::class, $expectedError);

                    if ($expectedError->getMessage() === 'Value passed to enforce_string does not contain string:') {
                        $this->assertStringStartsWith('Value passed to enforce_string does not contain string:', $e->getMessage());
                    } else {
                        $this->assertSame($expectedError->getMessage(), $e->getMessage());
                    }
                } else {
                    $this->fail('Enforce to string did throw exception for ' . $entry['input']);
                }
            }
        }
    }
}
