import { useBook } from "@/composables/book";
import { usePriceCalculator } from "@/composables/priceCalculator";
import { BookFormats } from "@/enums/bookFormats";

export class CartItem {
    constructor(book, bookFormat)
    {
        this.bookId = book.id;
        this.bookName = book.name;
        this.bookFormat = bookFormat;
        this.quantity = 1;
        this.bookCoverImageUrl = book.coverImageUrl;

        const selectedFormatData = useBook(book).getFormatData(bookFormat);
        this.price = selectedFormatData.price;
        this.discount = selectedFormatData.discount;
        this.maxQuantity = selectedFormatData.quantity ?? 1;        
    }

    compare(other)
    {
        return this.bookId === other.getBookId() && this.bookFormat === other.getBookFormat();
    }

    getBookId()
    {
        return this.bookId;
    }

    increaseQuantity() 
    {
        if (this.bookFormat === BookFormats.Paper && this.quantity < this.maxQuantity) {
            this.quantity++;
        } else {
            throw new Error('Invalid book format or max quantity count reached');
        }
    }

    decreaseQuantity() 
    {
        if (this.quantity <= 1) {
            throw new Error('Quantity should be more or equal 1');
        }
        
        this.quantity--;
    }

    getBookName() 
    {
        return this.bookName;
    }

    getQuantity()
    {
        console.log('try to get quanityt,', this.quantity);
        return this.quantity;
    }

    setPrice(price) 
    {
        if (price < 0) {
            throw new Error('Price can not be negative');
        }

        this.price = price;
    }

    getPrice() 
    {
        return (this.price * this.quantity).toFixed(2);
    }

    getPriceWithDiscount() 
    {
        return (this.quantity * usePriceCalculator().calculate(this.price, this.discount)).toFixed(2);
    }

    setDiscount(discount) 
    {
        if (discount > 100 || discount < 0) {
            throw new Error('Discount should be in [0,100] range');
        }

        this.discount = discount;
    }

    getDiscount()
    {
        return this.discount;
    }

    getBookFormat() {
        return this.bookFormat;
    }

    getCoverImageUrl() {
        return this.bookCoverImageUrl;
    }
}