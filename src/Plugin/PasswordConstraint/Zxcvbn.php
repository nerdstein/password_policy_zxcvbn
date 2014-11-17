<?php

/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\Constraints\Zxcvbn.
 */

//TODO - Add in "tokens" into annotations (see: error message, which should show #chars from config)

namespace Drupal\password_policy_zxcvbn\Plugin\PasswordConstraint;

use Drupal\password_policy\PasswordConstraintBase;
use Drupal\Core\Config\Config;

/**
 * Enforces a specific character length for passwords.
 *
 * @PasswordConstraint(
 *   id = "password_policy_zxcvbn_constraint",
 *   title = @Translation("Zxcvbn"),
 *   description = @Translation("Zxcvbn-PHP is a password strength estimator using pattern matching and minimum entropy calculation"),
 *   error_message = @Translation("Your password lacks strength and has too many common patterns."),
 *   policy_path = "admin/config/security/password/constraint/zxcvbn",
 *   policy_update_path = "admin/config/security/password/constraint/zxcvbn/@pid",
 *   policy_update_token = "@pid"
 * )
 */
class Zxcvbn extends PasswordConstraintBase {

	/**
	 * Returns a true/false status as to if the password meets the requirements of the constraint.
	 * @param password
	 *   The password entered by the end user
	 * @return boolean
	 *   Whether or not the password meets the constraint in the plugin.
	 */
	function validate($policy_id, $password) {
		//TODO - get user data from form
		$userData = array(
			'Marco',
			'marco@example.com'
		);

		$zxcvbn = new \Drupal\password_policy_zxcvbn\Zxcvbn();
		$strength = $zxcvbn->passwordStrength('password', $userData);

		$policy = db_select('password_policy_zxcvbn_policies', 'p')
			->fields('p')
			->condition('pid', $policy_id)
			->execute()
			->fetchObject();

		//TODO - check this against the policy
		if($strength['score'] < $policy->score ){
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Returns an array of key value pairs, key is the ID, value is the policy.
	 *
	 * @return array
	 *   List of policies.
	 */
	function getPolicies() {
		$policy = db_select('password_policy_zxcvbn_policies', 'p')
			->fields('p');

		$policies = $policy->execute()->fetchAll();
		$array = array();
		foreach($policies as $policy){
			$array[$policy->pid] = 'Zxcvbn score greater than ' . $policy->score;
		}
		return $array;
	}
}