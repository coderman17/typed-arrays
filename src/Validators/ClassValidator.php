<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class ClassValidator implements ValidatorInterface
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
        try {
            $this->objectValidator->validate($value);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException($e->getMessage() . '. The expected object class is: "' . $this->className . '"');
        }

        if (get_class($value) !== $this->className) {
            throw new \InvalidArgumentException('Expected an object of class "' . $this->className . '" but received one of class "' . get_class($value) . '"');
        }
    }
}