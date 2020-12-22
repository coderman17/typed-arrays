<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class NonCastedStringValidator implements IValidate
{
    protected StringValidator $stringValidator;

    public function __construct()
    {
        $this->stringValidator = new StringValidator();
    }

    /**
     * @inheritDoc
     *
     * @psalm-suppress MixedArgument //A string will be passed to get_class, otherwise the string validator would throw
     */
    public function validate($value): void
    {
        $this->stringValidator->validate($value);

        if (!$this->checkForKeyCasting($value)){
            throw new \InvalidArgumentException('PHP was about to silently cast the key "' . $value . '" to an integer, an exception was thrown instead');
        }
    }

    private function checkForKeyCasting(string $key): bool
    {
        preg_match('/^[1-9][0-9]+|^[0-9]|^[-][1-9][0-9]*$/', $key, $matches);

        if (!isset($matches[0])) {
            return true;
        }

        if ($matches[0] === $key) {
            return false;
        }

        return true;
    }
}