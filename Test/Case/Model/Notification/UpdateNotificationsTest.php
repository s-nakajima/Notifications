<?php
/**
 * Notification::updateNotifications()のテスト
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
 * Notification::updateNotifications()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Notifications\Test\Case\Model
 */
class NotificationUpdateNotificationsTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'updateNotifications';

/**
 * updateNotificationsによるテスト
 *
 * @return void
 */
	protected function _getData() {
		$model = $this->_modelName;

		//テスト用データ取得
		$url = App::pluginPath(Inflector::camelize($this->plugin)) . 'Test' . DS . 'Fixture' . DS . 'rss_v2.xml';
		return $this->$model->serialize($url);
	}

/**
 * updateNotificationsによるテスト
 *
 * @return void
 */
	public function testUpdateNotifications() {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト用データ取得
		$data = $this->_getData();

		//テスト実行
		$result = $this->$model->$method(array('Notification' => $data));

		//チェック
		$this->assertTrue($result);

		$count = $this->$model->find('count');
		$this->assertCount($count, $data);
	}

/**
 * データ上書きによるテスト
 *
 * @return void
 */
	public function testUpdateNotificationsByOverwrite() {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//事前テスト
		$this->testUpdateNotifications();

		//テスト用データ取得
		$data = $this->_getData();
		$data = Hash::insert($data, '{n}.title', 'Overwrite content title');

		//テスト実行
		$result = $this->$model->$method(array('Notification' => $data));

		//チェック
		$this->assertTrue($result);

		$count = $this->$model->find('count', array(
			'conditions' => array('Notification.title' => 'Overwrite content title'),
		));
		$this->assertCount($count, $data);
	}

/**
 * エラー用のDataProvider
 *
 * #### 戻り値
 *  - string $mockModel Mockのモデル
 *  - string $mockMethod Mockのメソッド
 *  - bool $exception Exceptionかどうか
 *
 * @return array
 */
	public function dataProviderOnError() {
		$results = array(
			array($this->_modelName, 'validateMany', false),
			array($this->_modelName, 'deleteAll', true),
			array($this->_modelName, 'saveMany', true),
		);
		return $results;
	}

/**
 * updateNotificationsのErrorテスト
 *
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @param bool $exception Exceptionかどうか
 * @dataProvider dataProviderOnError
 * @return void
 */
	public function testUpdateNotificationsOnError($mockModel, $mockMethod, $exception) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		//テスト用データ取得
		$data = $this->_getData();

		//テスト実行
		if ($exception) {
			$this->setExpectedException('InternalErrorException');
		}

		$result = $this->$model->$method(array('Notification' => $data));

		if (! $exception) {
			$this->assertFalse($result);
		}
	}

}
