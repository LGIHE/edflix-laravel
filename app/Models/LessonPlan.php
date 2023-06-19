<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonPlan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'owner',
        'status',
        'visibility',
        'topic',
        'subject',
        'school',
        'class',
        'learners_no',
        'term',
        'theme',
        'activity_aim',
        'competency',
        'learning_outcomes',
        'generic_skills',
        'values',
        'cross_cutting_issues',
        'key_learning_outcomes',
        'pre_requisite_knowledge',
        'learning_materials',
        'learning_methods',
        'references',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
