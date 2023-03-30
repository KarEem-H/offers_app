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
namespace App\Http\Resources\Api\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * FileUploaderResource
 */
class FileUploaderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request // request
     * 
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->getTranslations('name'),
            "file" => $this->file,
            "type" => $this->type,
            "created_at" => $this->created_at->format('Y-m-d h:i a'),
            "updated_at" => $this->created_at->format('Y-m-d h:i a')
        ];
    }
}
