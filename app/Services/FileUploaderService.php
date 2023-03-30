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

namespace App\Services;

use App\Models\FileUploader;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * Class FileUploaderService
 *
 * @package App\Services
 */
class FileUploaderService
{

    /**
     * GetAllFiles //return all Files to the files table.
     *
     * @return LengthAwarePaginator
     */
    public function getAllFiles(): LengthAwarePaginator
    {
        $sortKey  = request()->sort_key ?? 'id';
        $sortType = request()->sort_type ?? 'desc';
        $keyword  = request()->search;

        $files = FileUploader::where('bu_id', request('bussinessUnit')->id)
            ->when(
                isset($keyword) && $keyword != "",
                function ($query) use ($keyword): void {
                    $query->where(
                        function ($query) use ($keyword): void {

                            $query->orWhere('id', (int) $keyword);
                            $query->orWhere('name->ar', "LIKE", '%' . $keyword . '%');
                            $query->orWhere('name->en', "LIKE", '%' . $keyword . '%');
                            $query->orWhere('type', "LIKE", '%' . $keyword . '%');
                            $query->orWhere('path', "LIKE", '%' . $keyword . '%');
                        }
                    );
                }
            )
            ->orderBy($sortKey, $sortType)
            ->paginate(request('limit') ?? config('app.limit'));

        return $files;
    }

    /**
     * StoreFile //array of storeFile status.
     *
     * @param $input // request arrray.
     *
     * @return mixed
     */
    public function storeFile($input)
    {

        $input['bu_id'] =  $input['bussinessUnit']->id;
        $input['type'] = request()->file('file')->extension();
        $offer = FileUploader::create($input);

        return $offer;
    }


    /**
     * UpdateFile
     *
     * @param mixed $offer // offer.
     * @param mixed $input // request array.
     *
     * @return mixed
     */
    public function updateFile($offer,  $input)
    {
        $input['bu_id'] =  $input['bussinessUnit']->id;
        $input['type'] = request()->file('file')->extension();

        $offer->update($input);

        return $offer;
    }
}
