<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sample\AdminRequest;
use App\Http\Requests\Sample\ClientRequest;
use App\Http\Requests\Sample\ManagerRequest;
use App\Http\Requests\Sample\MasterAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SampleController extends Controller{

    public function masterAdmin(MasterAdminRequest $request)
    {
        return 'Master Admin Page';
    }

    public function admin(AdminRequest $request)
    {
        return 'admin page';
    }

    public function manager(ManagerRequest $request)
    {
        return 'manager';
    }

    public function client(ClientRequest $request)
    {
        return 'client';
    }
    
}
