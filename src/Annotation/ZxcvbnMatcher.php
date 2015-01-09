<?php

/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\Annotation\ZxcvbnMatcher.
 */

namespace Drupal\password_policy_zxcvbn\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Zxcvbn matcher annotation object.
 *
 * @Annotation
 */
class ZxcvbnMatcher extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the matcher.
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
