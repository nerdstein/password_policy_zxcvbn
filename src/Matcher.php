<?php

/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\Matcher.
 */

namespace Drupal\password_policy_zxcvbn;

use Drupal\password_policy_zxcvbn\ZxcvbnMatcherInterface;

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

			$config = \Drupal::config('password_policy_zxcvbn.settings');
			$all_matchers = array_values($config->get('matchers'));

			for($i=(count($all_matchers)-1); $i>=0; $i--){
				if(!$all_matchers[$i]){
					unset($all_matchers[$i]);
				}
			}

			return $all_matchers;

    }
}