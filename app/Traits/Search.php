<?php

/**
 * Created by VsCode.
 * php version 8.0
 * Date: 25/2/23
 * Time: 01:30 م
 *
 * @category CodeSniffer
 * @author   karim <karim.hemida>
 */

namespace App\Traits;

use Illuminate\Support\Facades\Schema;
use \Illuminate\Database\Eloquent\Builder;

/**
 * ScopeFilterGrid
 */
trait Search
{

    /**
     * ScopeFilterGrid
     *
     * @param \Illuminate\Database\Eloquent\Builder|static $query            // Query
     * @param string                                       $searchKey        // searchKey
     * @param string                                       $sortKey          // sortKey
     * @param string                                       $sortType         // sortType
     * @param boolean                                      $orderByRelations // orderByRelations
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeFilterGrid($query, $searchKey, $sortKey = 'id', $sortType = 'DSEC', $orderByRelations = false)
    {
        $tableName = static::getTableName() == 'offers' ?  'offers.' : '';
        $results = $query->where(
            function ($query) use ($searchKey, $tableName) {

                if (isset($searchKey) && $searchKey != "") {
                    $query->orWhere($tableName . 'id', (int) $searchKey);
                    foreach (static::getSearchableFields() as $field) {
                        $query->orWhere($tableName . $field, 'LIKE', "%" . $searchKey . "%");
                    }
                }
            }
        );
        if ($orderByRelations) {
            if ($sortKey == 'bookings') {

                return $results->withCount($sortKey)->orderBy($sortKey . "_count",  $sortType);
            }
        } else {
            if (isset($searchKey) && $searchKey != "") {

                return $results->orderBy($sortKey, $sortType);
            }
            return $query->orderBy($sortKey, $sortType);
        }
    }
    /**
     * Get all searchable fields
     *
     * @return array
     */
    public static function getSearchableFields()
    {
        $model = new static;

        $fields = request()->method() == 'GET'
            && request()->is('*/api/offers*') ?
            $model->apiSearchableKeys  : $model->searchableKeys; // To do: applay at all models.

        if (empty($fields)) {
            $fields = Schema::getColumnListing($model->getTable());

            $ignoredColumns = [
                $model->getKeyName(),
                $model->getUpdatedAtColumn(),
                $model->getCreatedAtColumn(),
            ];

            if (method_exists($model, 'getDeletedAtColumn')) {
                $ignoredColumns[] = $model->getDeletedAtColumn();
            }

            $fields = array_diff($fields, $model->getHidden(), $ignoredColumns);
        }

        return $fields;
    }
    /**
     * Get the model Table Name
     *
     * @return string
     */
    public static function getTableName()
    {
        $model = new static;

        return  isset($model->table)?$model->table:''; // To do: applay at all models.
    }
}
