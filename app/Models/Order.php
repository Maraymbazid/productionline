<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order extends Model
{
    use HasFactory;
    public const PENDING = 0;
    public const DONE = 1;
    public const STATUS_ALL = 2;
    public const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::PENDING    => 'معلق',
        self::DONE       => 'اكتمل',
    ];

    protected $table = 'orders';


    protected $fillable = [
        'user_id',
        'code',
        'status',
        'order_id'
    ];




    public function getStatusLabelAttribute()
    {
        return self::STATUS_ARR[$this->status];
    }

    public static function generateUniqueInvoiceId()
    {
        $order_id = mb_strtoupper(Str::random(8));
        while (true) {
            $isExist = self::whereOrderId($order_id)->exists();
            if ($isExist) {
                self::generateUniqueInvoiceId();
            }
            break;
        }

        return $order_id;
    }

    public function Name()
    {

        return $this->belongsTo(User::class, 'user_id');
    }
}
