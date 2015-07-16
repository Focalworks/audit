<?php
/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 15/7/15
 * Time: 4:48 PM
 */

namespace Focalworks\Audit;

use Focalworks\Audit\Services\Versioning;

class Audit
{
    public static function makeVersion($contentObj)
    {
        $versioning = new Versioning($contentObj);
        $previousVersion = $versioning->save();
        dd($previousVersion);
    }

    public static function preVersion($contentObj)
    {
        $versioning = new Versioning($contentObj);
        $previousVersion = $versioning->getPreviousContent();
        dd($previousVersion);
    }

    public function latestVersion($contentObj)
    {
        $versioning = new Versioning($contentObj);
        $currentVersion = $versioning->getContent();
        dd($currentVersion);
    }

    public function diff()
    {

    }

    public static function rollBackToVersion($version)
    {
        $versioning = new Versioning($version);
        $currentVersion = $versioning->rollback($version);
        dd($currentVersion);
    }

    public function history()
    {

    }
}