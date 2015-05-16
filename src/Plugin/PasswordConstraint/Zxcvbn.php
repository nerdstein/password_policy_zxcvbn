<?php

/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\Constraints\Zxcvbn.
 */

//TODO - Add in "tokens" into annotations (see: error message, which should show #chars from config)

namespace Drupal\password_policy_zxcvbn\Plugin\PasswordConstraint;

use Drupal\Core\Form\FormStateInterface;
use Drupal\password_policy\PasswordConstraintBase;
use Drupal\password_policy\PasswordPolicyValidation;

/**
 * Enforces a specific character length for passwords.
 *
 * @PasswordConstraint(
 *   id = "password_policy_zxcvbn_constraint",
 *   title = @Translation("Zxcvbn"),
 *   description = @Translation("Zxcvbn-PHP is a password strength estimator using pattern matching and minimum entropy calculation. Scores range from 0 to 4, 4 being the strongest password."),
 *   error_message = @Translation("Your password lacks strength and has too many common patterns."),
 * )
 */
class Zxcvbn extends PasswordConstraintBase {

  /**
   * {@inheritdoc}
   */
  function validate($password) {
    //TODO - get user data from form
    /*
    $userData = array(
      'Marco',
      'marco@example.com'
    );
    $strength = $zxcvbn->passwordStrength($password, $userData);
    */

    $configuration = $this->getConfiguration();
    $validation = new PasswordPolicyValidation();

    $zxcvbn = new \Drupal\password_policy_zxcvbn\Zxcvbn();
    $strength = $zxcvbn->passwordStrength($password);

    if ($strength['score'] < $configuration['zxcvbn_score']) {
      $validation->setErrorMessage($this->t('The password has a score of @password-score but the policy requires a score of at least @policy-score', array('@password-score'=>$strength['score'], '@policy-score'=>$configuration['zxcvbn_score'])));
    }
    return $validation;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'score' => 3,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['zxcvbn_score'] = array(
      '#type' => 'select',
      '#title' => t('Zxcvbn Minimum Score'),
      '#options' => array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4',),
      '#default_value' => $this->getConfiguration()['zxcvbn_score'],
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['zxcvbn_score'] = $form_state->getValue('zxcvbn_score');
  }

  /**
   * {@inheritdoc}
   */
  public function getSummary() {
    return $this->t('Zxcvbn minimum score of @score', array('@score' => $this->configuration['zxcvbn_score']));
  }

}