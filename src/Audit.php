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

    public static function currentVersion(Content $content)
    {
        $versioning = new Versioning($content);
        $currentVersion = $versioning->getcurrentVersion();
        return $currentVersion;
    }

    public static function diff(Content $content)
    {
        $versioning = new Versioning($content);
        $revisions = $versioning->getLatestDiff();
        return $revisions;
    }

    public static function getHistory(Content $content)
    {
        $versioning = new Versioning($content);
        $revisions = $versioning->contentHistory();
        return $revisions;
//        dump($content->getContentType());
//        dump($content->id);
//        dd();
    }

   public static function rollBackToVersion($version)
   {
       $versioning = new Versioning($version);
       $currentVersion = $versioning->rollback($version);
       dd($currentVersion);
   }

}