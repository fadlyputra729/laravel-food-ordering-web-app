<?php
if (session('cart') == null) {
  session()->put('cart', array());
}
?>
@extends('layouts.app')
@section('content')
  <div class="hidden flex w-full justify-center items-center" id="message-modal"
       data-object="{{ Session::get('unauthorized')}}">
    <div class="px-4 py-2 mb-4 mx-2 bg-red-100 w-8/12 flex">
      <p id="message-content" class="text-red-800 flex-grow m-auto font-semibold"></p>
      <button type="button" class="close text-lg" id="close">x</button>
    </div>
  </div>

  <div class="container px-4 mx-auto">
    <div class="row align-items-center g-3 py-3">
      <!-- Filter By Category -->
      <div class="col-12 col-md-6">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2">
          <span class="fw-bold me-2">Filter By:</span>
          <div class="d-flex flex-wrap gap-2">
            <a href="/" class="btn btn-outline-secondary btn-sm py-1 px-3 rounded-pill">All</a>
            <a href="/home/Brownies" class="btn btn-outline-secondary btn-sm py-1 px-3 rounded-pill">Brownies</a>
            <a href="/home/Bolu" class="btn btn-outline-secondary btn-sm py-1 px-3 rounded-pill">Bolu</a>
          </div>
        </div>
      </div>

      <!-- Sort By Price -->
      <div class="col-12 col-md-6">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 justify-content-md-end">
          <span class="fw-bold me-2">Urutkan Berdasarkan Harga:</span>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('home.index', ['asc' => true]) }}" class="btn btn-outline-secondary btn-sm py-1 px-3 rounded-pill">Terendah</a>
            <a href="{{ route('home.index', ['asc' => false]) }}" class="btn btn-outline-secondary btn-sm py-1 px-3 rounded-pill">Tertinggi</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-5">
    @foreach($foods as $data)
      <div class="food-item rounded-md overflow-hidden shadow-md border-1 border-gray-100">
        <a href="../food/{{$data['id']}}">
          <img class="h-48 w-full object-cover" src="{{ asset($data->picture) }}" alt="Food Image">
          <div class="overlay">
            <div class="p-4">
              <div class="font-bold text-xl mb-2">{{$data['name']}}</div>
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>

  <div class="p-5">
    {{$foods -> appends(request()->input()) ->  links()}}
  </div>

  <script type="text/javascript">
    function docReady(fn) {
      if (document.readyState === "complete" || document.readyState === "interactive") {
        fn;
      } else {
        document.addEventListener("DOMContentLoaded", fn);
      }
    }

    docReady(() => {
      const modal = document.getElementById('message-modal');
      const content = document.getElementById('message-content');
      const closeBtn = document.getElementById('close');

      if (modal.dataset.object != '') {
        modal.classList.remove('hidden');
        content.innerHTML = modal.dataset.object
      }

      closeBtn.addEventListener('click', function (e) {
        modal.classList.add('hidden');
      })
    })
  </script>
@endsection
