<?php

/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\ZxcvbnMatcherInterface.
 */

namespace Drupal\password_policy_zxcvbn;

interface ZxcvbnMatcherInterface
{

    /**
     * Match this password.
     *
     * @param string $password
     *   Password to check for match.
     * @param array $userInputs
     *   Array of values related to the user (optional).
     * @code
     *   array('Alice Smith')
     * @endcode
     * @return array
     *   Array of Match objects
     */
    public static function match($password, array $userInputs = array());

    /**
     * Get entropy for this match's token.
     *
     * @return float
     *   Entropy of the matched token in the password.
     */
    public function getEntropy();
}