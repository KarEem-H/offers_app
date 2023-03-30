<?php

namespace App\Traits;
 
trait ReportTrait {

    public function scopeDate($q)
    {
        $request = request();
        $q->when(($request['from'] && !$request['to']), function ($query) use ($request) {
            return $query->whereDate('created_at', '>=', $request['from']);
        })->when(($request['to'] && !$request['from']), function ($query) use ($request) {
            return $query->whereDate('created_at', '<=', $request['to']);
        })->when(($request['to'] && $request['from']), function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request['from']);
            return $query->whereDate('created_at', '<=', $request['to']);
        });
        return $q;
    }
}