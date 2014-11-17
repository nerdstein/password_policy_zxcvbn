<?php

/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\Matcher.
 */

namespace Drupal\password_policy_zxcvbn;

use Drupal\password_policy_zxcvbn\Matchers\MatchInterface;

class Matcher
{

    /**
     * Get matches for a password.
     *
     * @param string $password
     *   Password string to match.
     * @param array $userInputs
     *   Array of values related to the user (optional).
     * @code
     *   array('Alice Smith')
     * @endcode
     * @return array
     *   Array of Match objects.
     */
    public function getMatches($password, array $userInputs = array())
    {
        $matches = array();
        foreach ($this->getMatchers() as $matcher) {
            $matched = $matcher::match($password, $userInputs);
            if (is_array($matched) && !empty($matched)) {
                $matches = array_merge($matches, $matched);
            }
        }
        return $matches;
    }

    /**
     * Load available Match objects to match against a password.
     *
     * @return array
     *   Array of classes implementing MatchInterface
     */
    protected function getMatchers()
    {
        //TODO - Put this in a config form
        return array(
            'Drupal\password_policy_zxcvbn\Matchers\DateMatch',
            'Drupal\password_policy_zxcvbn\Matchers\DigitMatch',
            'Drupal\password_policy_zxcvbn\Matchers\L33tMatch',
            'Drupal\password_policy_zxcvbn\Matchers\RepeatMatch',
            'Drupal\password_policy_zxcvbn\Matchers\SequenceMatch',
            'Drupal\password_policy_zxcvbn\Matchers\SpatialMatch',
            'Drupal\password_policy_zxcvbn\Matchers\YearMatch',
            'Drupal\password_policy_zxcvbn\Matchers\DictionaryMatch',
        );
    }
}