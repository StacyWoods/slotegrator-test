<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\TypePrize
 *
 * @property int $id
 * @property string $title
 * @property int $limit
 * @property int $min
 * @property int $max
 * @property int $current_wins
 * @property boolean $available
 * @property double $multiplicator
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|TypePrize query()
 * @method static Builder|TypePrize whereId($value)
 * @method static Builder|TypePrize whereTitle($value)
 * @method static Builder|TypePrize whereLimit($value)
 * @method static Builder|TypePrize whereMin($value)
 * @method static Builder|TypePrize whereMax($value)
 * @method static Builder|TypePrize whereCurrentWins($value)
 * @method static Builder|TypePrize whereAvailable($value)
 * @method static Builder|TypePrize whereMultiplicator($value)
 * @method static Builder|TypePrize whereCreatedAt($value)
 * @method static Builder|TypePrize whereUpdatedAt($value)
 * @mixin Eloquent
 */
class TypePrize extends AbstractModel
{
    use SoftDeletes;

    public $table = 'type_prizes';
    
    protected $fillable = [
        'id',
        'title',
        'limit',
        'min',
        'max',
        'current_wins',
        'available',
        'multiplicator',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $boolean = [
        'available',
    ];
}
