<?php

namespace App\Http\Controllers;

use App\Events\QuizChange;
use App\Events\QuizCreate;
use App\Events\QuizDelete;
use App\Http\Requests\QuizChangeRequest;
use App\Http\Requests\QuizCreateRequest;
use App\Http\Requests\QuizDeleteRequest;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QuizzesController extends Controller
{
    public function index(Request $request)
    {
        return Quiz::paginatedResources($request, function (Builder $query) {
            $query->withCount('items');
        });
    }

    public function show(Request $request, $id)
    {
        return Quiz::resource($id, $request, function (Builder $query) {
            $query->withCount('items');
        });
    }

    public function create(QuizCreateRequest $request)
    {
        return QuizCreate::handleEvent(null, $request->all());
    }

    public function change(QuizChangeRequest $request, $id)
    {
        return QuizChange::handleEvent($id, $request->all());
    }

    public function delete(QuizDeleteRequest $request, $id)
    {
        return QuizDelete::handleEvent($id, $request->all());
    }
}
