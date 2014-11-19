<?php

namespace Drupal\password_policy_zxcvbn\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class ZxcvbnSettingsForm extends ConfigFormBase {


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
		$config = $this->config('password_policy_zxcvbn.settings');
		$form = array();

		//matchers
		$plugin_manager = \Drupal::service('plugin.manager.password_policy_zxcvbn.zxcvbn_matcher');
		$all_plugins = $plugin_manager->getDefinitions();

		$all_matchers = array();
		foreach($all_plugins as $plugin){
			$class = $plugin['class'];
			$all_matchers[$class] = $plugin['title'];
		}

		$form['matchers'] = array(
			'#title' => 'Matchers',
			'#type' => 'checkboxes',
			'#options' => $all_matchers,
			'#default_value' => $config->get('matchers'),
			'#required' => TRUE,
		);

		//searcher
		$plugin_manager = \Drupal::service('plugin.manager.password_policy_zxcvbn.zxcvbn_searcher');
		$all_plugins = $plugin_manager->getDefinitions();

		$all_searchers = array();
		foreach($all_plugins as $plugin){
			$class = $plugin['class'];
			$all_searchers[$class] = $plugin['title'];
		}

		$form['searcher'] = array(
			'#title' => 'Searcher',
			'#type' => 'select',
			'#options' => $all_searchers,
			'#default_value' => $config->get('searcher'),
			//'#required' => TRUE,
		);

		//scorer
		$plugin_manager = \Drupal::service('plugin.manager.password_policy_zxcvbn.zxcvbn_scorer');
		$all_plugins = $plugin_manager->getDefinitions();

		$all_scorers = array();
		foreach($all_plugins as $plugin){
			$class = $plugin['class'];
			$all_scorers[$class] = $plugin['title'];
		}

		$form['scorer'] = array(
			'#title' => 'Scorer',
			'#type' => 'select',
			'#options' => $all_scorers,
			'#default_value' => $config->get('scorer'),
			'#required' => TRUE,
		);

		return parent::buildForm($form, $form_state);
	}

	/**
	 * {@inheritdoc}
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->config('password_policy_zxcvbn.settings')
			->set('matchers', $form_state->getValue('matchers'))
			->set('matchers', $form_state->getValue('matchers'))
			->save();
		drupal_set_message('Zxcvbn policy settings have been stored');
		parent::submitForm($form, $form_state);
	}
}