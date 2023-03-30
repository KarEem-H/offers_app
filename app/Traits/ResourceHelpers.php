
<?php

namespace App\Traits;


trait ResourceHelpers
{
    /**
     * Remove null values from Eloquent api resource
     * @param array $data
     * @return array
     */
    public function removeNullValues(array $data)
    {
        $filtered_data = [];
        foreach ($data as $key => $value) {
            // if resource is empty
            if ($value instanceof JsonResource and $value->resource === null) {
                continue;
            }
            $filtered_data[$key] = $this->when($value !== null, $value);
        }

        return $filtered_data;
    }
}
