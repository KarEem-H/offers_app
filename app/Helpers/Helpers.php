<?php
if (! function_exists('minutesOfReading')) {

    function minutesOfReading($text)
    {
        $order   = array("\r\n", "\n", "\r", "&nbsp;", "\t");
        $totalWords = explode(' ', str_replace($order, '', strip_tags($text)));
        $minutesToRead = round(count($totalWords) / 200);

        return (int)max(1, $minutesToRead);
    }
}

if (! function_exists('responseJson')) {
    function responseJson($status, $code, $msg, $data = null, $state = 200)
    {
        $response = [
            'status' => (bool)$status,
            'code' => (int)$code,
            'message' => $msg,
            'data' => $data,
        ];
        return response()->json($response, $state);
    }
}

if (! function_exists('saveImage')) {
    function saveImage($file, $folder = '/')
    {
        $fileName = date('YmdHis').'-'.$file->getClientOriginalName();
        $dest = public_path('uploads/'.$folder);
        $file->move($dest, $fileName);
        return 'uploads/'.$folder.'/'.$fileName;
    }
}


if (! function_exists('getKeys')) {
    function getSettingsKeys($name, $lang)
    {
        return [
            "seo.{$name}_{$lang}_title",
            "seo.{$name}_{$lang}_description",
            "seo.{$name}_{$lang}_image_alt",
            "seo.{$name}_image",
            "seo.{$name}_{$lang}_keywords"
        ];
    }
}
if (! function_exists('enhanceArabicSearch')) {
    function enhanceArabicSearch($string): string
    {
        $string_result[0] = $string;
        $string_result[0] = str_contains($string, 'ا') ? str_replace('ا', '(ى|ا|أ|إ|آ|ؤ|ء|ئ)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'أ') ? str_replace('أ', '(ا|أ|إ|آ|ؤ|ء|ئ)', $string_result[0]): $string_result[0];
        $string_result[0] = str_contains($string, 'إ') ? str_replace('إ', '(ا|أ|إ|آ|ؤ|ء|ئ)', $string_result[0]): $string_result[0];
        $string_result[0] = str_contains($string, 'آ') ? str_replace('آ', '(ا|أ|إ|آ|ؤ|ء|ئ)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ؤ') ? str_replace('ؤ', '(ا|أ|إ|آ|ؤ|ء|ئ)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ء') ? str_replace('ء', '(ا|أ|إ|آ|ؤ|ء|ئ)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ئ') ? str_replace('ئ', '(ا|أ|إ|آ|ؤ|ء|ئ)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ي') ? str_replace('ي', '(ى|ي)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ى') ? str_replace('ى', '(ى|ي)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ه') ? str_replace('ه', '(ة|ه)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ة') ? str_replace('ة', '(ة|ه)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ط') ? str_replace('ط', '(ت|ط)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ت') ? str_replace('ت', '(ت|ط)', $string_result[0]): $string_result[0];
        $string_result[0] = str_contains($string, 'ذ') ? str_replace('ذ', '(ز|ذ)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ز') ? str_replace('ز', '(ز|ذ)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ث') ? str_replace('ث', '(ث|س)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'س') ? str_replace('س', '(ث|س)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ك') ? str_replace('ك', '(ك|ق)', $string_result[0]) : $string_result[0];
        $string_result[0] = str_contains($string, 'ق') ? str_replace('ق', '(ك|ق)', $string_result[0]) : $string_result[0];
        return $string_result[0];
    }
}
