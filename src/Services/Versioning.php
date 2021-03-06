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

    public function getCurrentVersion()
    {
        $version      = new VersionInfo();
        $revisionData = $version->getLast($this->id, $this->content_type);
        return $revisionData;
    }

    /**
     * This will return array of latest content
     * @return mixed
     */
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

        $keySequence = $this->getCommonKeys($revisionData);

        $endData = null;

        //loop though diff object and manipulate it for comparing diff
        foreach ($revisionData as $index => $rev) {

            $returnData['revision'.$index] = $rev->revision_no;
            $returnData[$index] = null;

            if (json_decode($rev->data)) {
                $data = json_decode($rev->data);

                $sequenceData[$index] = null;
                $endData[$index] = null;
                foreach ($data as $k => $content) {
                    if(array_key_exists($k,$keySequence)) {
                        //sequence object keys for exact comparison
                        $sequenceData[$index][$keySequence[$k]] = str_replace("_", ' ', $k).": ".$content."\n";
                    } else {
                        //diff object keys to append at the end of content string
                        $endData[$index] .= str_replace("_", ' ', $k).": ".$content."\n";
                    }
                }
            } else {
                //if content is not json object return data as it is
                $returnData[$index] = $rev->data;
            }
        }

        //make string according to sequence for comparison
        if(isset($sequenceData)) {

            foreach ($sequenceData as $key => $value) {

                foreach($keySequence as $k=>$seq) {
                    $returnData[$key] .= $sequenceData[$key][$seq];
                }

                //concat diff string at the end
                if(isset($endData[$key])) {
                    $returnData[$key] .= $endData[$key];
                }
            }
        }

        return $returnData;
    }

    /**
     * This will compare two arrays and return common keys
     * @param $data
     * @return array or common keys
     */
    private function getCommonKeys($data)
    {
        foreach ($data as $index => $rev) {

            if (json_decode($rev->data)) {
                $subData = json_decode($rev->data);

                foreach ($subData as $key => $value ) {
                    $keySequence[$index][] = $key;
                }
            }
        }
        if( count($keySequence) > 1) {
            $commonKeys = array_intersect($keySequence[0], $keySequence[1]);
        } else {
            $commonKeys = $keySequence[0];
        }
        return array_flip($commonKeys);
    }

    /**
     * This will return previous version content
     * @return mixed
     */
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