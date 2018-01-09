<?php

namespace June\Framework\Exceptions;

use function June\Framework\parameterise_string;

/**
 * A BadUserException is thrown when the testing setup has been mis-configured
 * by the user.
 * 
 * The constants contained in the reasons region provide pre-configured messages
 * that can help the user more quickly identify what they've done wrong, rather
 * than blankly stare at their code for a while.
 * 
 * These reason constants contain parameters, such as '%name', which can be
 * replaced when creating the exception instance.
 */
class BadUserException extends \RuntimeException
{
    //region Reasons

    const UNKNOWN_ASSERTION = 'Tried to inject unknown assertion "%name"';
    
    //endregion

    /**
     * Returns a new BadUserException instance with the configured reason.
     * 
     * $reason is expected to be one of the pre-configured reason constants.
     * 
     * $params is expected to be a <string, value>[] of parameterss that can
     *  be replaced in the $reason string.
     */
    public static function new(string $reason, array $params): BadUserException
    {
        return new static(parameterise_string($reason, $params));
    }
}
