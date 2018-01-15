<?php

namespace June\Framework;

/**
 * Returns whether the given $haystack ends with the given $needle.
 */
function ends_with(string $haystack, string $needle): bool
{
    return substr($haystack, -strlen($needle)) === $needle;
}

/**
 * Returns a string with parameters replaced by corresponding keys from $params.
 * 
 * Parameters take the format of "%param".
 */
function parameterise_string(string $message, array $params): string
{
    $parameterised = $message;

    foreach ($params as $param => $value) {
        $parameterised = str_replace('%' . $param, $value, $parameterised);
    }

    return $parameterised;
}

/**
 * Returns whether the given $haystack starts with the given $needle.
 */
function starts_with(string $haystack, string $needle): bool
{
    return substr($haystack, 0, strlen($needle)) === $needle;
}
