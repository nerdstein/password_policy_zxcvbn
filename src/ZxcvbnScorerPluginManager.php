<?php
/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\ZxcvbnScorerPluginManager.
 */

namespace Drupal\password_policy_zxcvbn;

use Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManager;


class ZxcvbnScorerPluginManager extends \Drupal\Core\Plugin\DefaultPluginManager {
	/**
	 * Constructs a new ZxcvbnScorerPluginManager.
	 *
	 * @param \Traversable $namespaces
	 *   An object that implements \Traversable which contains the root paths
	 *   keyed by the corresponding namespace to look for plugin implementations.
	 * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
	 *   Cache backend instance to use.
	 * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
	 *   The module handler.
	 */
	public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
		parent::__construct('Plugin/ZxcvbnScorer', $namespaces, $module_handler, 'Drupal\password_policy_zxcvbn\ZxcvbnScorerInterface', 'Drupal\password_policy_zxcvbn\Annotation\ZxcvbnScorer');
		$this->alterInfo('password_policy_zcvbn_scorer_info');
		$this->setCacheBackend($cache_backend, 'password_policy_zxcvbn_scorer');
	}

}