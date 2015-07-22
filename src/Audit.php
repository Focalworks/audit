<?php
/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 15/7/15
 * Time: 4:48 PM
 */

namespace Focalworks\Audit;

use Focalworks\Audit\Interfaces\Content;
use Focalworks\Audit\Services\Versioning;

class Audit
{
    /**
     * create version for given object
     *
     * @param Content $content
     * @return type
     */
    public static function makeVersion(Content $content)
    {
        $versioning = new Versioning($content);
        $previousVersion = $versioning->save();
        return $previousVersion;
    }

    public static function preVersion(Content $content)
    {
        $versioning = new Versioning($content);
        $previousVersion = $versioning->getPreviousContent();
        return $previousVersion;
    }

    /**
     * get current version of given object
     *
     * @param Content $content
     * @return type
     */
    public static function currentVersion(Content $content)
    {
        $versioning = new Versioning($content);
        $currentVersion = $versioning->getcurrentVersion();
        return $currentVersion;
    }

    /**
     * get latest 2 revisions of passed object type
     *
     * @param Content $content
     * @return type
     */
    public static function diff(Content $content)
    {
        $versioning = new Versioning($content);
        $revisions = $versioning->getLatestDiff();
        return $revisions;
    }

    /**
     * get content revision from revision id
     * @param type $id
     * @return type
     */
    public static function getDiff($id)
    {
        $versioning = new Versioning();
        $revisions = $versioning->getDiff($id);
        return $revisions;
    }

    /**
     * get all revision of given object type
     *
     * @param Content $content
     * @return type
     */
    public static function getContentHistory(Content $content)
    {
        $versioning = new Versioning($content);
        $revisions = $versioning->contentHistory();
        return $revisions;
    }

    /**
     * get history of content base on type
     *
     * @param type $type
     * @return type
     */
    public static function getHistory($type)
    {
        $versioning = new Versioning();
        $revisions = $versioning->getHistory($type);
        return $revisions;
    }

    /**
     * rollback to given version
     *
     * @param type $version
     */
    public static function rollBackToVersion($version)
    {
        $versioning = new Versioning($version);
        $currentVersion = $versioning->rollback($version);
        dd($currentVersion);
    }

    public static function getDiffContent($type, $id)
    {
        $versioning = new Versioning();
        $currentVersion = $versioning->getContentHistory($type, $id);
        return $currentVersion;
    }

    /**
     * get distinct content types list
     *
     * @return type
     */
    public function getContentTypesList()
    {
        $versioning = new Versioning();
        $revisions = $versioning->getContentTypes();
        return $revisions;

    }

}