<?php

namespace App\Models;

use Closure;
use DateTime;
use Encore\Admin\Grid\Filter\AbstractFilter;
use Generator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class AbstractModel
 * @see https://laravel.com/docs/6.x/eloquent
 *
 * General EloquentModel access methods:
 * @method static Collection|Builder[]|static get(array $columns = ['*']) Execute the query as a "select" statement.
 * @method static Model|Builder|static select(string|array|Collection ...$value)
 * @method static Model|$this|static create(array $attributes = []) Save a new model and return the instance.
 * @method static Model|$this|static forceCreate(array $attributes) Save a new model and return the instance. Allow mass-assignment.
 * @method static int update(array $values) Update a record in the database.
 * @method static Model|Builder|static|Collection find(string|array $value = null)
 * @method static Model|Builder|static findOrNew(mixed $id, array $columns = ['*'])
 * @method static Model|Collection|Builder|Builder[]|static findOrFail(mixed $id, array $columns = ['*'])
 * @method static Model|Builder|mixed|static firstOr(callable|array $columns = ['*'], callable $callback = null)
 * @method static Model|Builder|static firstOrFail(array $columns = ['*'])
 * @method static Model|Builder|static firstOrNew(array $attributes, array $values = [])
 * @method static Model|Builder|static firstOrCreate(array $attributes, array $values = [])
 * @method static Model|Builder|static updateOrCreate(array $attributes, array $values = [])
 * @method static int increment(string $column, float|int $amount = 1, array $extra = []) Increment a column's value by a given amount.
 * @method static int decrement(string $column, float|int $amount = 1, array $extra = []) Decrement a column's value by a given amount.
 *
 * @method static Model|Builder filter(AbstractFilter $filters) Apply filter
 * @method static Model|Builder _paginate($value = null)
 * @method LengthAwarePaginator paginate(int $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null) Paginate the given query.
 * @method Paginator simplePaginate(int $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null) Paginate the given query into a simple paginator.
 * @method static Model|Builder inRandomOrder()
 * @method static Model|Builder count()
 * @method static Model|Builder oldest($column = 'created_at')
 * @method static Model|Builder latest($column = 'created_at')
 * @method static Model|Builder lastOrFail($column = 'created_at')
 * @method static Model|Builder orderBy(string $column, string $direction = 'asc') Add an "order by" clause to the query.
 *
 * @method static $this withGlobalScope(string $identifier, Scope|Closure $scope) Register a new global scope.
 * @method static $this withoutGlobalScope(Scope|string $scope) Remove a registered global scope.
 * @method static $this withoutGlobalScopes(array $scopes = null) Remove all or passed registered global scopes.
 * @method static array removedScopes() Get an array of global scopes that were removed from the query.
 *
 * @method static mixed value(string $column) Get a single column's value from the first result of a query.
 * @method static Model[]|Builder[] getModels(array $columns = ['*']) Get the hydrated models without eager loading.
 * @method static array eagerLoadRelations(array $models) Eager load the relationships for the models.
 * @method static Relation getRelation(string $name) Get the relation instance for the given relation name.
 * @method static Generator cursor() Get a generator for the given query.
 * @method static bool chunkById(int $count, callable $callback, string|null $column = null, string|null $alias = null) Chunk the results of a query by comparing numeric IDs.
 * @method static Collection pluck(string $column, string|null $key = null) Get an array with the values of a given column.
 * @method static mixed delete() Delete a record from the database.
 * @method static mixed forceDelete() Run the default delete function on the builder. Since we do not apply scopes here, the row will actually be deleted.
 * @method static void onDelete(Closure $callback) Register a replacement for the default delete function.
 * @method static Builder|mixed scopes(array $scopes) Call the given local model scopes.
 * @method static Builder applyScopes() Apply the scopes to the Eloquent builder instance and return it.
 * @method static Model|Builder with(mixed $relations) Set the relationships that should be eager loaded.
 * @method static Model|Builder without(mixed $relations) Prevent the specified relations from being eager loaded.
 * @method static Model|Builder newModelQuery() Get a new query builder that doesn't have any global scopes or eager loading.
 * @method static Model|Builder newModelInstance(array $attributes = []) Create a new instance of the model being queried.
 * @method static Model|Builder query() Begin querying the model.
 * @method static Model|Builder newQuery() Get a new query builder for the model's table.
 * @method static Model|Builder getQuery() Get the underlying query builder instance.
 * @method static $this setQuery(Builder $query) Set the underlying query builder instance.
 * @method static Builder toBase() Get a base query builder instance.
 * @method static array getEagerLoads() Get the relationships being eagerly loaded.
 * @method static $this setEagerLoads(array $eagerLoad) Set the relationships being eagerly loaded.
 * @method static $this setModel(Model $model) Set a model instance for the model being queried.
 * @method static string qualifyColumn(string $column) Qualify the given column name by the model's table.
 * @method static Closure getMacro(string $name) Get the given macro by name.
 * @method static mixed __get(string $key) Dynamically access builder proxies.
 * @method static mixed __call(string $method, array $parameters) Dynamically handle calls into the query instance.
 * @method static mixed __callStatic(string $method, array $parameters) Dynamically handle calls into the query instance.
 * @method static void __clone() Force a clone of the underlying query builder when cloning.
 *
 * @method static Model|Builder where($value, $value = null, $value = null)
 * @method static Model|Builder whereNull($value)
 * @method static Model|Builder whereNotNull($value)
 * @method static Model|Builder whereDate($value, $value)
 * @method static Model|Builder whereMonth($value, $value)
 * @method static Model|Builder whereDay($value, $value)
 * @method static Model|Builder whereYear($value, $value)
 * @method static Model|Builder whereTime($value, $value)
 * @method static Model|Builder whereIn($value, array|Collection $value)
 * @method static Model|Builder orWhere($value, array $value)
 * @method static Model|Builder orWhereIn($value, array|Collection $value)
 * @method static Model|Builder whereNotIn($value, array|Collection $value)
 * @method static Model|Builder whereBetween($value, array $value)
 * @method static Model|Builder whereNotBetween($value, array $value)
 * @method static Model|Builder whereColumn($value, $value, $value = null)
 *
 * Soft-Deletes & Other Common Properties:
 * @property DateTime|null $created_at
 * @property DateTime|null $updated_at
 * @property DateTime|null $deleted_at Marks record as soft-deleted
 * @method static bool|null restore() For soft-delete only
 * @method static Model|Builder onlyTrashed() For soft-delete only
 * @method static Model|Builder withTrashed() For soft-delete only
 * @method static Model|Builder withoutTrashed() For soft-delete only
 *
 * @mixin Model A-la trait
 */
abstract class AbstractModel extends Model
{
    public static function hasJoin($builder, $table)
    {
        return array_search($table, array_column((array)$builder->getQuery()->joins, 'table')) !== false;
    }
}
