<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function auth;

class Project extends Model
{
    use HasFactory, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'banner_image_url',
        'profile_image_url',
        'collection_url',
        'website_url',
        'category',
        'type',
        'floor_price',
        'owners',
        'average_price',
        'count',
        'seven_day_sales',
        'one_day_sales',
        'luck',
        'user_id',
        'verified'
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

    public function findProjectById($id)
    {
        return self::where('id', $id)->first();
    }

    public function findRandomProjectIds($numberOfProjects)
    {
        return self::all(['id'])->random($numberOfProjects);
    }


    public function findTopTenLuck()
    {
        return self::orderBy('luck', 'desc')->get()->take(5);
    }

    public function findTopTenLike(): Collection
    {
        return self::orderBy('likes', 'desc')->get()->take(5);
    }

    public function increaseLikes(string $title, int $value)
    {
        return self::where('title', $title)->update(['likes' => DB::raw("likes + $value")]);
    }

    public function findUserProjects()
    {
        $userId = auth()->id();
        return self::where('user_id', $userId)->get();
    }

    public function deleteProject($title)
    {
        $userId = auth()->id();
        return self::where('title', $title)->where('user_id', $userId)->delete();
    }

    /**
     * @throws Exception
     */
    public function updateProject($validatedRequest)
    {
        $title = $validatedRequest['title'];
        $banner = $validatedRequest['banner'];
        $profile = $validatedRequest['profile'];
        $path = "pictures";
        $userId = auth()->id();
        if ($banner) {
            Storage::disk('local')->put("$path/banner/$title.webp", $this->createImage($banner));
        }
        if ($profile) {
            Storage::disk('local')->put("$path/profile/$title.webp", $this->createImage($profile));
        }

        return self::where('title', $title)->update([
            'title' => $title,
            'description' => $validatedRequest['description'],
            'likes' => random_int(0, 50),
            'luck' => random_int(1, 100),
            'banner' => "api/$path/banner/$title",
            'profile' => "api/$path/profile/$title",
            'collection' => $validatedRequest['collection'],
            'user_id' => $userId,
        ]);
    }

    /**
     * @throws Exception
     */
    public function createProject($validatedRequest)
    {
        $title = $validatedRequest['title'];
        $banner = $validatedRequest['bannerImageUrl'];
        $profile = $validatedRequest['profileImageUrl'];
        $path = "pictures";
        $userId = auth()->id();
//        Storage::disk('local')->put("$path/profile/$title.webp", $this->createImage($profile));
//        Storage::disk('local')->put("$path/banner/$title.webp", $this->createImage($banner));
        return self::create([
            'title' => $title,
            'description' => $validatedRequest['description'],
            'luck' => random_int(0, 50),
            'banner_image_url' => $banner,
            'profile_image_url' => $profile,
            'collection_url' => $validatedRequest['collectionUrl'],
            'website_url' => $validatedRequest['websiteUrl'],
            'user_id' => $userId,
            'category' => $validatedRequest['category'],
            'verified' => false,
            'type' => $validatedRequest['type'],
            'boost' => null,
            'floor_price' => $validatedRequest['floorPrice'],
            'owners' => $validatedRequest['owners'],
            'average_price' => $validatedRequest['averagePrice'],
            'count' => $validatedRequest['count'],
            'seven_day_sales' => $validatedRequest['sevenDaySales'],
            'one_day_sales' => $validatedRequest['oneDaySales'],
        ]);
    }

    private function createImage($base64_string)
    {
        $data = explode(',', $base64_string);
        return base64_decode($data[1]);
    }


}
