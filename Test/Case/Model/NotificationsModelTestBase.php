<?php
/**
 * Common code for test of Notifications
 *
 * @property Notification $Notification
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('YACakeTestCase', 'NetCommons.TestSuite');
App::uses('Notification', 'Notifications.Model');

/**
 * Common code for test of Notifications
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Notifications\Test\Case\Model
 */
class NotificationsModelTestBase extends YACakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.notifications.notification',
	);

}
