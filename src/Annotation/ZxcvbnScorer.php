<?php

/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\Annotation\ZxcvbnScorer.
 */

namespace Drupal\password_policy_zxcvbn\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Zxcvbn scorer annotation object.
 *
 * @Annotation
 */
class ZxcvbnScorer extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the scorer.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $title;

  /**
   * The description shown to users.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $description;

  //TODO - Add in min and max score, tie this into the form

}
