
@extends('base')

@section('main')

<div class="topnav" id="topnav">
  <div >
  	<a style="margin: 5px;" href="/" class="btn btn-info">Home</a>
	  <a style="margin: 5px;" href="/products" class="btn btn-info">Products</a>
  	<a style="margin: 5px;" href="/recipes" class="btn btn-info active">Recipes</a>
  </div>   
</div>

<br>
<br>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Available Recipes</th>
    </tr>
  </thead>
  <tbody>

    @foreach($items  as $item)
      <tr>
        <th scope="row"> <a href="#">{{$item}}</a></th>
      </tr>
    @endforeach

  </tbody>
</table>
@endsection
