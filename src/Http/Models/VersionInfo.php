<?php
namespace Focalworks\Audit\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 16/7/15
 * Time: 10:39 AM
 */

class VersionInfo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'version_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['content_id', 'content_type', 'revision_no','user_id','data'];

    public function createVersion($contentData)
    {
        return DB::table($this->table)->insert([
            'content_id' => $contentData['content_id'],
            'content_type' => $contentData['content_type'],
            'revision_no' => $contentData['revision_no'],
            'user_id' => $contentData['user_id'],
            'data' => $contentData['data'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public function getDiffContent($id, $type)
    {
        return DB::table($this->table)
            ->where('content_id', $id)
            ->where('content_type', $type)
            ->orderBy('id','desc')
            ->take(2)
            ->get();
    }

    public function getDiffFromVersionId($versionInfoId, $id, $type)
    {
        return DB::table($this->table)
            ->where('content_id', $id)
            ->where('id', "<=", $versionInfoId)
            ->where('content_type', $type)
            ->orderBy('id','desc')
            ->take(2)
            ->get();
    }

    public function getContentFromId($id)
    {
        return DB::table($this->table)
            ->select(['id','content_id','content_type'])
            ->where('id', $id)
            ->first();
    }

    public function getContentFromVersion($version_no)
    {
        return DB::table($this->table)
            ->select(['id','content_id','content_type'])
            ->where('version_no', $version_no)
            ->first();
    }

    public function getLast($id, $type)
    {
        return DB::table($this->table)
            ->where('content_id', $id)
            ->where('content_type', $type)
            ->orderBy('id','desc')
            ->first();
    }

    // public function getRevision($id, $type)
    // {
    //     return DB::table($this->table)
    //         ->where('revision_no', $id)
    //         ->where('content_type', $type)
    //         ->first();
    // }

    public function getPreVersion($id, $type)
    {
        return DB::table($this->table)
            ->where('content_id', $id)
            ->where('content_type', $type)
            ->orderBy('id','desc')
            ->skip(1)
            ->take(1)
            ->first();
    }

    public function getContentAllVersions($id, $type)
    {
        return DB::table($this->table)
            ->where('content_id', $id)
            ->where('content_type', $type)
//            ->orderBy('content_type','asc')
            ->orderBy('id','desc')
            ->get();
    }

    public function getAll()
    {
        return DB::table($this->table)
            ->orderBy('content_type')
            ->orderBy('id','desc')
            ->get();
    }

    public function getAllofType($type)
    {
        return DB::table($this->table)
            ->where('content_type',$type)
            ->orderBy('id','desc')
            ->get();
    }


    public function getContentTypes()
    {
        return DB::table($this->table)
            ->select('content_type')
            ->distinct()
            ->orderBy('content_type')
            ->get();
    }
}