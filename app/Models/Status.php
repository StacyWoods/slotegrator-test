<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Status
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Status query()
 * @method static Builder|Status whereId($value)
 * @method static Builder|Status whereSlug($value)
 * @method static Builder|Status whereTitle($value)
 * @method static Builder|Status whereType($value)
 * @method static Builder|Status whereDescription($value)
 * @method static Builder|Status whereCreatedAt($value)
 * @method static Builder|Status whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Status extends AbstractModel
{
    public $table = 'statuses';
    
    protected $fillable = [
        'id',
        'slug',
        'title',
        'description',
        'type',
    ];
    
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
