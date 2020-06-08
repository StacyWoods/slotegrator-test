<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Goods
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property boolean $available
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Win[]|null $wins
 * @property-read User[]|null $winUsers
 * @method static Builder|TypePrize query()
 * @method static Builder|TypePrize whereId($value)
 * @method static Builder|TypePrize whereTitle($value)
 * @method static Builder|TypePrize whereDescription($value)
 * @method static Builder|TypePrize whereAvailable($value)
 * @method static Builder|TypePrize whereCreatedAt($value)
 * @method static Builder|TypePrize whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Goods extends AbstractModel
{
    use SoftDeletes;

    public $table = 'goods';
    
    protected $fillable = [
        'id',
        'title',
        'description',
        'available',
    ];
    
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $boolean = [
        'available',
    ];

    public function wins(): HasMany
    {
        return $this->hasMany(Win::class, 'goods_id', 'id');
    }

    public function winUser(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Win::class, 'id', 'goods_id', 'id', 'user_id');
    }
}
