<?php

namespace Squirrel\Coercions\Tests;

use TypeError;

class CoerceTest extends \PHPUnit\Framework\TestCase
{
    protected $phpunitErrorHandler = null;
    protected $listOfDeprecations = [];

    protected function allowDeprecations(): void
    {
        $this->phpunitErrorHandler = \set_error_handler(function (int $severity, string $message, string $filepath, int $line): bool {
            if ($severity === E_USER_DEPRECATED) {
                $this->listOfDeprecations[] = $message;
            } else {
                return ($this->phpunitErrorHandler)($severity, $message, $filepath, $line);
            }

            return true;
        });
    }

    protected function getDeprecationList(): array
    {
        return $this->listOfDeprecations;
    }

    protected function tearDown(): void
    {
        if ($this->phpunitErrorHandler !== null) {
            \restore_error_handler();
        }

        parent::tearDown();
    }

    public function testCoerceToInt(): void
    {
        $values = [
            [
                'input' => '0',
                'output' => 0,
                'coerceable' => true,
            ],
            [
                'input' => 0.0,
                'output' => 0,
                'coerceable' => true,
            ],
            [
                'input' => 'failed',
                'output' => new TypeError('Non-numeric value "failed" cannot be coerced to int'),
                'coerceable' => false,
            ],
            [
                'input' => '39hello',
                'output' => new TypeError('Non-numeric value "39hello" cannot be coerced to int'),
                'coerceable' => false,
            ],
            [
                'input' => '33.0',
                'output' => 33,
                'coerceable' => true,
            ],
            [
                'input' => true,
                'output' => 1,
                'coerceable' => true,
            ],
            [
                'input' => false,
                'output' => 0,
                'coerceable' => true,
            ],
            [
                'input' => '',
                'output' => new TypeError('Non-numeric value "" cannot be coerced to int'),
                'coerceable' => false,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Non-scalar type object cannot be coerced to int'),
                'coerceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Non-scalar type array cannot be coerced to int'),
                'coerceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Non-scalar type object cannot be coerced to int'),
                'coerceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Non-scalar type NULL cannot be coerced to int'),
                'coerceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            $this->assertSame($entry['coerceable'], is_coerceable_to_int($entry['input']));

