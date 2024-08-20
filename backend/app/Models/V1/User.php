<?php

namespace App\Models\V1;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\BookFormat;
use App\Enums\UserRole;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\Review;
use App\Models\V1\Orders\Order;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'phone_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRole::class,
    ];

    // protected function phoneNumber(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $number) => $number,
    //         set: fn (string $number) => preg_match("/\+380\d{9}$/", $number) ? $number : "+38".$number
    //     );
    // }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function likedBooks(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'liked_books');
    }

    public function likeBook(Book $book): void
    {
        DB::table('liked_books')->insert([
            'user_id' => $this->id,
            'book_id' => $book->id,
        ]);
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isEditor(): bool
    {
        return $this->role === UserRole::Editor;
    }

    public function isCustomer(): bool
    {
        return $this->role === UserRole::Customer;
    }

    public function isGuest(): bool
    {
        return $this->role === UserRole::Guest;
    }

    public function getElectronicBooks(): Collection
    {
        return $this->getBooksWithFormat(BookFormat::Electronic);
    }

    public function getAudioBooks(): Collection
    {
        return $this->getBooksWithFormat(BookFormat::Audio);
    }

    private function getBooksWithFormat(BookFormat $format) : Collection 
    {
        return Book::query()
            ->join('book_order', 'book_order.book_id', '=', 'books.id')
            ->join('orders', 'book_order.order_id', '=', 'orders.id')
            ->where('book_order.book_format', $format)
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('users.id', $this->id)
            ->get([
                'book_id as id',
                'name', 
                'description', 
                'publication_year', 
                'language', 
                'cover_image_url', 
                'published_at',
                'publisher_id',
                'category_id'
            ]);
    }
}
