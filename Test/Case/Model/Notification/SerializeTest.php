<?php
/**
 * Notification::serialize()のテスト
 *
 * @property Notification $Notification
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * Notification::serialize()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Notifications\Test\Case\Model
 */
class NotificationSerializeTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.notifications.notification',
	);

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'notifications';

/**
 * Model name
 *
 * @var array
 */
	protected $_modelName = 'Notification';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'serialize';

/**
 * Notification::NOTIFICATION_URL(www.netcommons.org)によるテスト
 *
 * @return void
 */
	public function testSerialize() {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method();

		//チェック
		$this->assertTrue(count($result) > 0);
	}

/**
 * RSS Atomによるテスト
 *
 * @return void
 */
	public function testSerializeRssAtom() {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$url = App::pluginPath(Inflector::camelize($this->plugin)) . 'Test' . DS . 'Fixture' . DS . 'rss_atom.xml';
		$result = $this->$model->$method($url);

		//チェック
		$this->assertCount(1, $result);
	}

/**
 * RSS 1.0によるテスト
 *
 * @return void
 */
	public function testSerializeRssV1() {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$url = App::pluginPath(Inflector::camelize($this->plugin)) . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';
		$result = $this->$model->$method($url);

		//チェック
		$this->assertCount(1, $result);
	}

/**
 * RSS 2.0によるテスト
 *
 * @return void
 */
	public function testSerializeRssV2() {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$url = App::pluginPath(Inflector::camelize($this->plugin)) . 'Test' . DS . 'Fixture' . DS . 'rss_v2.xml';
		$result = $this->$model->$method($url);

		//チェック
		$this->assertCount(2, $result);
	}

}
