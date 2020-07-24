## Hướng dẫn sử dụng Timezone ##
Đây là một package dùng nhỏ dùng để cấu hình lại thời gian của hệ thống. Dữ liệu sẽ được lưu tại bảng `settings` với `key` là `timezone` và `value` là múi giờ VD: Asia/Ho_Chi_minh

### Demo cách hiển thị để chọn tại module Setting ###

	// themes/default/src/Http/Controllers/Admin/SettingController.php
	// $this->models = new \Sudo\Theme\Models\Setting;
    public function general(Request $requests) {
    	...
        if (isset($requests->redirect)) {
            if (isset($requests->timezone) && !empty($requests->timezone)) {
                \Timezone::saveTimezone($requests->timezone);
                unset($requests['timezone']);
            }
        }
        ...
        $form = new Form;
        $timezone = $this->models->where('key', 'timezone')->first();
        $form->select('timezone', $timezone->value ?? config('app.timezone'), 0, 'Múi giờ', \Timezone::ListDataArray());
        ...
    }

- Chúng ta sẽ dùng form select để hiển thị và chọn
- Chúng ta sẽ dùng `\Timezone::saveTimezone($requests->timezone);` để lưu giá trị `timezone` vào bảng `settings`
- Lấy ra sẽ query vào `settings` với `key` là `timezone` để lấy ra giá trị value