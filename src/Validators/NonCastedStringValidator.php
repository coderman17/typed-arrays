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
     * @param mixed $value
     * @throws \Exception
     * @throws \TypeError
     */
    public function validate($value): void
    {
        $this->stringValidator->validate($value);

        if (!$this->checkForKeyCasting($value)){
            throw new \Exception('PHP was about to silently cast the key "' . $value . '" to an integer, an exception was thrown instead');
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