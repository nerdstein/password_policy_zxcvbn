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

			$plugin_manager = \Drupal::service('plugin.manager.password_policy_zxcvbn.zxcvbn_matcher');
			$all_plugins = $plugin_manager->getDefinitions();



			$all_matchers = array();
			foreach($all_plugins as $plugin){
				$all_matchers[] = $plugin['class'];
			}

			return $all_matchers;



        //TODO - Put this in a config form
        return array(
            'Drupal\password_policy_zxcvbn\Plugin\ZxcvbnMatcher\DateMatch',
            'Drupal\password_policy_zxcvbn\Plugin\ZxcvbnMatcher\DigitMatch',
            'Drupal\password_policy_zxcvbn\Plugin\ZxcvbnMatcher\RepeatMatch',
            'Drupal\password_policy_zxcvbn\Plugin\ZxcvbnMatcher\SequenceMatch',
            'Drupal\password_policy_zxcvbn\Plugin\ZxcvbnMatcher\SpatialMatch',
            'Drupal\password_policy_zxcvbn\Plugin\ZxcvbnMatcher\YearMatch',
            'Drupal\password_policy_zxcvbn\Plugin\ZxcvbnMatcher\DictionaryMatch',
					  'Drupal\password_policy_zxcvbn\Plugin\ZxcvbnMatcher\L33tMatch',
        );
    }
}