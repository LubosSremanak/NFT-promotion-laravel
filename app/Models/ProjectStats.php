<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectStats extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'project_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function createProjectStats($validatedRequest)
    {
        $userId = auth()->id();
        $projectModel = new Project();
        $title = $validatedRequest['title'];
        $projectId = $projectModel->findProjectByTitle($title)['id'];
        return self::create([
            '$userId' => $userId,
            'project_id' => $projectId,
            'type' => $validatedRequest['type'],
        ]);
    }
}
