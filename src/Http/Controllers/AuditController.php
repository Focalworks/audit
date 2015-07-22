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
     *
     */
    public function __construct()
    {
        // setting up the master template if configure
        // or else it will be blank.
        if (Config::get('audit.master_template') != "") {

            $this->template = Config::get('audit.master_template');
        }
    }

    public function history($type = null)
    {
        $data = Audit::getHistory($type);
        return view('audit::history')->with('historyData', $data)
            ->with('template', $this->template);
    }

    public function diff($id)
    {
        $data = Audit::getDiff($id);
        return view('audit::diff')->with('data', $data)
            ->with('template', $this->template);
    }

    public function audit($type, $id)
    {
        $data = Audit::getDiffContent($type, $id);
        return view('audit::history')
            ->with('historyData', $data)
            ->with('template', $this->template);
    }
}