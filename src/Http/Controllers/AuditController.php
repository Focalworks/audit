<?php

/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 15/7/15
 * Time: 5:20 PM
 */

namespace Focalworks\Audit\Http\Controllers;

use App\Http\Controllers\Controller;
use Focalworks\Audit\Audit;
use Illuminate\Support\Facades\Config;

class AuditController extends Controller
{
    /**
     * Template which will be used as master template.
     *
     * @var null
     */
    protected $template = null;


    /**
     * constructor
     */
    public function __construct()
    {
        // setting up the master template if configure
        // or else it will be blank.
        if (Config::get('audit.master_template') != "") {

            $this->template = Config::get('audit.master_template');
        }
    }

    /**
     * This will display versions of all object based on its type
     * if null it displays all data
     *
     * @param null $type
     * @return $this
     */
    public function history($type = null)
    {
        $data = Audit::getHistory($type);
        return view('audit::history')
            ->with('historyData', $data)
            ->with('template', $this->template);
    }

    /**
     * This will display view for version diff from version id
     * (called from histroy list)
     *
     * @param $id
     * @return $this
     */
    public function diff($id)
    {
        $data = Audit::getDiff($id);
        return view('audit::diff')
            ->with('data', $data)
            ->with('template', $this->template);
    }

    /**
     * This will display diff from type and content id
     *
     * @param $type
     * @param $id
     * @return $this
     */
    public function audit($type, $id)
    {
        $data = Audit::getDiffContent($type, $id);
        return view('audit::history')
            ->with('historyData', $data)
            ->with('template', $this->template);
    }
}