<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mockery\Exception;

class GeneratedProject extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'project_id'
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
        return self::where('title', $title)->first();
    }

    public function findAll(): Collection
    {
        return self::all();
    }


    public function findLast($numberOfProjects): Collection
    {
        return self::orderBy('id', 'DESC')->get()->take($numberOfProjects);
    }


    /**
     * @throws Exception
     */
    public function createProject($projectId)
    {
        return self::create([
            'project_id' => $projectId,
        ]);
    }
}
