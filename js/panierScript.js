books.forEach((bookObj) => {
    let myMainElement = document.querySelector(".books")
    let book = document.createElement("li")
    let img = document.createElement("img")
    let title = document.createElement("h3");
    let author = document.createElement("div")
    let price = document.createElement("div");
    let btns = document.createElement("div")
    let plusIcon = document.createElement("i")
    let plusBtn = document.createElement("button")
    let moinsIcon = document.createElement("i")
    let moinsBtn = document.createElement("button")


    // Add the link of the img
    img.src = `../images/books-images/${bookObj.url}`

    // Add book title
    title.append(bookObj.title);

    //add author name
    author.append(bookObj.author)

    // Add price Text
    price.append(`$${bookObj.price}`);

    // add icon class 
    plusIcon.className = "fas fa-circle-plus"

    // add icon class 
    moinsIcon.className = "fas fa-circle-minus"

    // add plusBtn icon 
    plusBtn.append(plusIcon)

    // add moinsBtn icon 
    moinsBtn.append(moinsIcon)

    // Add img to book
    book.append(img)

    // Add title To book
    book.appendChild(title);

    // Add price To book
    book.appendChild(price);

    // Add author to book
    book.appendChild(author)

    // add moinsBtn to btns
    btns.appendChild(moinsBtn)

    // add plusBtn to btns
    btns.appendChild(plusBtn)

    // add btns to book
    book.append(btns)

    // Add id to book bookObj
    book.id = bookObj.id;

    myMainElement.appendChild(book)
})