<?php

namespace EmanueleMinotto\ReservedUsernamesValidator;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class NotReservedValidatorTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->executionContext = $this->createMock(ExecutionContextInterface::class);

        $this->validator = new NotReservedValidator();
        $this->validator->initialize($this->executionContext);
    }

    /**
     * @param string $value
     * @param bool   $expected
     *
     * @dataProvider valuesDataProvider
     */
    public function testValidate($value, $expected)
    {
        $constraint = new NotReserved();

        $this->executionContext
            ->expects($this->exactly($expected ? 1 : 0))
            ->method('addViolation')
            ->with(
                $constraint->message,
                [
                    '%value%' => $value,
                ]
            );

        $this->validator->validate($value, $constraint);
    }

    public static function valuesDataProvider()
    {
        yield [null, null, false];
        yield [null, '', false];
        yield ['my_username', false];

        $values = json_decode(
            file_get_contents(__DIR__.'/../data/reserved-usernames.json'),
            true
        );

        foreach ($values as $value) {
            yield [$value, !empty($value)];
        }
    }
}
