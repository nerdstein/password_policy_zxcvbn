<?php

/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\SearcherBase.
 */

namespace Drupal\password_policy_zxcvbn;

use Drupal\Component\Plugin\PluginBase;

class SearcherBase extends PluginBase implements ZxcvbnSearcherInterface {

  /**
   * @var
   */
  public $matchSequence;

  /**
   * Calculate the minimum entropy for a password and its matches.
   *
   * @param string $password
   *   Password.
   * @param array $matches
   *   Array of Match objects on the password.
   *
   * @return float
   *   Minimum entropy for non-overlapping best matches of a password.
   */
  public function getMinimumEntropy($password, $matches) {
    return 0;
  }
}