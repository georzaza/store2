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
  	<div class="col-sm-5 col-md-offset-2">
    	<h1 class="display-3" style="text-align:center;">Add New Recipe</h1>
  		<div>
    		@if ($errors->any())
	      		<div class="alert alert-danger">
        			<ul>
		            @foreach ($errors->all() as $error)
              		<li>{{ $error }}</li>
            		@endforeach
        		</ul>
    			</div><br />
    		@endif

			<form id=theForm method="post" action="{{ route('recipes.store') }}">
		        @csrf

        		<div class="form-group" style="text-align:center; margin-bottom:6%;">
		            <label for="recipe_name">Recipe Name:(e.g. Spaghetti Marinara)</label><br>
            		<input type="text" class="form-control" name="recipe_name"/>
				</div>

				<div id="formIngredients" class="form-inline">
					<button id="x" type="button" class="btn btn-primary"  onclick="doOnClick()" style="margin-left: 0%;">Add Ingredient</button><br>
				</div><br>			
				
				<div class="form-group" style="text-align:center;">
		            <label for="execution">Execution Instructions:</label><br>
					<textarea wrap="soft" form="theForm" class="form-group" name="execution" style="width:100%; height:80px; "></textarea>
				</div><br>
	
				<div class="form-group" >
        			<button type="submit" class="btn btn-danger" style="margin-left:30%; width: auto; margin-top: 15px;">
			  			Add Recipe
				</div>

				<!-- extends the content of the Ingredients/Qty div (last div above).
					 The labels' and inputs' names are changed accordingly -->
				<script>
					let counter = 0; // used for naming
  					function doOnClick() {
    					let ingredientFormdiv = document.getElementById("formIngredients");	
						let ingredient_input_name = "recipeIngredients".concat(counter.toString());
						ingredient_qty_name = "recipeIngredientQty".concat(counter.toString());
    					ingredientFormdiv.innerHTML += '<br>';
						ingredientFormdiv.innerHTML += '<label for="'.concat(ingredient_input_name).concat('" class="form-group">Ingredient:</label><br>');
						ingredientFormdiv.innerHTML += '<input type="text" class="form-inline" name="'.concat(ingredient_input_name).concat('">');
						ingredientFormdiv.innerHTML += '<label for="'.concat(ingredient_qty_name).concat('" style="margin-left:5%">  Qty: </label>');
						ingredientFormdiv.innerHTML += '<input type="number" step="0.001" min="0" class="form-inline" name="'.concat(ingredient_qty_name).concat('" style="width:100px; display:inline;"> kg/L');
						counter++;
  					}	
  				</script>
      		</form>
  		</div>
	</div>
</div>



@endsection
