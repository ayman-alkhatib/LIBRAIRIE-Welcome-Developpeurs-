import { books } from "./data.js"

books.forEach((bookObj) => {
    let myMainElement = document.querySelector(".books")
    let book = document.createElement("li")
    let img = document.createElement("img")
    let title = document.createElement("h3");
    let author = document.createElement("div")
    let price = document.createElement("div");

    // Add the link of the img
    img.src = `./images/books-images/${bookObj.url}`

    // Add book title
    title.append(bookObj.title);

    //add author name
    author.append(bookObj.author)

    // Add price Text
    price.append(`$${bookObj.price}`);

    // Add img to book
    book.append(img)

    // Add title To book
    book.appendChild(title);

    // Add price To book
    book.appendChild(price);


    // Add author to book
    book.appendChild(author)
    // Add id to book bookObj
    book.id = bookObj.id;

    myMainElement.appendChild(book)



})