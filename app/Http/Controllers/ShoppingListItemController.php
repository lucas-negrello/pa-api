<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use App\Http\Requests\StoreShoppingListItemRequest;
use App\Http\Requests\UpdateShoppingListItemRequest;
use App\Models\ShoppingListItem;

class ShoppingListItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shoppingListItems = ShoppingListItem::all();
        return response()->json($shoppingListItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShoppingListItemRequest $request)
    {
        $shoppingListItem = ShoppingListItem::create($request->validated());
        return response()->json([
            'message' => 'ShoppingListItem created successfully',
            'data' => $shoppingListItem,
        ], ResponseAlias::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(ShoppingListItem $shoppingListItem)
    {
        return response()->json([
            'message' => 'ShoppingListItem retrieved successfully',
            'data' => $shoppingListItem,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShoppingListItemRequest $request, ShoppingListItem $shoppingListItem)
    {
        $shoppingListItem->update($request->validated());
        return response()->json([
            'message' => 'ShoppingListItem updated successfully',
            'data' => $shoppingListItem,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingListItem $shoppingListItem)
    {
        $shoppingListItem->delete();
        return response()->json([
            'message' => 'ShoppingListItem deleted successfully',
            'data' => $shoppingListItem,
        ]);
    }
}
