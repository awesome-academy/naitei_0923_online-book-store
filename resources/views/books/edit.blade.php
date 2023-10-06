<x-admin-layout>
    <div class="flex justify-center items-center pt-8">
        <div class="w-full max-w-6xl">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">{{ __('Edit Book') }}</h2>

                <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                        <div class="grid grid-cols-2 gap-8">
                            <div class="col-span-1">
                                <div class="mb-4">
                                    <label for="name" class="block font-bold mb-2">{{ __('Name') }}</label>
                                    <input id="name" type="text" class="form-input rounded-lg w-full @error('name') border-red-500 @enderror" name="name" value="{{ old('name', $book->name) }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="block font-bold mb-2">{{ __('Description') }}</label>
                                    <textarea id="description" class="form-input rounded-lg w-full @error('description') border-red-500 @enderror" name="description" required>{{ old('description', $book->description) }}</textarea>
                                    @error('description')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="price" class="block font-bold mb-2">{{ __('Price') }}</label>
                                    <input id="price" type="number" class="form-input rounded-lg w-full @error('price') border-red-500 @enderror" name="price" value="{{ old('price', $book->price) }}" required autocomplete="price">
                                    @error('price')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="publisher" class="block font-bold mb-2">{{ __('Publisher') }}</label>
                                    <input id="publisher" type="text" class="form-input rounded-lg w-full @error('publisher') border-red-500 @enderror" name="publisher" value="{{ old('publisher', $book->publisher) }}" required autocomplete="publisher">
                                    @error('publisher')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="publisher_year" class="block font-bold mb-2">{{ __('Publisher Year') }}</label>
                                    <input id="publisher_year" type="number" class="form-input rounded-lg w-full @error('publisher_year') border-red-500 @enderror" name="publisher_year" value="{{ old('publisher_year', $book->publisher_year) }}" required autocomplete="publisher_year">
                                    @error('publisher_year')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-1">            
                                <div class="mb-4">
                                    <label for="author" class="block font-bold mb-2">{{ __('Author') }}</label>
                                    <input id="author" type="text" class="form-input rounded-lg w-full @error('author') border-red-500 @enderror" name="author" value="{{ old('author', $book->author) }}" required autocomplete="author">
                                    @error('author')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="page_nums" class="block font-bold mb-2">{{ __('Page Numbers') }}</label>
                                    <input id="page_nums" type="number" class="form-input rounded-lg w-full @error('page_nums') border-red-500 @enderror" name="page_nums" value="{{ old('page_nums', $book->page_nums) }}" required autocomplete="page_nums">
                                    @error('page_nums')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="stock" class="block font-bold mb-2">{{ __('Stock') }}</label>
                                    <input id="stock" type="number" class="form-input rounded-lg w-full @error('stock') border-red-500 @enderror" name="stock" value="{{ old('stock', $book->stock) }}" required autocomplete="stock">
                                    @error('stock')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="category" class="block font-bold mb-2">{{ __('Category') }}</label>
                                    <select id="category" name="category[]" class="form-input rounded-lg w-full" multiple>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if(in_array($category->id, $book->categories->pluck('id')->toArray())) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                    </select>
                                    @error('category')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="image" class="block font-bold mb-2">{{ __('Avatar Image') }}</label>
                                    <input type="file" class="form-input rounded-lg w-full" id="image" name="image">
                                </div>

                                <div class="mb-4">
                                    <label for="images" class="block font-bold mb-2">{{ __('More Image') }}</label>
                                    <input type="file" class="form-input rounded-lg w-full" id="images" name="images[]" multiple>
                                </div>
                            </div>
                        </div>

                    <div class="flex items-center justify-center w-full bg-blue-500 hover:bg-blue-700 h-10 rounded-lg">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save Changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
