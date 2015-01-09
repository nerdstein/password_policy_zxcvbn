<?php

/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\Plugin\ZxcvbnMatcher\Bruteforce.
 */

namespace Drupal\password_policy_zxcvbn\Plugin\ZxcvbnMatcher;

use Drupal\password_policy_zxcvbn\MatchBase;

/**
 * Brute force checking of a password.
 *
 * @ZxcvbnMatcher(
 *   id = "password_policy_zxcvbn_bruteforce_match",
 *   title = @Translation("Brute force checking of a password"),
 *   description = @Translation("Providing a score based on brute force attempts against the password"),
 * )
 */
class Bruteforce extends MatchBase {

  /**
   * @copydoc Match::match()
   */
  public static function match($password, array $userInputs = array()) {
    // Matches entire string.
    $match = new static($password, 0, strlen($password) - 1, $password);
    return array($match);
  }

  /**
   * @param $password
   * @param $begin
   * @param $end
   * @param $token
   * @param $cardinality
   */
  public function __construct($password, $begin, $end, $token, $cardinality = NULL) {
    parent::__construct($password, $begin, $end, $token);
    $this->pattern = 'bruteforce';
    // Cardinality can be injected to support full password cardinality instead of token.
    $this->cardinality = $cardinality;
  }

  /**
   *
   */
  public function getEntropy() {
    if (is_null($this->entropy)) {
      $this->entropy = $this->log(pow($this->getCardinality(), strlen($this->token)));
    }
    return $this->entropy;
  }
}