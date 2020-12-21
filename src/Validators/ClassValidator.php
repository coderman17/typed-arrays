<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class ClassValidator implements IValidate
{
    private string $className;

    protected ObjectValidator $objectValidator;

    public function __construct(string $className)
    {
        $this->className = $className;

        $this->objectValidator = new ObjectValidator();
    }

    /**
     * @param mixed $value
     * @throws \Exception
     */
    public function validate($value): void
    {
        $previous = null;

        try {
            $this->objectValidator->validate($value);
        } catch (\Throwable $e) {
            throw new \TypeError($e->getMessage() . '. The expected class is: ' . $this->className);
        }

        if (get_class($value) !== $this->className) {
            throw new \Exception('Expected an object of class ' . $this->className . ' but received one of class ' . get_class($value), 0, $previous);
        }
    }
}