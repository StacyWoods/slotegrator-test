<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Win
 *
 * @property int $id
 * @property int $value
 * @property int $status_id
 * @property int $user_id
 * @property int $type_prize_id
 * @property int $goods_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @property-read Goods $goods
 * @property-read TypePrize $typePrize
 * @property-read Status $status
 * @method static Builder|Win query()
 * @method static Builder|Win whereId($value)
 * @method static Builder|Win whereValue($value)
 * @method static Builder|Win whereStatusId($value)
 * @method static Builder|Win whereUserId($value)
 * @method static Builder|Win whereTypePrizeId($value)
 * @method static Builder|Win whereGoodsId($value)
 * @method static Builder|Win whereCreatedAt($value)
 * @method static Builder|Win whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Win extends AbstractModel
{
    public $table = 'wins';
    
    protected $fillable = [
        'id',
        'value',
        'status_id',
        'user_id',
        'type_prize_id',
        'goods_id',
    ];
    
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    
    public function goods(): HasOne
    {
        return $this->hasOne(Goods::class, 'id', 'goods_id');
    }
    
    public function typePrize(): HasOne
    {
        return $this->hasOne(TypePrize::class, 'id', 'type_prize_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
}
