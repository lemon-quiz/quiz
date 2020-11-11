<?php

namespace App\Http\Controllers;

use App\Events\InstanceCreate;
use App\Http\Requests\InstanceCreateRequest;
use App\Models\Instance;
use App\Models\Quiz;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class InstancesController extends Controller
{
    public function index(Request $request)
    {
        return Instance::paginatedResources($request, function (Builder $query) {
            $query->withCount('answers');
        });
    }

    public function show(Request $request, $id)
    {
        return Instance::resource($id, $request, function (Builder $query) {
            $query->withCount('answers');
        });
    }

    public function create(InstanceCreateRequest $request)
    {
        return InstanceCreate::handleEvent(null, $request->all());
    }
}
