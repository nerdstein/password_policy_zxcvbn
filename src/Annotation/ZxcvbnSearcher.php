<?php

/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\Annotation\ZxcvbnSearcher.
 */

namespace Drupal\password_policy_zxcvbn\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Zxcvbn searcher annotation object.
 *
 * @Annotation
 */
class ZxcvbnSearcher extends Plugin {

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

}
