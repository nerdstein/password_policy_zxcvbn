<?php
/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\ZxcvbnSearcherPluginManager.
 */

namespace Drupal\password_policy_zxcvbn;

use Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManager;


class ZxcvbnSearcherPluginManager extends \Drupal\Core\Plugin\DefaultPluginManager {
	/**
	 * Constructs a new ZxcvbnSearcherPluginManager.
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
		parent::__construct('Plugin/ZxcvbnSearcher', $namespaces, $module_handler, 'Drupal\password_policy_zxcvbn\ZxcvbnSearcherInterface', 'Drupal\password_policy_zxcvbn\Annotation\ZxcvbnSearcher');
		$this->alterInfo('password_policy_zcvbn_searcher_info');
		$this->setCacheBackend($cache_backend, 'password_policy_zxcvbn_searcher');
	}

}