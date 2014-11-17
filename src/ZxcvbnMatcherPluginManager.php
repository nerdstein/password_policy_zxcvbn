<?php
/**
 * @file
 * Contains Drupal\password_policy_zxcvbn\ZxcvbnMatcherPluginManager.
 */

namespace Drupal\password_policy_zxcvbn;

use Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManager;


class ZxcvbnMatcherPluginManager extends \Drupal\Core\Plugin\DefaultPluginManager {
	/**
	 * Constructs a new ZxcvbnMatcherPluginManager.
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
		parent::__construct('Plugin/ZxcvbnMatcher', $namespaces, $module_handler, 'Drupal\password_policy_zxcvbn\ZxcvbnMatcherInterface', 'Drupal\password_policy_zxcvbn\Annotation\ZxcvbnMatcher');
		$this->alterInfo('password_policy_zcvbn_matcher_info');
		$this->setCacheBackend($cache_backend, 'password_policy_zxcvbn_matcher');
	}

}