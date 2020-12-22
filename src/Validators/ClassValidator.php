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
     * @inheritDoc
     *
     * @psalm-suppress MixedArgument //An object will be passed to get_class; object validator would throw otherwise
     */
    public function validate($value): void
    {
        $previous = null;

        try {
            $this->objectValidator->validate($value);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException($e->getMessage() . '. The expected class is: ' . $this->className);
        }

        if (get_class($value) !== $this->className) {
            throw new \InvalidArgumentException('Expected an object of class ' . $this->className . ' but received one of class ' . get_class($value), 0, $previous);
        }
    }
}