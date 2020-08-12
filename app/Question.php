<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{

    /**
     * @return BelongsToMany
     */
    public function answers(): BelongsToMany
    {
        return $this->belongsToMany(Answer::class, 'answer_question')
            ->wherePivot('value');
    }
}
