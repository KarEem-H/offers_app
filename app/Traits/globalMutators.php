<?php
namespace App\Traits;

trait  globalMutators{

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getNameArAttribute()
    {
        return optional(json_decode($this->attributes['name']))->ar ?? '';
    }

    public function getNameEnAttribute()
    {
        return optional(json_decode($this->attributes['name']))->en ?? '';
    }

    public function getSlugArAttribute()
    {
        return optional(json_decode($this->attributes['slug']))->ar ?? '';
    }

    public function getSlugEnAttribute()
    {
        return optional(json_decode($this->attributes['slug']))->en ?? '';
    }

    public function getAddressArAttribute()
    {
        return optional(json_decode($this->attributes['address']))->ar ?? '';
    }

    public function getAddressEnAttribute()
    {
        return optional(json_decode($this->attributes['address']))->en ?? '';
    }

    public function getMetaKeywordsArAttribute()
    {
        return optional(json_decode($this->attributes['meta_keywords']))->ar ?? '';
    }

    public function getMetaKeywordsEnAttribute()
    {
        return optional(json_decode($this->attributes['meta_keywords']))->en ?? '';
    }

    public function getMetaDescriptionArAttribute()
    {
        return optional(json_decode($this->attributes['meta_description']))->ar ?? '';
    }

    public function getMetaDescriptionEnAttribute()
    {
        return optional(json_decode($this->attributes['meta_description']))->en ?? '';
    }

    public function getMetaTitleArAttribute()
    {
        return optional(json_decode($this->attributes['meta_title']))->ar ?? '';
    }

    public function getMetaTitleEnAttribute()
    {
        return optional(json_decode($this->attributes['meta_title']))->en ?? '';
    }

    public function getDescriptionArAttribute()
    {
        return optional(json_decode($this->attributes['description']))->ar ?? '';
    }
    public function getDescriptionEnAttribute()
    {
        return optional(json_decode($this->attributes['description']))->en ?? '';
    }

    public function getSmallDescriptionArAttribute()
    {
        return optional(json_decode($this->attributes['small_description']))->ar ?? '';
    }
    public function getSmallDescriptionEnAttribute()
    {
        return optional(json_decode($this->attributes['small_description']))->en ?? '';
    }

    public function getShortDescriptionArAttribute()
    {
        return optional(json_decode($this->attributes['short_description']))->ar ?? '';
    }
    public function getShortDescriptionEnAttribute()
    {
        return optional(json_decode($this->attributes['short_description']))->en ?? '';
    }

    public function getFullDescriptionArAttribute()
    {
        return optional(json_decode($this->attributes['full_description']))->ar ?? '';
    }
    public function getFullDescriptionEnAttribute()
    {
        return optional(json_decode($this->attributes['full_description']))->en ?? '';
    }

    public function getTitleArAttribute()
    {
        return optional(json_decode($this->attributes['title']))->ar ?? '';
    }

    public function getTitleEnAttribute()
    {
        return optional(json_decode($this->attributes['title']))->en ?? '';
    }

    public function getPositionArAttribute()
    {
        return optional(json_decode($this->attributes['position']))->ar ?? '';
    }

    public function getPositionEnAttribute()
    {
        return optional(json_decode($this->attributes['position']))->en ?? '';
    }

    public function getStatusReadableAttribute()
    {
        return (int)$this->status ? 'Active' : 'Inactive';
    }

    public function getTextEnAttribute()
    {
        return optional(json_decode($this->attributes['text']))->en ?? '';
    }

    public function getTextArAttribute()
    {
        return optional(json_decode($this->attributes['text']))->ar ?? '';
    }

    public function getRecommendedMessageArAttribute()
    {
        return optional(json_decode($this->attributes['recommended_message']))->ar ?? '';
    }

    public function getRecommendedMessageEnAttribute()
    {
        return optional(json_decode($this->attributes['recommended_message']))->en ?? '';
    }

    public function getLinkTextArAttribute()
    {
        return optional(json_decode($this->attributes['link_text']))->ar ?? '';
    }

    public function getLinkTextEnAttribute()
    {
        return optional(json_decode($this->attributes['link_text']))->en ?? '';
    }

    public function getAuthorArAttribute()
    {
        return optional(json_decode($this->attributes['author']))->ar ?? '';
    }

    public function getAuthorEnAttribute()
    {
        return optional(json_decode($this->attributes['author']))->en ?? '';
    }

    public function getQuestionArAttribute()
    {
       return optional(json_decode($this->attributes['question']))->ar ?? '';
    }

    public function getQuestionEnAttribute()
    {
       return optional(json_decode($this->attributes['question']))->en ?? '';
    }

    public function getAnswerArAttribute()
    {
       return optional(json_decode($this->attributes['answer']))->ar ?? '';
    }

    public function getAnswerEnAttribute()
    {
       return optional(json_decode($this->attributes['answer']))->en ?? '';
    }

    public function getDiseaseArAttribute()
    {
        return optional(json_decode($this->attributes['disease']))->ar ?? '';
    }

    public function getDiseaseEnAttribute()
    {
        return optional(json_decode($this->attributes['disease']))->en ?? '';
    }

    public function getDetailsArAttribute()
    {
        return optional(json_decode($this->attributes['details']))->ar ?? '';
    }

    public function getDetailsEnAttribute()
    {
        return optional(json_decode($this->attributes['details']))->en ?? '';
    }
}
