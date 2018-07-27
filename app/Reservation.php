<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Jobs\SaveToElastic;

use Elasticquent\ElasticquentTrait;

class Reservation extends Model
{
    use ElasticquentTrait;

    protected $fillable = ['fullname', 'store', 'store', 'reservation_time', 'persons'];

    protected static function boot()
    {
        parent::boot();

        static::created(function($reservation) {
            SaveToElastic::dispatch($reservation);
        });
    }
}
