<?php
/**
 * 過去データ用のNotificationFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NotificationFixture', 'Notifications.Test/Fixture');

/**
 * No data用のNotificationFixture
 *
 * @package NetCommons\Notifications\Test\Fixture
 */
class Notification4nodataFixture extends NotificationFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Notification';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'notifications';

/**
 * Records
 *
 * @var array
 */
	public $records = array();

}
