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
 * 過去データ用のNotificationFixture
 *
 * @package NetCommons\Notifications\Test\Fixture
 */
class Notification4previousFixture extends NotificationFixture {

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
	public $records = array(
		array(
			'id' => 1,
			'key' => 'Lorem ipsum dolor sit amet',
			'title' => 'Lorem ipsum dolor sit amet',
			'summary' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'link' => 'Lorem ipsum dolor sit amet',
			'last_updated' => '2015-07-22 05:01:52',
			'created_user' => 1,
			'created' => '2015-07-22 05:01:52',
			'modified_user' => 1,
			'modified' => '2015-07-22 05:01:52'
		),
	);

}
