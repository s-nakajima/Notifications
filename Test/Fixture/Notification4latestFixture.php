<?php
/**
 * 最新データ用のNotificationFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Notification4previousFixture', 'Notifications.Test/Fixture');

/**
 * 最新データ用のNotificationFixture
 *
 * @package NetCommons\Notifications\Test\Fixture
 * @codeCoverageIgnore
 */
class Notification4latestFixture extends Notification4previousFixture {

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
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		foreach (array_keys($this->records) as $i) {
			$this->records[$i]['modified'] = date('Y-m-d H:i:s');
		}
		parent::init();
	}

}
