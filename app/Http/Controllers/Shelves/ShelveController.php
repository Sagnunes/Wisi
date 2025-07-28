<?php

namespace App\Http\Controllers\Shelves;

use App\Actions\Shelves\CreateShelve;
use App\Actions\Shelves\DeleteShelve;
use App\Actions\Shelves\GetShelves;
use App\Actions\Shelves\UpdateShelve;
use App\DTOs\ShelveDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shelves\StoreShelvesRequest;
use App\Http\Requests\Shelves\UpdateShelvesRequest;
use App\Models\Shelve;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ShelveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetShelves $action): \Inertia\Response
    {
        return Inertia::render('Shelves/Index', ['shelves' => $action->handle()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShelvesRequest $request, CreateShelve $action): \Illuminate\Http\RedirectResponse
    {
        $createdShelve = $action->handle(ShelveDTO::fromRequest($request->validated()));

        return to_route('shelves.index')->with(['status' => 'Prateleira criada com sucesso.', 'data' => $createdShelve]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shelve $shelve): \Inertia\Response
    {
        return Inertia::render('Shelves/Edit', ['shelve' => $shelve]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShelvesRequest $request, Shelve $shelve, UpdateShelve $action)
    {
        $action->handle($shelve, ShelveDTO::fromRequest($request->validated()));

        return to_route('shelves.edit', $shelve);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shelve $shelve, DeleteShelve $action): \Illuminate\Http\RedirectResponse
    {
        $action->handle($shelve);

        return redirect()->back()->with('status', 'Prateleira eliminada com sucesso.');
    }
}
