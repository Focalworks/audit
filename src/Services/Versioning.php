<?php

namespace Focalworks\Audit\Services;

use Focalworks\Audit\Http\Models\VersionInfo;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 15/7/15
 * Time: 2:18 PM
 */
class Versioning
{
    protected $content;

    function __construct($content = null)
    {
        if (isset($content)) {
            $this->content      = $content->attributesToArray();
            $this->id           = $content->id;
            $this->content_type = $content->getContentType();
        }
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
            'data' => json_encode((array) $this->content)
        ];

        $ver = $version->createVersion($contentData);
        return $ver;
    }
    /*
     * rollback to given version
     */

    public function rollback($ver)
    {
        $version      = new VersionInfo();
        $revisionData = $version->getRevision($ver);

        $contentData = [
            'content_id' => $revisionData->content_id,
            'content_type' => $revisionData->content_type,
            'revision_no' => $this->generateVersion(),
            'user_id' => $this->getUserId(),
            'data' => $revisionData->data
        ];

        $ver = $version->createVersion($contentData);
        return $ver;
    }

    public function getcurrentVersion()
    {
        $version      = new VersionInfo();
        $revisionData = $version->getLast($this->id, $this->content_type);
        return $revisionData;
    }

    public function getLatestDiff()
    {
        $version      = new VersionInfo();
        $revisionData = $version->getDiffContent($this->id, $this->content_type);

        foreach ($revisionData as $index => $rev) {
            $data               = json_decode($rev->data);
            $returnData[$index] = null;

            foreach ($data as $k => $content) {
                $returnData[$index] .= str_replace("_", ' ', $k).": ".$content."\n";
            }
        }
        return $returnData;
    }

    public function getDiff($id)
    {
        $version = new VersionInfo();

        $revision = $version->getContentFromId($id);

        $revisionData = $version->getDiffFromVersionId($id,
            $revision->content_id, $revision->content_type);

        foreach ($revisionData as $index => $rev) {

            $returnData['revision'.$index] = $rev->revision_no;

            if (json_decode($rev->data)) {
                $data = (array) json_decode($rev->data);
                ksort($data);
                $returnData[$index] = null;
                foreach ($data as $k => $content) {
                    $returnData[$index] .= str_replace("_", ' ', $k).": ".$content."\n";
                }
            } else {
                $returnData[$index] = $rev->data;
            }
        }
        return $returnData;
    }

    public function getPreviousContent()
    {
        $version  = new VersionInfo();
        $prevData = $version->getPreVersion($this->id, $this->content_type);
        return $prevData;
    }

    public function getContentTypes()
    {
        $version  = new VersionInfo();
        $prevData = $version->getContentTypes();
        return $prevData;
    }

    /**
     * Get List of all revisions based on content object
     *
     * @return int
     */
    public function getContentHistory($type, $id)
    {
        $version     = new VersionInfo();
        $contentData = $version->getContentAllVersions($id, $type);
        return $contentData;
    }

    /**
     * Get List of all revisions based on content object
     *
     * @return int
     */
    public function contentHistory()
    {
        $version     = new VersionInfo();
        $contentData = $version->getContentAllVersions($this->id,
            $this->content_type);
        return $contentData;
    }

    /**
     * Get List of all revisions (including all content types)
     *
     * @return int
     */
    public function getHistory($type)
    {
        $version = new VersionInfo();

        if ($type == 'all') {
            $contentData = $version->getAll();
        } else {
            $contentData = $version->getAllofType($type);
        }

        return $contentData;
    }
    /*
     * Get userid from session / logged in user
     *
     * @var
     * @return useid string / integer
     */

    /**
     * @return bool
     */
    private function getUserId()
    {
        if (Auth::check())
        {
            return $id = Auth::user()->id;
        }
        return false;
    }
    /*
     * Generate version number
     *
     * @var
     * @return string
     */

    private function generateVersion()
    {
        return uniqid('ver');
    }
}