            if ($entry['coerceable'] === false) {
                try {
                    coerce_to_int($entry['input']);

                    $this->fail('Coercion to int did not throw TypeError for ' . $entry['input']);
                } catch (TypeError $e) {
                    $expectedError = $entry['output'];
                    $this->assertInstanceOf(TypeError::class, $expectedError);
                    $this->assertSame($expectedError->getMessage(), $e->getMessage());
                }
            } else {
                $this->assertSame($entry['output'], coerce_to_int($entry['input']));
            }
        }
    }

    public function testCoerceToIntDeprecation(): void
    {
        $this->allowDeprecations();

        $this->assertSame(false, is_coerceable_to_int(39.5));
        $this->assertSame(39, coerce_to_int(39.5));

        $deprecationList = $this->getDeprecationList();

        $this->assertCount(1, $deprecationList);
        $this->assertSame(
            'Float with fractional part cannot be coerced to int without information loss: 39.5',
            $deprecationList[0]
        );
    }

    public function testCoerceToFloat(): void
    {
        $values = [
            [
                'input' => '0',
                'output' => 0.0,
                'coerceable' => true,
            ],
            [
                'input' => 0.0,
                'output' => 0.0,
                'coerceable' => true,
            ],
            [
                'input' => 39.5,
                'output' => 39.5,
                'coerceable' => true,
            ],
            [
                'input' => 'failed',
                'output' => new TypeError('Non-numeric value "failed" cannot be coerced to float'),
                'coerceable' => false,
            ],
            [
                'input' => '39hello',
                'output' => new TypeError('Non-numeric value "39hello" cannot be coerced to float'),
                'coerceable' => false,
            ],
            [
                'input' => '33.0',
                'output' => 33.0,
                'coerceable' => true,
            ],
            [
                'input' => true,
                'output' => 1.0,
                'coerceable' => true,
            ],
            [
                'input' => false,
                'output' => 0.0,
                'coerceable' => true,
            ],
            [
                'input' => 13,
                'output' => 13.0,
                'coerceable' => true,
            ],
            [
                'input' => -55,
                'output' => -55.0,
                'coerceable' => true,
            ],
            [
                'input' => '',
                'output' => new TypeError('Non-numeric value "" cannot be coerced to float'),
                'coerceable' => false,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Non-scalar type object cannot be coerced to float'),
                'coerceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Non-scalar type array cannot be coerced to float'),
                'coerceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Non-scalar type object cannot be coerced to float'),
                'coerceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Non-scalar type NULL cannot be coerced to float'),
                'coerceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            $this->assertSame($entry['coerceable'], is_coerceable_to_float($entry['input']), 'Is coerceable is unexpectedly ' . ( $entry['coerceable'] ? 'false' : 'true' ) . ' for ' . \var_export($entry['input'], true));

            if ($entry['coerceable'] === false) {
                try {
                    coerce_to_float($entry['input']);

                    $this->fail('Coercion to int did not throw TypeError for ' . $entry['input']);
                } catch (TypeError $e) {
                    $expectedError = $entry['output'];
                    $this->assertInstanceOf(TypeError::class, $expectedError);
                    $this->assertSame($expectedError->getMessage(), $e->getMessage());
                }
            } else {
                $this->assertSame($entry['output'], coerce_to_float($entry['input']));
            }
        }
    }

    public function testCoerceToString(): void
    {
        $values = [
            [
                'input' => '0',
                'output' => '0',
                'coerceable' => true,
            ],
            [
                'input' => 0.0,
                'output' => '0',
                'coerceable' => true,
            ],
            [
                'input' => 39.5,
                'output' => '39.5',
                'coerceable' => true,
            ],
            [
                'input' => 'failed',
                'output' => 'failed',
                'coerceable' => true,
            ],
            [
                'input' => '39hello',
                'output' => '39hello',
                'coerceable' => true,
            ],
            [
                'input' => '33.0',
                'output' => '33.0',
                'coerceable' => true,
            ],
            [
                'input' => true,
                'output' => '1',
                'coerceable' => true,
            ],
            [
                'input' => false,
                'output' => '',
                'coerceable' => true,
            ],
            [
                'input' => 13,
                'output' => '13',
                'coerceable' => true,
            ],
            [
                'input' => -55,
                'output' => '-55',
                'coerceable' => true,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => 'amazing',
                'coerceable' => true,
            ],
            [
                'input' => [],
                'output' => new TypeError('Non-scalar type array cannot be coerced to string'),
                'coerceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Non-scalar type object cannot be coerced to string'),
                'coerceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Non-scalar type NULL cannot be coerced to string'),
                'coerceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            $this->assertSame($entry['coerceable'], is_coerceable_to_string($entry['input']), 'Is coerceable is unexpectedly ' . ( $entry['coerceable'] ? 'false' : 'true' ) . ' for ' . \var_export($entry['input'], true));

            if ($entry['coerceable'] === false) {
                try {
                    coerce_to_string($entry['input']);

                    $this->fail('Coercion to int did not throw TypeError for ' . $entry['input']);
                } catch (TypeError $e) {
                    $expectedError = $entry['output'];
                    $this->assertInstanceOf(TypeError::class, $expectedError);
                    $this->assertSame($expectedError->getMessage(), $e->getMessage());
                }
            } else {
                $this->assertSame($entry['output'], coerce_to_string($entry['input']));
            }
        }
    }

    public function testCoerceToBool(): void
    {
        $values = [
            [
                'input' => '0',
                'output' => false,
                'coerceable' => true,
            ],
            [
                'input' => 0.0,
                'output' => false,
                'coerceable' => true,
            ],
            [
                'input' => 1.0,
                'output' => true,
                'coerceable' => true,
            ],
            [
                'input' => true,
                'output' => true,
                'coerceable' => true,
            ],
            [
                'input' => false,
                'output' => false,
                'coerceable' => true,
            ],
            [
                'input' => 0,
                'output' => false,
                'coerceable' => true,
            ],
            [
                'input' => 1,
                'output' => true,
                'coerceable' => true,
            ],
            [
                'input' => '1',
                'output' => true,
                'coerceable' => true,
            ],
            [
                'input' => '',
                'output' => false,
                'coerceable' => true,
            ],
            [
                'input' => new class {
                    public function __toString()
                    {
                        return 'amazing';
                    }
                },
                'output' => new TypeError('Non-scalar type object cannot be coerced to bool'),
                'coerceable' => false,
            ],
            [
                'input' => [],
                'output' => new TypeError('Non-scalar type array cannot be coerced to bool'),
                'coerceable' => false,
            ],
            [
                'input' => (object)[],
                'output' => new TypeError('Non-scalar type object cannot be coerced to bool'),
                'coerceable' => false,
            ],
            [
                'input' => null,
                'output' => new TypeError('Non-scalar type NULL cannot be coerced to bool'),
                'coerceable' => false,
            ],
        ];

        foreach ($values as $entry) {
            $this->assertSame($entry['coerceable'], is_coerceable_to_bool($entry['input']), 'Is coerceable is unexpectedly ' . ( $entry['coerceable'] ? 'false' : 'true' ) . ' for ' . \var_export($entry['input'], true));

            if ($entry['coerceable'] === false) {
                try {
                    coerce_to_bool($entry['input']);

                    $this->fail('Coercion to int did not throw TypeError for ' . $entry['input']);
                } catch (TypeError $e) {
                    $expectedError = $entry['output'];
                    $this->assertInstanceOf(TypeError::class, $expectedError);
                    $this->assertSame($expectedError->getMessage(), $e->getMessage());
                }
            } else {
                $this->assertSame($entry['output'], coerce_to_bool($entry['input']));
            }
        }
    }

    public function testCoerceToBoolDeprecationFloat(): void
    {
        $this->allowDeprecations();

        $this->assertSame(false, is_coerceable_to_bool(39.5));
        $this->assertSame(true, coerce_to_bool(39.5));

        $deprecationList = $this->getDeprecationList();

        $this->assertCount(1, $deprecationList);
        $this->assertSame(
            'Implicit conversion from float 39.5 to true, only 0 and 1 are allowed',
            $deprecationList[0]
        );
    }

    public function testCoerceToBoolDeprecationInt(): void
    {
        $this->allowDeprecations();

        $this->assertSame(false, is_coerceable_to_bool(-33));
        $this->assertSame(true, coerce_to_bool(-33));

        $deprecationList = $this->getDeprecationList();

        $this->assertCount(1, $deprecationList);
        $this->assertSame(
            'Implicit conversion from int -33 to true, only 0 and 1 are allowed',
            $deprecationList[0]
        );
    }

    public function testCoerceToBoolDeprecationString(): void
    {
        $this->allowDeprecations();

        $this->assertSame(false, is_coerceable_to_bool('failed'));
        $this->assertSame(true, coerce_to_bool('failed'));

        $deprecationList = $this->getDeprecationList();

        $this->assertCount(1, $deprecationList);
        $this->assertSame(
            'Implicit conversion from string "failed" to true, only "", "0" and "1" are allowed',
            $deprecationList[0]
        );
    }

    public function testCoerceToBoolDeprecationNumericString(): void
    {
        $this->allowDeprecations();

        $this->assertSame(false, is_coerceable_to_bool('33.0'));
        $this->assertSame(true, coerce_to_bool('33.0'));

        $deprecationList = $this->getDeprecationList();

        $this->assertCount(1, $deprecationList);
        $this->assertSame(
            'Implicit conversion from string "33.0" to true, only "", "0" and "1" are allowed',
            $deprecationList[0]
        );
    }
}
