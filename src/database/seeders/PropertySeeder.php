<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['Nhà phố 4 tầng mặt ngõ Cầu Giấy', 'ban', 'nha', 8500000000, 55, 4, 'Hà Nội', 'Cầu Giấy'],
            ['Căn hộ chung cư 2 phòng ngủ Times City', 'ban', 'can-ho', 3200000000, 70, 2, 'Hà Nội', 'Hai Bà Trưng'],
            ['Đất nền thổ cư 100m2 Hòa Lạc', 'ban', 'dat', 2100000000, 100, null, 'Hà Nội', 'Thạch Thất'],
            ['Cho thuê căn hộ studio Mỹ Đình', 'thue', 'can-ho', 9000000, 35, 1, 'Hà Nội', 'Nam Từ Liêm'],
            ['Cho thuê nhà nguyên căn 3 tầng Đống Đa', 'thue', 'nha', 25000000, 60, 3, 'Hà Nội', 'Đống Đa'],
            ['Bán nhà cấp 4 gần biển Sơn Trà', 'ban', 'nha', 4800000000, 90, 3, 'Đà Nẵng', 'Sơn Trà'],
            ['Đất mặt tiền đường lớn Thủ Đức', 'ban', 'dat', 12000000000, 150, null, 'TP. Hồ Chí Minh', 'Thủ Đức'],
            ['Cho thuê căn hộ 3 phòng ngủ Quận 7', 'thue', 'can-ho', 18000000, 95, 3, 'TP. Hồ Chí Minh', 'Quận 7'],
        ];

        foreach ($rows as $r) {
            Property::create([
                'title' => $r[0], 'type' => $r[1], 'category' => $r[2],
                'price' => $r[3], 'area' => $r[4], 'bedrooms' => $r[5],
                'city' => $r[6], 'district' => $r[7],
                'address' => 'Liên hệ để biết địa chỉ chi tiết',
                'description' => 'Tin mẫu phục vụ demo. Vị trí thuận tiện, pháp lý rõ ràng, liên hệ trực tiếp để xem nhà.',
                'contact_name' => 'Nguyễn Văn A',
                'contact_phone' => '0900000000',
            ]);
        }
    }
}
