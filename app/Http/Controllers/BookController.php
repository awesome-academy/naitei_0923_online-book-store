<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CategoryBook;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with('medias')->paginate(config('app.paginate_book'));

        return view('books.list', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(BookStoreRequest $request)
    {
        $book = new Book([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'publisher' => $request->input('publisher'),
            'publisher_year' => $request->input('publisher_year'),
            'author' => $request->input('author'),
            'page_nums' => $request->input('page_nums'),
            'stock' => $request->input('stock')
        ]);

        $book->save();

        $book->categories()->attach($request->input('category'));

        if ($request->has('image')) {
            $avatarimage = $request->file('image');

                $url = Storage::disk('public')->put('img', $avatarimage);

                $media = new Media();
                $media->book_id = $book->id;
                $media->link = $url;
                $media->type = config('app.avatar_media_type');

                $media->save();
        }

        if ($request->has('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $url = Storage::disk('public')->put('img', $image);

                $media = new Media();
                $media->book_id = $book->id;
                $media->link = $url;
                $media->type = config('app.normal_media_type');

                $media->save();
            }
        }

        return redirect()->route('books.index')->with('success', __('messages.book_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('books.show', [
            'book' => $book,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $categories = Category::all();

        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookStoreRequest $request, Book $book)
    {
        $book->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'publisher' => $request->publisher,
            'publisher_year' => $request->publisher_year,
            'author' => $request->author,
            'page_nums' => $request->page_nums,
            'stock' => $request->stock
        ]);

        $book->categories()->sync($request->category);

        if ($request->has('image')) {
            Media::where('book_id', '=', $book->id)->where('type', '=', config('app.avatar_media_type'))->delete();
            $avatarimage = $request->file('image');

                $url = Storage::disk('public')->put('img', $avatarimage);

                $media = new Media();
                $media->book_id = $book->id;
                $media->link = $url;
                $media->type = config('app.avatar_media_type');

                $media->save();
        }

        if ($request->has('images')) {
            Media::where('book_id', '=', $book->id)->where('type', '=', config('app.normal_media_type'))->delete();
            $images = $request->file('images');
            foreach ($images as $image) {
                $url = Storage::disk('public')->put('img', $image);

                $media = new Media();
                $media->book_id = $book->id;
                $media->link = $url;
                $media->type = config('app.normal_media_type');

                $media->save();
            }
        }

        return redirect()->route('books.show', $book)->with('success', __('Book updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        try {
            CategoryBook::where('book_id', $book->id)->delete();

            Media::where('book_id', $book->id)->delete();

            Cart::where('book_id', $book->id)->delete();

            $book->delete();

            return response()->json(['message' => __('Book deleted successfully')], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('Failed to delete the book')], 500);
        }
    }

    public function search(Request $request)
    {
        $categories = Category::all();
        $searchTerm = $request->input('input-search');
        $category = $request->input('category');
        $sort = $request->input('sort');

        $books = Book::leftJoin('reviews', 'books.id', '=', 'reviews.book_id')
                    ->select('books.*', DB::raw('AVG(reviews.rating) as average_rating'))
                    ->groupBy('books.id');

        if ($category !== 'all') {
            $books->join('category_book', 'books.id', '=', 'category_book.book_id')
                ->where('category_book.category_id', $category);
        }

        if ($searchTerm) {
            $books->where('name', 'like', '%' . $searchTerm . '%');
        }

        switch ($sort) {
            case 'name_asc':
                $books->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $books->orderBy('name', 'desc');
                break;
            case 'rating':
                $books->orderByDesc('average_rating');
                break;
            case 'price_asc':
                $books->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $books->orderBy('price', 'desc');
                break;
            default:
                break;
        }

        $books = $books->paginate(config('app.paginate_book'));

        return view('search', compact('books', 'searchTerm', 'categories', 'category', 'sort'));
    }
}
