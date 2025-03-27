@extends('layouts.app')
@section('content')
<div class="flex flex-col items-center">
  <form action="{{ route('food.update', $food['id']) }}" method="POST" enctype="multipart/form-data" class="w-50">
  @csrf
    @method('PUT')
    <div class="shadow sm:rounded-md sm:overflow-hidden">
      <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div>
          <div class="col-span-3 sm:col-span-2">
            <label for="food name" class="block text-lg font-medium text-gray-700"> Nama Makanan </label>
            <div class="mt-1 flex flex-col rounded-md ">
              <input required value="{{$food['name']}}" type="text" name="name" id="name" class="shadow-sm @error('name') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300" placeholder="Brownies">
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
        </div>

        <div>
          <label for="food description" class="block text-lg font-medium text-gray-700"> Deskripsi </label>
          <div class="mt-1">
            <textarea required id="description" name="description" rows="3" class="@error('description') is-invalid @enderror resize-none p-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-lg border border-gray-300 rounded-md" placeholder="Brownies dengan 5 toping">{{$food['description']}}</textarea>
            @error('description')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div>
          <label for="food price" class="block text-lg font-medium text-gray-700"> Harga </label>
          <div class="mt-1 flex flex-col rounded-md">
              <input required value="{{$food['price']}}" type="number" name="price" id="price" class="shadow-sm @error('price') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300" placeholder="20000">
              @error('price')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
        </div>

        <div>
          <label for="food" class="block text-lg font-medium text-gray-700"> Stok </label>
          <div class="mt-1 flex flex-col rounded-md">
            <input required value="{{$food['stock']}}" type="number" name="stock" id="stock" class="shadow-sm @error('stock') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300" placeholder="20000">
            @error('stock')
            <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div>
          <label for="food type" class="block text-lg font-medium text-gray-700">Tipe Makanan</label>
          <div>
          <select name="type" id="type" class="flex justify-center mt-1 flex rounded-md shadow-sm p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300">
            <option value="Brownies" {{($food['type'] == "Brownies") ? "selected" : ""}}>Brownies</option>
            <option value="Bolu" {{($food['type'] == "Bolu") ? "selected" : ""}}>Bolu</option>
            {{-- <option value="Japanese" {{($food['type'] == "Japanese") ? "selected" : ""}}>Japanese</option> --}}

          </select>
        </div>

        <div class="mt-3">
          <label for="food_picture" class="block text-lg font-medium text-gray-700">Photo</label>
          <div class="mt-1 flex flex-col rounded-md">
            <input type="file" name="picture" id="picture" class="shadow-sm @error('picture') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300">
              @error('picture')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
      </div>
      <div class="px-4 py-3 text-right sm:px-6">
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update</button>
      </div>
    </div>
  </form>
</div>
@endsection
