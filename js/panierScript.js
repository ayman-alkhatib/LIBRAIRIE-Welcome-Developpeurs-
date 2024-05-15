books.forEach((bookObj) => {
    // create element html
    let myMainElement = document.querySelector(".books")
    let book = document.createElement("li")
    let btns = document.createElement("div")



    // start Book images

    let img = document.createElement("img")

    img.src = `../images/books-images/${bookObj.url}` // Add the link of the img

    book.append(img) // Add img to book

    // end Book images

    // start book title

    let title = document.createElement("h3");

    title.append(bookObj.title); // Add book title

    book.appendChild(title); // Add title To book    

    // end book title

    // start book price

    let price = document.createElement("div");

    price.append(`$${bookObj.price}`) // Add price Text

    book.appendChild(price); // Add price To book

    // end book price

    // start book author
    let author = document.createElement("div")

    author.append(bookObj.author) //add author name

    book.appendChild(author) // Add author to book

    // end book author

    // start book btn
    let plusIcon = document.createElement("i")
    let plusBtn = document.createElement("button")
    let moinsIcon = document.createElement("i")
    let moinsBtn = document.createElement("button")
    let count = document.createElement("span")

    count.append(bookObj.price)

    plusIcon.className = "fas fa-circle-plus"  // add icon class 
    moinsIcon.className = "fas fa-circle-minus" // add icon class 

    plusBtn.append(plusIcon)  // add plusBtn icon 
    moinsBtn.append(moinsIcon) // add moinsBtn icon 

    plusBtn.id = bookObj.id // add book id to btns
    moinsBtn.id = bookObj.id // add book id to btns

    btns.appendChild(moinsBtn) // add moinsBtn to btns
    btns.appendChild(count)
    btns.appendChild(plusBtn)  // add plusBtn to btns

    book.append(btns)  // add btns to book

    // end book btn

    // Add id to book bookObj
    book.id = bookObj.id;

    // add book to html ul
    myMainElement.appendChild(book)
})

