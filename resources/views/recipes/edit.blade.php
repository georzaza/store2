@extends('base')

@section('main')


<div class="topnav">
  <div >
  	<a style="margin: 5px;" href="/" class="btn btn-info">Home</a>
	  <a style="margin: 5px;" href="/products" class="btn btn-info">Products</a>
  	<a style="margin: 5px;" href="/recipes" class="btn btn-info active">Recipes</a>
  </div>   
</div>


<div class="row">
  	<div class="col-sm-8 col-md-offset-2">
    	
		<h1 class="display-3" style="text-align:center;">Update a recipe</h1>
    	
		@if ($errors->any())
	      	<div class="alert alert-danger">
        		<ul>
		           	@foreach ($errors->all() as $error)
            			<li>{{ $error }}</li>
            		@endforeach
        		</ul>
			</div>
			<br/>
    	@endif

		<form id=theForm method="post" action="{{ route('recipes.update', $recipe->recipe_id) }}">
			@method('PATCH')
			@csrf

        	<div class="form-group" style="text-align:center;">
	            <label for="recipe_name">Recipe Name:<br></label><br>
        		<input type="text" class="form-control" name="recipe_name" value="{{$recipe->recipe_name}}">
			</div>
			<br>
       		<div class="form-group" style="text-align:center;">
	            <label for="execution">Execution Instructions:</label><br>
           		<textarea  form="theForm" class="form-control" name="execution" style="width: 750px; height:auto;" value="{{$recipe->execution}}" >
				</textarea>
			</div>
			<br>
			<div id="formIngredients" class="form-group" style="text-align:center;">
			  	<label for="recipeIngredients0" style="width:250px;  ">Ingredient:</label>
				<input type="text" class="form-control" name="recipeIngredients0" style="width:250px; display: inline; text-align:center;">
				<br>
				<label for="recipeIngredientQty0" style="width:250px; ">  Qty:</label>
       			<input type="number" step="0.001" min=0 class="form-control" name="recipeIngredientQty0" style="width:250px; display: inline; text-align:center;">
			</div>

			<button type="button" class="btn btn-info"  onclick="doOnClick()" style="margin-left:48%; margin-right:50%; margin-top:7px;">+</button>
			<br>
			<button type="submit" class="btn btn-primary" style="margin-left:42%;  margin-top:15px; ">
				Update recipe
			</button>

			<!-- extends the content of the Ingredients/Qty div (last div above).
				 The labels' and inputs' names are changed accordingly -->
      	</form>
  	</div>
</div>



<script>
	let counter = 1; // used for naming
	function doOnClick() {
		let ingredientFormdiv = document.getElementById("formIngredients");
		let ingredient_input_name = "recipeIngredients".concat(counter.toString());
		ingredient_qty_name = "recipeIngredientQty".concat(counter.toString());
		ingredientFormdiv.innerHTML += '<br>';
		ingredientFormdiv.innerHTML += '<label for="'.concat(ingredient_input_name).concat('" style="width:250px;  ">Ingredient: </label>');
		ingredientFormdiv.innerHTML += '<input type="text" class="form-control" name="'.concat(ingredient_input_name).concat('" style="width:250px; display:inline; "><br>');
		ingredientFormdiv.innerHTML += '<label for="'.concat(ingredient_qty_name).concat('" style="width:250px;  ">  Qty: </label> ');
		ingredientFormdiv.innerHTML += '<input type="number" step="0.001" min=0 class="form-control" name="'.concat(ingredient_qty_name).concat('" style="width:250px; display:inline; ">');
		counter++;
	}
</script>


@endsection
