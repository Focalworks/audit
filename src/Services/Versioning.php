<?php
namespace Focalworks\Audit\Services;

use Focalworks\Audit\Http\Models\VersionInfo;
use Focalworks\Audit\Interfaces\Content;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 15/7/15
 * Time: 2:18 PM
 */
class Versioning implements Content
{
    protected $content;

    function  __construct($content)
    {
        $this->content = $content;
        $this->id = 1;
        $this->content_type = 'book';

    }

    public function getContent()
    {
        $version = new VersionInfo();
        return $version->getLatestVersionByContentId($this->id);
    }

    /*
     * Get previous version of specified content from current content id
     *
     * @var
     * @return object
     */

    public function getPreviousContent()
    {
        $version = new VersionInfo();
        return $version->getPreVersion($this->id);
    }


    /*
     * Save content object in database
     *
     * @return previous version of content
     */

    public function save()
    {
        $version = new VersionInfo();

        $contentData = [
            'content_id' => $this->id,
            'content_type' => $this->content_type,
            'revision_no' => $this->generateVersion(),
            'user_id' => $this->getUserId(),
            'data' =>json_encode((array)$this->content)
        ];

        $ver =  $version->createVersion($contentData);
        return $ver;
    }

    /*
     *
     */
    public function rollback($ver)
    {
        $version = new VersionInfo();
        $revisionData = $version->getRevision($ver);

        $contentData = [
            'content_id' => $revisionData->id,
            'content_type' => $revisionData->content_type,
            'revision_no' => $this->generateVersion(),
            'user_id' => $this->getUserId(),
            'data' => $revisionData->data
        ];

        $ver =  $version->createVersion($contentData);
        return $ver;

    }


    /*
     * Get userid from session / logged in user
     *
     * @var
     * @return useid string / integer
     */
    private function getUserId()
    {
        return 1;
    }

    /*
     * Generate version
     *
     * @var
     * @return string
     */

    private function generateVersion()
    {
        return uniqid('ver');
    }
}