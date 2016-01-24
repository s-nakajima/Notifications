<?php
/**
 * Notifications Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NotificationsAppModel', 'Notifications.Model');

/**
 * Notification Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Notifications\Model
 */
class Notification extends NotificationsAppModel {

/**
 * Cache time
 *
 * @var string
 */
	const CACHE_TIME = 'PT1H';

/**
 * Max row
 *
 * @var string
 */
	const MAX_ROW = 20;

/**
 * Notification url
 *
 * @var string
 */
	const NOTIFICATION_PING_URL = 'www.netcommons.org';

/**
 * Notification url
 *
 * @var string
 */
	const NOTIFICATION_URL = 'http://www.netcommons.org/index.php?action=whatsnew_view_main_rss&block_id=12&_header=0';

/**
 * PING
 *
 * @param string|null $url pingのURL(テストで使用する)
 * @return mixed fsockopenの結果
 */
	public function ping($url = null) {
		//サイトの生死確認
		$errno = 0;
		$errstr = null;
		if (! $url) {
			$url = self::NOTIFICATION_PING_URL;
		}
		CakeLog::info('Execute ping ' . $url);
		$result = fsockopen($url, 80, $errno, $errstr, 3);
		if (! $result) {
			CakeLog::info('Failure ping ' . $url);
		} else {
			CakeLog::info('Success ping ' . $url);
		}
		return $result;
	}

/**
 * Serialize to array data from xml
 * 後で修正する
 *
 * @param string|null $url XMLのURL(テストで使用する)
 * @return array Xml serialize array data
 */
	public function serializeXmlToArray($url = null) {
		if (! $url) {
			$url = self::NOTIFICATION_URL;
		}
		$xmlData = Xml::toArray(Xml::build($url));

		// rssの種類によってタグ名が異なる
		if (isset($xmlData['feed'])) {
			$items = Hash::get($xmlData, 'feed.entry');
			$dateKey = 'published';
			$linkKey = 'link.@href';
			$summaryKey = 'summary';
		} elseif (Hash::get($xmlData, 'rss.@version') === '2.0') {
			$items = Hash::get($xmlData, 'rss.channel.item');
			$dateKey = 'pubDate';
			$linkKey = 'link';
			$summaryKey = 'description';
		} else {
			$items = Hash::get($xmlData, 'RDF.item');
			$dateKey = 'dc:date';
			$linkKey = 'link';
			$summaryKey = 'description';
		}
		if (! isset($items[0]) && is_array($items)) {
			$items = array($items);
		}

		$data = array();
		foreach ($items as $item) {
			$date = new DateTime($item[$dateKey]);
			$summary = Hash::get($item, $summaryKey);
			$data[] = array(
				'title' => $item['title'],
				'link' => Hash::get($item, $linkKey),
				'summary' => $summary ? strip_tags($summary) : '',
				'last_updated' => $date->format('Y-m-d H:i:s'),
				'key' => Security::hash(Hash::get($item, $linkKey), 'md5')
			);
		}
		return $data;
	}

/**
 * Update notifications
 *
 * @param array $data received post data
 * @return bool true on success, exception on error
 * @throws InternalErrorException
 */
	public function updateNotifications($data) {
		//トランザクションBegin
		$this->begin();

		try {
			//Notificationsのvalidate
			if (! $this->validateNotifications($data['Notification'])) {
				return false;
			}

			//既存データの削除
			$conditions = array_keys(Hash::combine($data['Notification'], '{n}.key'));
			if (! $this->deleteAll(array($this->alias . '.key' => $conditions), true, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Notificationsの登録
			if (! $this->saveMany($data['Notification'], array('validate' => false))) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$this->commit();

		} catch (Exception $ex) {
			$this->rollback($ex);
		}

		return true;
	}

/**
 * Validate notifications
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	public function validateNotifications($data) {
		$this->validateMany($data);
		if ($this->validationErrors) {
			return false;
		}
		return true;
	}

/**
 * Valide cache time
 *
 * @return bool True on valid time, false on no valid
 */
	public function validCacheTime() {
		$date = new DateTime();
		$now = $date->format('Y-m-d H:i:s');

		if (! $notification = $this->find('first', array(
			'recursive' => -1,
			'fields' => 'modified',
			'order' => array('modified' => 'desc'),
		))) {
			return false;
		}

		$date = new DateTime($notification['Notification']['modified']);
		$date->add(new DateInterval(self::CACHE_TIME));
		$modified = $date->format('Y-m-d H:i:s');

		if ($now < $modified) {
			return true;
		}
		return false;
	}

}
