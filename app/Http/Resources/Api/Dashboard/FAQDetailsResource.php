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
use Illuminate\Support\Str;

/**
 * FAQDetailsResource
 */
class FAQDetailsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request // request
     * 
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "question" => $this->getTranslations('question'),
            "answer" => $this->getTranslations('answer'),
            "order" => $this->order,
           
        ];
    }
}
