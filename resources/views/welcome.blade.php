<x-app-layout>
    <div class="mb-4">
        <img class="w-full object-cover h-96" src="{{ asset('/storage/background.jpg') }}" alt="Dashboard Cover">
    </div>

    <form action="{{ route('search') }}" method="GET" class="my-4 flex justify-center items-center">
        <input name="input-search" type="text" class="p-2 border border-gray-300 rounded-lg w-1/2 mr-2" placeholder="{{ __('Search...') }}" id="searchInput">
        <select name="category" class="w-64 p-2 border border-gray-300 rounded-lg mr-2" id="categorySelect">
            <option value="all">{{ __('Category') }}</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <label for="sortSelect">{{ __('Sort by') }}:</label>
            <select name="sort" id="sortSelect" class="w-48 p-2 border border-gray-300 rounded-lg">
                <option value="name_asc">{{ __('Name A-Z') }}</option>
                <option value="name_desc">{{ __('Name Z-A') }}</option>
                <option value="rating">{{ __('Rating') }}</option>
                <option value="price_asc">{{ __('Price Low-High') }}</option>
                <option value="price_desc">{{ __('Price High-Low') }}</option>
            </select>
        <button type="submit" class="p-2 bg-blue-500 text-white rounded-lg" id="searchButton">{{ __('Search') }}</button>
    </form>

    <div class="grid grid-cols-4 gap-5 justify-center mx-72" id="bookList">
        @foreach ($books as $book)
            <div class="w-64 h-80 px-6 py-4 rounded-lg overflow-hidden shadow-lg bg-white flex flex-col items-center mx-auto">
                @php
                    $avtMedia = $book->medias->where('type', '=', config('app.avatar_media_type'))->first();
                    $imageUrl = $avtMedia ? asset(Storage::url($avtMedia->link)) : asset('storage/default.jpg');
                @endphp
                <img class="w-32 h-32 object-cover" src="{{ $imageUrl }}" alt="{{ $book->name }}">                
                <div class="flex flex-col justify-between text-center">
                    <div class="flex flex-col justify-between h-24">
                        <a href="books/{{$book->id}}" class="font-bold text-xl mb-2">{{ $book->name }}</a>
                        <p class="text-gray-700 text-base">{{ __('Rating') }} {{ number_format($book->average_rating, 1) }}</p>
                        <p class="text-gray-700 text-lg text-red-600 font-semibold">$ {{ $book->price }}</p>
                    </div>
                    @if ($book->stock != 0)
                        <form class="add-to-cart-form" data-book-id="{{ $book->id }}">
                            @csrf
                            <x-button class="px-4 text-white rounded-lg bg-blue-500 hover:bg-blue-700 focus:outline-none addToCartButton">
                                {{ __('Add To Cart') }}
                            </x-button>
                        </form>
                    @else
                        <p class="text-xl bg-red-300 rounded-lg p-1 text-gray-50">{{ __('Currently out of stock') }}</p>
                    @endif
                    <div class="error-info" id="error-info-{{ $book->id }}"></div>
                    <div class="success-info" id="success-info-{{ $book->id }}"></div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="my-8 flex justify-center items-center">
        {{ $books->links() }}
    </div>

</x-app-layout>

<script src="{{ asset('js/dashboard.js') }}" defer></script>
<script src="{{ asset('js/book.js') }}"></script>
