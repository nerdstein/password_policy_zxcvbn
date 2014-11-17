<?php

namespace Drupal\password_policy_zxcvbn\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class ZxcvbnSettingsForm extends FormBase {


	/**
	 * {@inheritdoc}
	 */
	public function getFormId() {
		return 'zxcvbn_settings_form';
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		$form = array();

		//get policy
		$policy_id = '';
		$path_args = explode('/', current_path());
		if(count($path_args)==7) {
			$policy_id = $path_args[6];
			//load the policy
			$policy = db_select('password_policy_zxcvbn_policies', 'p')->fields('p')->condition('pid', $policy_id)->execute()->fetchObject();
		}

		$form['pid'] = array(
			'#type' => 'hidden',
			'#value' => (is_numeric($policy_id))?$policy_id:'',
		);

		$form['score'] = array(
			'#type' => 'select',
			'#title' => t('Minimum Zxcvbn Score'),
			'#options' => array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4',),
			'#default_value' => (is_numeric($policy_id))?$policy->score:'',
		);

		$form['submit'] = array(
			'#type'=>'submit',
			'#value'=> (is_numeric($policy_id))?'Update Policy':'Add Policy',
		);

		return $form;
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
		//TODO - Why is this not loading in the admin config page?
		if(!is_numeric($form_state->getValue('score')) or $form_state->getValue('score')<0) {
			$form_state->setErrorByName('score', $this->t('The score must be a positive number.'));
		}
		//TODO - Add validation for unique number
	}

	/**
	 * {@inheritdoc}
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		if($form_state->getValue('pid')) {
			db_update('password_policy_zxcvbn_policies')
				->fields(array('score' => $form_state->getValue('score')))
				->condition('pid', $form_state->getValue('pid'))
				->execute();
		} else {
			db_insert('password_policy_zxcvbn_policies')
				->fields(array('score'))
				->values(array('score' => $form_state->getValue('score')))
				->execute();
		}
		drupal_set_message('Zxcvbn policy settings have been stored');
	}
}