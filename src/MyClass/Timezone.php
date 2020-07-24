<?php

namespace Sudo\Timezone\MyClass;

use DateTime;
use DateTimeZone;

class Timezone {

	/**
     * Popular timezones
     * @var array
     */
    protected $popularTimezones = [
        'GMT' => 'GMT timezone',
        'UTC' => 'UTC timezone',
    ];

	/**
     * Tất cả châu lục trên thế giới
     * @var array
     */
    protected $continents = [
        'Africa'     => DateTimeZone::AFRICA,
        'America'    => DateTimeZone::AMERICA,
        'Antarctica' => DateTimeZone::ANTARCTICA,
        'Arctic'     => DateTimeZone::ARCTIC,
        'Asia'       => DateTimeZone::ASIA,
        'Atlantic'   => DateTimeZone::ATLANTIC,
        'Australia'  => DateTimeZone::AUSTRALIA,
        'Europe'     => DateTimeZone::EUROPE,
        'Indian'     => DateTimeZone::INDIAN,
        'Pacific'    => DateTimeZone::PACIFIC
    ];

     /**
     * Lấy số mã vùng
     * @return string
     */
    protected function formatTimezone($timezone, $continent)
    {
        $time   = new DateTime(null, new DateTimeZone($timezone));
        $offset = $time->format('P');

        $formatted = '(GMT/UTC '.$offset.')'.' '.$timezone;
        return $formatted;
    }

    /**
	 * Danh sách khu vực và tên tương ứng
     */
	public function ListData() {
		$data = [];

		foreach ($this->popularTimezones as $key => $value) {
            $data['General'][$key]['zone'] = $key;
            $data['General'][$key]['name'] = $value;
        }

		foreach ($this->continents as $continent => $mask) {
			$timezones = DateTimeZone::listIdentifiers($mask);
			foreach ($timezones as $key => $timezone) {
				$data[$continent][$key]['zone'] = $timezone;
				$data[$continent][$key]['name'] = $this->formatTimezone($timezone, $continent);
			}
		}
		return $data;
	}

	/**
	 * Danh sách mã vùng và tên tương ứng
	 */
	public function ListDataArray() {
		$data = [];
		$timezones = $this->ListData();
		foreach ($timezones as $key => $timezone) {
			foreach ($timezone as $item) {
				$data[$item['zone']] = $item['name'];
			}
		}
		return $data;
	}

	// Lưu timezone
	public function saveTimezone($timezone) {
		// Kiểm tra bảng đã tồn tại hay chưa
        if (\Schema::hasTable('settings')) {
    		// Lấy dữ liệu cấu hình mail ra
    		$option = \DB::table('settings')->select('value')->where('key','timezone')->first();
    		if ($option == null) {
    			\DB::table('settings')->insert([ 'key' => 'timezone', 'value' => $timezone ]);
    		} else {
    			\DB::table('settings')->select('value')->where('key','timezone')->update([ 'value' => $timezone ]);
    		}
        }
	}

}