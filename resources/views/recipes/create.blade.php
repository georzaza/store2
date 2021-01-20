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

		<form id=theForm method="post" action="{{ route('recipes.store') }}">
	        @csrf


       		<div class="form-group" style=" margin-bottom:6%;">
	            <label for="recipe_name">Recipe Name:(e.g. Spaghetti Marinara)</label><br>
           		<input type="text" class="form-control" name="recipe_name"/>
			</div>
			
			<div class="form-group">
	            <label for="execution">Execution Instructions:</label><br>
				<textarea wrap="soft" form="theForm" class="form-group" name="execution" style="width:100%; height:85px; margin-bottom: 0%;"></textarea>
			</div><br>
			
      		<div class="form-group" id="formIngredients">
			  	<label for="recipeIngredients0" style="width:290px; display:inline-block; ">Ingredients</label>
      			<label for="recipeIngredientQty0" style="width:80px; display:inline-block; text-align: center;">Quantity</label>
				<input type="text" class="form-control" name="recipeIngredients0" style="width:290px; display:inline-block; ">
        		<input type="number" class="form-control" name="recipeIngredientQty0" style="width:80px; display:inline-block;">
        		<!--<button type="button" class="btn btn-danger" onclick="addIngredient()">-</button>-->
				<button id="minus-button-0" type="button" style="display: inline-block; " onclick="removeUnusedIngredient(this.id)" class="btn btn-info">-</button>
      		</div>
			<button id="plus-button" type="button" style="display: inline-block; " class="btn btn-info"  onclick="addIngredient()">+</button>
      		<br>
			
			<div class="form-group" >
       			<button type="submit" class="btn btn-primary" style="margin-left:37%; width: auto; margin-top: 15px;">
		  			Add Recipe
				</button>
			</div>

   		</form>
	</div>
</div>


<!-- 
	
	This script's main functionality is to provide a dynamic form for the ingredients, 
	while keeping the frontend clean and nice.
	Since we have buttons for when the user adds a new ingredient, we mess around with these
	buttons. The counter is used to set the id names of any input or button elements that are 
	relative to the ingredients.
	Warning: This code is a little bit complex and what we do below could probably be done 
	with a faster and cleaner way.-->
<script>
	let counter = 1;
	 
	function addIngredient() {
	   
		// get the form
		let ingredientFormdiv = document.getElementById("formIngredients");
		
		let theButton = document.getElementById("minus-button-".concat((counter-1).toString()));
		//ingredientFormdiv.removeChild(theButton);
		//ingredientFormdiv.insertAdjacentHTML('beforeend', '<button type="button" style="display: inline-block; " class="btn btn-info"  >-</button>');
		
		//let theButton = document.getElementById("button0");
		//ingredientFormdiv.removeChild(theButton);
		

		// the name of the inputs.
		let ingredient_input_name = "recipeIngredients".concat(counter.toString());
		ingredient_qty_name = "recipeIngredientQty".concat(counter.toString());
		
		let HTMLcode = '<br><input type="text" class="form-control" style="width:290px; display:inline-block;" ';
		HTMLcode +=	'name="'.concat(ingredient_input_name).concat('" required>');
		
		HTMLcode += '<input type="number" step="0.001" min="0" class="form-control" style="width:80px; display:inline-block;" ';
		HTMLcode += 'name="'.concat(ingredient_qty_name).concat('" required>');

		HTMLcode += '<button id="minus-button-'.concat(counter.toString()).concat('" ');
		HTMLcode += 'type="button" style="display: inline-block;" class="btn btn-info"  onclick="removeUnusedIngredient(this.id)">-</button>';

		// A reaally long line. We insert a new Ingredient and a new Qty inputs with this line, BY KEEPING 
		// the values of the inputs we had before. This is possible ONLY with the use of the insertAdjustHTML function.
		ingredientFormdiv.insertAdjacentHTML('beforeend', HTMLcode);

		// Lastly, add a + button at the last line and after that a - button.
		//ingredientFormdiv.insertAdjacentHTML('beforeend', '<button id="button'.concat(counter.toString()).concat('"type="button" style="display: inline-block;" class="btn btn-info"  onclick="addIngredient()">+</button>'));
		//ingredientFormdiv.insertAdjacentHTML('beforeend', '<button id="button'.concat(counter.toString()).concat('"type="button" style="display: inline-block;" class="btn btn-info" >-</button>'));
		counter++;
	}

	function removeUnusedIngredient(id)	{
		let ingredientFormdiv = document.getElementById("formIngredients");
		let inputs = ingredientFormdiv.getElementsByClassName("form-control");

		for (let i=0; i<inputs.length; i++)	{
  			if (inputs[i].name == "recipeIngredients".concat( (id.split('-'))[2]) )
				ingredientFormdiv.removeChild(inputs[i]);
			if (inputs[i].name == "recipeIngredientQty".concat( (id.split('-'))[2]) )	
				ingredientFormdiv.removeChild(inputs[i]);
		}
		ingredientFormdiv.removeChild(document.getElementById(id));
	}

</script>



@endsection


