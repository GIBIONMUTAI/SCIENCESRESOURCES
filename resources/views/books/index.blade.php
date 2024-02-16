@extends('layouts.app')

@section('content')
  <h1 class="mb-10 text-2xl"> SCIENCES RESOURCES</h1>
  <div class="col-lg-7 py-3 py-md-5" >
    <h2 class="mb-10 text-2xl">Greatest Popular Science Books</h2>
    
    <p class="lead task-muted">These great popular science books offer accessible science to readers 
      from all levels of knowledge. There's something here for everyone, whether you're interested in
       environmental science, kitchen chemistry, or just want to try out some fun experiments with
        your kids over the summer. Check out our picks for the best in popular science, and see how 
        you can use them to better understand and explore our world.</p>


  </div>

  <form method="GET" action="{{ route('books.index') }}" class="mb-4 flex items-center space-x-2">
    <input type="text" name="title" placeholder="Search by title"
      value="{{ request('title') }}" class="input h-10" />
    <input type="hidden" name="filter" value="{{ request('filter') }}" />
    <button type="submit" class="btn h-10">Search</button>
    <a href="{{ route('books.index') }}" class="btn h-10">Clear</a>
  </form>

  <div class="filter-container mb-4 flex">
    @php
      $filters = [
          '' => 'Latest',
          'popular_last_month' => 'Popular Last Month',
          'popular_last_6months' => 'Popular Last 6 Months',
          'highest_rated_last_month' => 'Highest Rated Last Month',
          'highest_rated_last_6months' => 'Highest Rated Last 6 Months',
      ];
    @endphp

    @foreach ($filters as $key => $label)
      <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}"
        class="{{ request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item' }}">
        {{ $label }}
      </a>
    @endforeach
  </div>

  <ul>
    @forelse ($books as $book)
      <li class="mb-4">
        <div class="book-item">
          <div
            class="flex flex-wrap items-center justify-between">
            <div class="w-full flex-grow sm:w-auto">
              <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
              <span class="book-author">by {{ $book->author }}</span>
            </div>
            <div>
              <div class="book-rating">
                {{ number_format($book->reviews_avg_rating, 1) }}
              </div>
              <div class="book-review-count">
                out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
              </div>
            </div>
          </div>
        </div>
      </li>
    @empty
      <li class="mb-4">
        <div class="empty-book-item">
          <p class="empty-text">No books found</p>
          <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
        </div>
      </li>
    @endforelse
  </ul>
@endsection