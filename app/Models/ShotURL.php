<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @var string long_uri
 * @var string short_url
 */

class ShotURL extends Model
{
    protected $table = 'links';

    protected $fillable = [
        'long_url', 'short_url'
    ];

    public static function getLinkByCode($url)
    {
        return self::where('short_url', $url)->first();
    }

    public static function checkUrlInDB($url) :bool
    {
        return (self::where('long_url', $url)->get()->count()) > 0 ? true : false ;
    }

    public static function getShortLinkItem($url)
    {
        return self::where('long_url', $url)->first();
    }
}
