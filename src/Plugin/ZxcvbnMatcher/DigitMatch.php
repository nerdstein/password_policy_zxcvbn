<?php

/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\Plugin\ZxcvbnMatcher\DigitMatch.
 */

namespace Drupal\password_policy_zxcvbn\Plugin\ZxcvbnMatcher;

use Drupal\password_policy_zxcvbn\MatchBase;

/**
 * Matches the use of the same three digits of characters used in passwords.
 *
 * @ZxcvbnMatcher(
 *   id = "password_policy_zxcvbn_digit_match",
 *   title = @Translation("Matching the use of three or more of the same digit in passwords"),
 *   description = @Translation("Identifies the same three digits used within passwords"),
 * )
 */

class DigitMatch extends MatchBase
{

    /**
     * Match occurences of 3 or more digits in a password
     *
     * @copydoc Match::match()
     */
    public static function match($password, array $userInputs = array())
    {
        $matches = array();
        $groups = static::findAll($password, "/(\d{3,})/");
        foreach ($groups as $captures) {
            $matches[] = new static($password, $captures[1]['begin'], $captures[1]['end'], $captures[1]['token']);
        }
        return $matches;
    }

    /**
     * @param $password
     * @param $begin
     * @param $end
     * @param $token
     */
    public function __construct($password, $begin, $end, $token)
    {
        parent::__construct($password, $begin, $end, $token);
        $this->pattern = 'digit';
    }

    /**
     * @return float
     */
    public function getEntropy()
    {
        if (is_null($this->entropy)) {
            $this->entropy = $this->log(pow(10, strlen($this->token)));
        }
        return $this->entropy;
    }
}