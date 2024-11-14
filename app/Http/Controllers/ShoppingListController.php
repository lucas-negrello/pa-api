<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use App\Http\Requests\StoreShoppingListRequest;
use App\Http\Requests\UpdateShoppingListRequest;
use App\Models\ShoppingList;

class ShoppingListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', ShoppingList::class);

        $shoppingLists = ShoppingList::all();
        return response()->json($shoppingLists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShoppingListRequest $request)
    {
        Gate::authorize('create', ShoppingList::class);

        $shoppingList = ShoppingList::create($request->validated());
        return response()->json([
            'message' => 'Successfully created shopping list',
            'data' => $shoppingList
        ], ResponseAlias::HTTP_CREATED );
    }

    /**
     * Display the specified resource.
     */
    public function show(ShoppingList $shoppingList)
    {
        Gate::authorize('view', ShoppingList::class);

        return response()->json([
            'message' => 'Successfully found a shopping list',
            'data' => $shoppingList
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShoppingListRequest $request, ShoppingList $shoppingList)
    {
        Gate::authorize('update', ShoppingList::class);

        $shoppingList->update($request->validated());
        return response()->json([
            'message' => 'Successfully updated shopping list',
            'data' => $shoppingList
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingList $shoppingList)
    {
        Gate::authorize('delete', ShoppingList::class);

        $shoppingList->delete();
        return response()->json([
            'message' => 'Successfully deleted shopping list',
            'data' => $shoppingList
        ]);
    }
}
