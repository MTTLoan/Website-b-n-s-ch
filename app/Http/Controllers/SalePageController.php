<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SalePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showBookDetails($book_title_id)
    {
        $booktitle = DB::table('booktitles')->where('id', $book_title_id)->first();

        $books = DB::table('books')
            ->where('book_title_id', $book_title_id)
            ->select(
                'id',
                'publishing_year',
                'unit_price',
                'cost',
                'cover',
                'quantity',
                'page_number'
            )
            ->orderBy('publishing_year', 'asc')
            ->get();

        $images = DB::table('images')
            ->whereIn('book_id', $books->pluck('id'))
            ->get();

        $review_score = DB::table('reviews')
            ->whereIn('book_id', $books->pluck('id')->toArray())
            ->select(
                DB::raw('AVG(score) as review_score'),
                DB::raw('COUNT(*) as review_count')
            )
            ->first();

        $customer_reviews = DB::table('reviews')
            ->join('orders', 'reviews.order_id', '=', 'orders.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->whereIn('book_id', $books->pluck('id')->toArray())
            ->select(
                'customers.name as customer_name',
                'reviews.score as review_score',
                'reviews.description as review_comment', // Đảm bảo rằng tên cột đúng
                'reviews.created_at as review_date'
            )
            ->get();

        return view('ChiTietSanPham', compact('booktitle', 'books', 'images', 'review_score', 'customer_reviews'));
    }

    public function showBookByType($booktype_id)
    {
        // Lấy tên thể loại sách
        $booktypeName = DB::table('booktypes')
            ->select('name')
            ->where('id', $booktype_id)
            ->first()
            ->name;

        // Lấy thông tin sách dựa vào thể loại
        $books = DB::table('booktypes')
            ->distinct()
            ->select([
                'booktypes.id as booktype_id',
                'booktypes.name as booktype_name',
                'books.id as book_id',
                'booktitles.name as book_name',
                'books.cost as price',
                'saled_books.total_quantity as quantity',
            ])
            ->join('booktitles', 'booktitles.book_type_id', '=', 'booktypes.id')
            ->join('books', 'books.book_title_id', '=', 'booktitles.id')
            ->join('order_details', 'order_details.book_id', '=', 'books.id')
            ->joinSub(
                DB::table('order_details')
                    ->select('books.id as saledbook_id', DB::raw('SUM(order_details.quantity) as total_quantity'))
                    ->join('books', 'books.id', '=', 'order_details.book_id')
                    ->groupBy('books.id'),
                'saled_books',
                'books.id',
                '=',
                'saled_books.saledbook_id'
            )
            ->where('booktypes.id', $booktype_id)
            ->get();

        // Lấy ảnh của lần lượt các sách trả về
        $images = [];
        foreach ($books as $b) {
            $image = DB::table('images')
                ->select('images.url as image_url')
                ->where('images.book_id', '=', $b->book_id)
                ->get()
                ->first();
            $images[$b->book_id] = $image ? $image->image_url : null;
        }
        // dd($images);
        return view('VanHoc_DanhMuc', compact(['booktypeName', 'books', 'images']));
    }
}
