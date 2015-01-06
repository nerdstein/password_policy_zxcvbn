<?php

/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\Constraints\Zxcvbn.
 */

//TODO - Add in "tokens" into annotations (see: error message, which should show #chars from config)

namespace Drupal\password_policy_zxcvbn\Plugin\PasswordConstraint;

use Drupal\password_policy\PasswordConstraintBase;
use Drupal\Core\Config\Config;
use Drupal\password_policy\PasswordPolicyValidation;

/**
 * Enforces a specific character length for passwords.
 *
 * @PasswordConstraint(
 *   id = "password_policy_zxcvbn_constraint",
 *   title = @Translation("Zxcvbn"),
 *   description = @Translation("Zxcvbn-PHP is a password strength estimator using pattern matching and minimum entropy calculation. Scores range from 0 to 4, 4 being the strongest password."),
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
		/*
		$userData = array(
			'Marco',
			'marco@example.com'
		);
		$strength = $zxcvbn->passwordStrength($password, $userData);
		*/

		$zxcvbn = new \Drupal\password_policy_zxcvbn\Zxcvbn();
		$strength = $zxcvbn->passwordStrength($password);

		$policy = db_select('password_policy_zxcvbn_policies', 'p')
			->fields('p')
			->condition('pid', $policy_id)
			->execute()
			->fetchObject();

		$validation = new PasswordPolicyValidation();
		if($strength['score'] < $policy->score ){
			$validation->setErrorMessage('The password has a score of '.$strength['score'].' but the policy requires a score of at least '.$policy->score);
		}
		return $validation;
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

	/**
	 * Deletes the specific policy.
	 * @return boolean
	 */
	public function deletePolicy($policy_id){

		$result = db_delete('password_policy_zxcvbn_policies')
			->condition('pid', $policy_id)
			->execute();

		if($result){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Check the specific policy exists.
	 * @return boolean
	 */
	public function policyExists($policy_id){

		$result = db_select('password_policy_zxcvbn_policies', 'p')
			->fields('p')
			->condition('pid', $policy_id)
			->execute()
		  ->fetchAll();

		if(count($result)>0){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Return the specific policy exists.
	 * @return string
	 */
	public function getPolicy($policy_id){

		$result = db_select('password_policy_zxcvbn_policies', 'p')
			->fields('p')
			->condition('pid', $policy_id)
			->execute()
		  ->fetchAll();

		if(count($result)>0){
			$obj = $result[0];

			return 'Zxcvbn score greater than ' . $obj->score;
		}
		return FALSE;
	}
}