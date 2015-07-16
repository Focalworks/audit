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

    public function getLatestVersionByContentId($id)
    {
        return DB::table($this->table)->where('content_id', $id)->orderBy('id','desc')->first();
    }

    public function getRevision($id)
    {
        return DB::table($this->table)->where('revision_no', $id)->first();
    }

    public function getPreVersion($id)
    {
        return DB::table($this->table)->where('content_id', $id)->orderBy('id','desc')->skip(1)->take(1)->first();
    }



}