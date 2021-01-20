<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// We execute a join and pass the recipes table and 
		// the result of the join to our view in order to be able
		// to handle the data in our view.
		//
		// We should do tricks in our view to not diplay the same 
		// recipe again and again for different ingredients..
		// Check the resources/views/recipes/index.blade.php for the 
		// corresponding code of this view.
		$items = DB::table('recipes')
					->join('ingredients', 'recipes.recipe_id', '=', 'ingredients.recipe')
					->select('recipe_name', 'execution', 'ingredient_name', 'qty', 'recipe')
					->get();
		$recipes = Recipe::all();
		//dd($items);
		return view('recipes.index', ['items' => $items, 'recipes' => $recipes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
		// Save the recipe, without ingredients.
		// We do this first as we need it's id for the ingredient table.
        $request->validate([
			'recipe_name'	=> 'required', 
			'execution'		=> 'required'
		]);
        $recipe = new Recipe([
			'recipe_name'	=> $request->get('recipe_name'), 
			'execution'		=> $request->get('execution')
        ]);
		$recipe->save();
		
		
		// Next we save the ingredients of the recipe.
		// For every ingredient of the request, we
		// create a new ingredient entry in our table, 
		// save it's name and qty based on request, 
		// and associate it's foreign key recipe_id with the recipe 
		// we saved earlier.
		$counter = 0;
		while($request->has('recipeIngredients'.strval($counter))  &&
			  $request->has('recipeIngredientQty'.strval($counter)))	{
			
			$request->validate([
				'recipeIngredients'.strval($counter) => 'required', 
				'recipeIngredientQty'.strval($counter) => 'required|regex:/^\d+(\.\d{1,2})?$/'
			]);
			
			$ingredient = new Ingredient([
				'ingredient_name' => $request->get('recipeIngredients'.strval($counter)), 
				'qty' => $request->get('recipeIngredientQty'.strval($counter)), 
				'recipe' => $recipe->recipe_id
			]);
			
			$ingredient->save();
			$counter++;
		}

        return redirect('/recipes')->with('success', 'recipe saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recipe = Recipe::find($id);
        return view('recipes.edit', compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		// validate the fields required for the recipe.
        $request->validate([
			'recipe_name'	=> 'required', 
			'execution'		=> 'required'
		]);
		// What follows is an alternate implementation of how
		// to update a recipe and it's ingredients.
		// First of all, we could update the recipe with 
		// something like this:
		//
		// DB::table('recipes')
		// 		->where('recipe_id', $recipe->recipe_id)
		//		->update([
		//			'recipe_name' => $request->get('recipe_name'),
		//			'execution'   => $request->get('execution'),
		//		]);
		//
		// Also, instead of querying for all the ingredients, deleting them
		// and then adding new ones, as we do below, we should probably
		// first check if the new ingredients entered are the same as the 
		// old ones, and if not, only then to remove the old unused and 
		// insert the new ones, with a similar statement as we gave for
		// updating the recipe in this comment section.
		// Nevertheless, what we did works fine for this project.

		// get the recipe that we are updating, 
		// update it's values and save it.
		$recipe = Recipe::find($id);
		$recipe->recipe_name = $request->get('recipe_name');
		$recipe->execution	 = $request->get('execution');
		$recipe->save();
		
		// Delete all the ingredients the old recipe had.
		$ingredients = DB::table('ingredients')->where('recipe', '=', $id)->get();
		foreach ($ingredients as $ingredient)	{
			$ingredient = Ingredient::find($ingredient->ingredient_id);
			$ingredient->delete();
		}

		// Insert the new ingredients of the recipe (as in store())
		$counter = 0;
		while($request->has('recipeIngredients'.strval($counter))  &&
			  $request->has('recipeIngredientQty'.strval($counter)))	{
			
			$request->validate([
				'recipeIngredients'.strval($counter) => 'required', 
				'recipeIngredientQty'.strval($counter) => 'required|regex:/^\d+(\.\d{1,2})?$/'
			]);
			
			$ingredient = new Ingredient([
				'ingredient_name' => $request->get('recipeIngredients'.strval($counter)), 
				'qty' => $request->get('recipeIngredientQty'.strval($counter)), 
				'recipe' => $recipe->recipe_id
			]);
			
			$ingredient->save();
			$counter++;
		}

        return redirect('/recipes')->with('success', 'recipe updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		// deletes the recipe. 
		// In our migration file, we declare the 'recipe' foreign key
		// of the table ingredients in a way that when a recipe is removed, 
		// all it's ingredients will be removed too. (onDelete('CASCADE'))
        $recipe = Recipe::find($id);
        $recipe->delete();
        return redirect('/recipes')->with('success', 'recipe deleted!');
	}

}
