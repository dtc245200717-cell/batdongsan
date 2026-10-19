<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'title', 'type', 'category', 'price', 'area', 'bedrooms',
        'city', 'district', 'address', 'description',
        'contact_name', 'contact_phone',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function getPriceTextAttribute(): string
    {
        $p = (float) $this->price;
        if ($p >= 1000000000) {
            return rtrim(rtrim(number_format($p / 1000000000, 2, ',', '.'), '0'), ',') . ' tỷ';
        }
        $text = rtrim(rtrim(number_format($p / 1000000, 1, ',', '.'), '0'), ',') . ' triệu';
        return $this->type === 'thue' ? $text . '/tháng' : $text;
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'ban' ? 'Bán' : 'Cho thuê';
    }

    public function getCategoryLabelAttribute(): string
    {
        return ['nha' => 'Nhà', 'dat' => 'Đất', 'can-ho' => 'Căn hộ'][$this->category] ?? $this->category;
    }
}
