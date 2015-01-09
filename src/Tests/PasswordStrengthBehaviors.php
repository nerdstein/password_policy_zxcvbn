<?php

/**
 * @file
 * Definition of Drupal\password_policy_zxcvbn\Tests\PasswordStrengthBehaviors.
 */

namespace Drupal\password_policy_zxcvbn\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests password strength behaviors from Zxcvbn library.
 *
 * @group password_policy_zxcvbn
 */
class PasswordStrengthBehaviors extends WebTestBase {

  public static $modules = array('password_policy', 'password_policy_zxcvbn');

  /**
   * Test password strength behaviors.
   */
  function testPasswordStrengthBehaviors() {
    global $base_url;

    // Create user with permission to create policy.
    $user1 = $this->drupalCreateUser(array('administer site configuration'));
    $this->drupalLogin($user1);

    // Create new password length policy.
    $edit = array();
    $edit['score'] = '4';
    $this->drupalPostForm('admin/config/security/password-policy/zxcvbn', $edit, t('Add policy'));

    // Get latest ID to get policy.
    $id = db_select("password_policy_zxcvbn_policies", 'p')
      ->fields('p', array('pid'))
      ->orderBy('p.pid', 'DESC')
      ->execute()
      ->fetchObject();

    // Create user with policy applied.
    $user2 = $this->drupalCreateUser(array('enforce password_policy_zxcvbn_constraint.' . $id->pid . ' constraint'));
    $uid = $user2->id();

    // Login.
    $this->drupalLogin($user2);

    // Change own password with one not very complex.
    $edit = array();
    $edit['pass'] = '1';
    $edit['current_pass'] = $user2->pass_raw;
    $this->drupalPostAjaxForm("user/" . $uid . "/edit", $edit, 'pass');

    // Verify we see an error.
    $this->assertText('Fail - The password has a score of 0 but the policy requires a score of at least 4');

    // Change own password with one strong enough.
    $edit = array();
    $edit['pass'] = 'aV3ryC*mplexPassword1nd33d!';
    $edit['current_pass'] = $user2->pass_raw;
    $this->drupalPostAjaxForm("user/" . $uid . "/edit", $edit, 'pass');

    // Verify we see do not error.
    $this->assertNoText('Fail - The password has a score of 0 but the policy requires a score of at least 4');


    $this->drupalLogout();
  }
}
