<?php
namespace App\Helpers;
/**
 * Created by IntelliJ IDEA.
 * User: sridhar
 * Date: 19/8/20
 * Time: 2:08 AM
 */
use Illuminate\Http\Request;

class Pagination
{
    /**
     * @param $query
     * @param Request $request
     * @param array $filterColumns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function preparePagination($query, Request $request, $filterColumns = []){
        // handle sort option
        if ($request->exists('sort') && strpos($request->get('sort'), '|') > -1) {
            // handle multisort
            $sorts = explode(',', request()->sort);
            foreach ($sorts as $sort) {
                $sortOrder = explode('|', $sort);
                $query = $query->orderBy($sortOrder[0], $sortOrder[1]);
            }
        } else {
            $query = $query->orderBy('id', 'desc');
        }
        // search
        if ($request->exists('filter')) {
            $query->where(function($q) use($request, $filterColumns) {
                $value = "%{$request->filter}%";
                foreach ($filterColumns as $key => $column){
                    if($key == 0){
                        $q->where($column, 'like', $value);
                    }else{
                        $q->orWhere($column, 'like', $value);
                    }
                }
            });

        }
        // list per page
        $perPage = $request->has('per_page') ? (int) $request->per_page : null;
        $pagination = $query->paginate($perPage);
        return $pagination;
    }

}
