@extends('base')

@section('main')


<div class="topnav" id="topnav">
  <div >
  	<a style="margin: 5px;" href="/" class="btn btn-info">Home</a>
	  <a style="margin: 5px;" href="/products" class="btn btn-info active">Products</a>
  	<a style="margin: 5px;" href="/recipes" class="btn btn-info">Recipes</a>
  </div>   
</div>

<div class="row">
	<div class="col-sm-12">
    	
		<br>
		<br>
		<div>
			<a style="width: auto; margin-left:40%; " href="{{ route('products.create')}}" class="btn btn-success">Add New Product</a>  	
		</div>
		<br>
		<br>

		<input type="text" size="25" id="search_box" onkeyup="search_box()" placeholder="Search for product or details.." title="Type in a name">
    	<table class="table table-striped" id="products_table" >
      		<thead class="thead-dark">
        		<tr>
					<td><b>Product Name</b> &emsp;</td>
          			<td>
					  	<b><a onclick="sortTable()" style="cursor: pointer; color: black;" >Expiration Date </a></b>
						<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_i_DfXCW6TIqhqYKDvOodMlmfBnO77TefTg&usqp=CAU" 
							 style="height: 10px; width:15px; display: inline;">
						&emsp; 
					</td>
          			<td><b>Quantity</b> &emsp;</td>
					<td><b>Weight</b> &emsp;</td>
					<td><b>Details</b> &emsp;</td>
          			<td colspan = 2><b></b></td>
        		</tr>
    		</thead>
      		<tbody id="products">

			  	@foreach($products as $item)
        			<tr>
		  				<td>{{$item->product_name}}</td>
          				<td>{{$item->exp_date }}</td>
          				<td>{{$item->qty }}</td>
						<td>{{$item->weight }}</td>
						<td>{{$item->details }}</td>
          				<td>
              				<a href="{{ route('products.edit',$item->product_id)}}" class="btn btn-primary">Edit</a>
          				</td>
          				<td>
            				<form action="{{ route('products.destroy', $item->product_id)}}" method="post">
              				@csrf
              				@method('DELETE')
                			<button class="btn btn-danger" type="submit">Delete</button>
              				</form>
          				</td>
        			</tr>
        		@endforeach
      		</tbody>
    	</table>
  	</div>
</div>


<div class="col-sm-12">
	<br>
  	@if(session()->get('success'))
		<div class="alert alert-success">
	  		{{ session()->get('success') }} 
    	</div>
  	@endif
</div>

<br>
<form action="{{ route('CreateQuestion.store') }}" method="post">
  <div class="form-group">
    <label for="1stquestion" style="font-size:18px" >Search for recipes with: </label>
    <input type="text" size="20" id="ingredient" name="ingredient" placeholder="Type an ingredient" >
    <button type="submit" class="btn btn-primary">Search</button>
  </div>
</form>












<!-- Search bar-->
<script>
	function search_box() {
  		let input, filter, tr, td, i, txtValue;
  		input = document.getElementById('search_box');
  		filter = input.value.toUpperCase();
  		tbody = document.getElementById("products");
  		tr = tbody.getElementsByTagName('tr');

  
  		for (i = 0; i < tr.length; i++) {
    		td = tr[i].getElementsByTagName("td")[0];
    		txtValue = td.textContent || td.innerText;
			td2 =  tr[i].getElementsByTagName("td")[4];
			txtValue2 = td2.textContent || td2.innerText;
    		if (txtValue.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1)
      			tr[i].style.display = "";
    		else
      			tr[i].style.display = "none";
		}
	}
</script>


<!-- Sorts The Products By Expiration Date-->
<script>
	function sortTable() {
	  	let table, rows, flag, i, x, y, shouldSwitch;
	  	table = document.getElementById("products_table");
	  	flag = true;
	  	
	  	while (flag) {
	    	flag = false;
	    	rows = table.rows;
	    	for (i = 1; i < (rows.length - 1); i++) {
      			shouldSwitch = false;
      			x = rows[i].getElementsByTagName("TD")[1].innerText;
      			y = rows[i + 1].getElementsByTagName("TD")[1].innerText;
			  	if (x > y) {
       				shouldSwitch = true;
        			break;
    			}
    		}
    		if (shouldSwitch) {
      			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      			flag = true;
    		}

  		}

	}
</script>


<!-- Sorts the products immediately after the loading of the topnav -->
<script>
	document.getElementById("topnav").addEventListener("load", sortTable());
</script>

@endsection
