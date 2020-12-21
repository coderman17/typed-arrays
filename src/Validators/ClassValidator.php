<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class ClassValidator implements IValidate
{
    /**
     * @var class-string
     */
    private string $className;

    protected ObjectValidator $objectValidator;

    /**
     * @param class-string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;

        $this->objectValidator = new ObjectValidator();
    }

    /**
     * @param mixed $value
     * @throws \Exception
     * @throws \TypeError
     *
     * An object will be passed to get_class, as the object validator would throw otherwise:
     * @psalm-suppress MixedArgument
     */
    public function validate($value): void
    {
        $previous = null;

        try {
            $this->objectValidator->validate($value);
        } catch (\TypeError $e) {
            throw new \TypeError($e->getMessage() . '. The expected class is: ' . $this->className);
        }

        if (get_class($value) !== $this->className) {
            throw new \Exception('Expected an object of class ' . $this->className . ' but received one of class ' . get_class($value), 0, $previous);
        }
    }
}