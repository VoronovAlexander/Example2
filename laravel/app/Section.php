<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    /**
     * Отношение к пользователям
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_section')
            ->withTimestamps();
    }

    /**
     * Гетер для мутации ссылки на логотип отдела
     * 
     * @return string
     */
    public function getLogoAttribute($logo)
    {
        return $logo ? url("storage/public/" . $logo) : "";
    }

    protected $fillable = [
        'name',
        'description',
        'logo',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];
}
