<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Likes extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'deleted'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function findProjectByTitle($title)
    {
        return Project::where('title', $title)->first();
    }

    public function findLike($projectTitle)
    {
        $project = $this->findProjectByTitle($projectTitle);
        $userId = auth()->id();
        $projectId = $project['id'];
        return self::where('project_id', $projectId)->where('user_id', $userId)->first();
    }

    public function updateLike($projectTitle, $deleted)
    {
        $project = $this->findProjectByTitle($projectTitle);
        $userId = auth()->id();
        $projectId = $project['id'];
        return self::where('user_id', $userId)
            ->where('project_id', $projectId)
            ->update(['deleted' => $deleted]);
    }

    public function softDeleteLike($projectTitle)
    {
        $deleted = date("Y-m-d H:i:s", time());
        return $this->updateLike($projectTitle, $deleted);
    }

    public function recoverLike($projectTitle)
    {
        return $this->updateLike($projectTitle, null);
    }

    public function switchLike($projectTitle)
    {
        $like = $this->findLike($projectTitle);
        if ($like) {
            $deleted = $like['deleted'];
            return $this->switchDelete($projectTitle, $deleted);
        }
        return $this->createLike($projectTitle);
    }

    private function switchDelete($projectTitle, $deleted)
    {
        $projectModel = new Project();
        if ($deleted) {
            $projectModel->increaseLikes($projectTitle, 1);
            return $this->recoverLike($projectTitle);
        }
        $projectModel->increaseLikes($projectTitle, -1);
        return $this->softDeleteLike($projectTitle);

    }

    public function createLike($title)
    {
        $userId = auth()->id();
        $projectId = $this->findProjectByTitle($title)['id'];
        return self::create([
            'deleted' => null,
            'project_id' => $projectId,
            'user_id' => $userId,
        ]);
    }
}
