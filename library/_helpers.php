<?php

namespace June\Framework;

function starts_with(string $haystack, string $needle): bool
{
    return substr($haystack, 0, strlen($needle)) === $needle;
}

function ends_with(string $haystack, string $needle): bool
{
    return substr($haystack, -strlen($needle)) === $needle;
}

function parameterise_string(string $message, array $params): string
{
    $parameterised = $message;

    foreach ($params as $param => $value) {
        $parameterised = str_replace('%' . $param, $value, $parameterised);
    }

    return $parameterised;
}
