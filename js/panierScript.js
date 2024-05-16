let booksId = [0, 1, 4, 6, 5]
let count = 0

putInPanier(booksId, count)

// add onclick fn
let checkoutbtn = document.querySelector(".checkout")
let vider = document.querySelector(".vider")

vider.onclick = handleVider
checkoutbtn.onclick = handleCheckout


function putInPanier(booksId, bookCount) {
    booksId.map((id) => books[id]).forEach((bookObj) => {
        let myMainElement = document.querySelector(".books")
        let book = document.createElement("li")

        book.id = bookObj.id // Add id to book bookObj

        addBookImg(book, bookObj) // add Book images to book-li

        createInfo(book, bookObj, bookCount)

        myMainElement.appendChild(book) // put the element in html
    })
}
function createInfo(html, bookObj, bookCount) {

    let info = document.createElement("div")

    info.className = "info" // Add info class

    addBookTitle(info, bookObj) // add title to info element

    addBookAuther(info, bookObj) // add author to info element

    addBookPrice(info, bookObj) // add price to info element

    addBookBtn(info, bookObj, bookCount) // add btn to info elemnet

    addSubTotal(info, bookObj) // add subTotal to info element

    addDeleteBtn(info, bookObj)
    html.appendChild(info)  // Add info to book-li element


}
function addBookImg(html, book) {
    let img = document.createElement("img")

    img.src = `./images/books-images/${book.url}` // Add the link of the img

    html.append(img) // Add img to book

}
function addBookTitle(html, book) {

    let title = document.createElement("h3");

    title.append(book.title);    // Add book title

    title.className = "title"    // Add class to the title

    html.appendChild(title);     // Add title To info    

}
function addBookAuther(html, book) {
    let author = document.createElement("div")

    author.append(book.author) //add author name

    html.appendChild(author) // Add author to info
}
function addBookPrice(html, book) {

    let price = document.createElement("div");

    price.append(`$${book.price}`) // Add the price

    price.className = "price"      // Ass class to the price

    price.setAttribute("data-price", book.price) // add the price in data attr

    html.appendChild(price); // Add price To info
}
function addBookBtn(html, book, bookCount) {
    let btns = document.createElement("div")

    let plusBtn = document.createElement("button")
    let moinsBtn = document.createElement("button")

    let plusIcon = document.createElement("i")
    let moinsIcon = document.createElement("i")

    let count = document.createElement("span")


    count.append(bookCount)
    count.id = `C-${book.id}`

    plusIcon.className = "fas fa-circle-plus"  // add icon class 
    moinsIcon.className = "fas fa-circle-minus" // add icon class 

    plusBtn.append(plusIcon)  // add plusBtn icon 
    moinsBtn.append(moinsIcon) // add moinsBtn icon 

    plusBtn.className = "plus-btn" // add class  to btns
    moinsBtn.className = "moins-btn"// add class to btns

    plusBtn.id = book.id // add book-id to btns
    moinsBtn.id = book.id// add book-id to btns

    plusBtn.onclick = handlePlusFn
    moinsBtn.onclick = handleMoinsFn

    btns.appendChild(moinsBtn) // add moinsBtn to btns
    btns.appendChild(count)
    btns.appendChild(plusBtn)  // add plusBtn to btns
    btns.className = "btns"

    html.append(btns)  // add btns to info

}
function addSubTotal(html, book) {
    let subtotal = document.createElement("div")

    subtotal.className = "sub-total" // add class to subtotal

    subtotal.id = `ST-${book.id}`    // Add book-id to subtotal

    html.append(subtotal) // add subtotal to book
}
function addDeleteBtn(html, book) {
    let deleteBtn = document.createElement("button")
    deleteBtn.textContent = "supprimé"
    html.append(deleteBtn)

}

function handlePlusFn() {
    let count = document.getElementById(`C-${this.id}`) // get the count element
    if (+count.textContent < 10) {
        count.textContent++
    }
    updateSubTotal(+count.textContent, this.id)

}
function handleMoinsFn() {
    let count = document.getElementById(`C-${this.id}`) // get the count element

    if (+count.textContent > 0) {
        count.textContent--

    }
    updateSubTotal(+count.textContent, this.id)

}
function handleCheckout() {
    let total = 0
    let prices = document.querySelectorAll(".price")
    let counts = document.querySelectorAll(".main-section .info div span")
    let cartTotal = document.querySelector(".cart-total span")

    // sum of the prices
    for (let i = 0; i < prices.length; i++) {
        total += +prices[i].getAttribute("data-price") * +counts[i].textContent
    }

    cartTotal.textContent = total.toFixed(2)
    if (total < 50) cartTotal.style = "color:green;"
    if (total > 50 && total < 75) cartTotal.style = "color:orange;"
    if (total > 75) cartTotal.style = "color:red;"


}
function handleVider() {
    if (confirm("Voulez-vous vider le panier ?").valueOf(true)) {
        let counts = document.querySelectorAll(".main-section .info div span")
        let subtotals = document.querySelectorAll(".sub-total")
        let cartTotal = document.querySelector(".cart-total span")

        for (let i = 0; i < counts.length; i++) {
            counts[i].textContent = 0
            subtotals[i].textContent = ""
        }
        cartTotal.textContent = 0
    }

}

function updateSubTotal(count, id) {
    let subtotal = document.querySelector(`.sub-total#ST-${id}`)

    if (count > 0) {
        subtotal.textContent = `sous-total: $${(count * books[id].price).toFixed(2)}`
    } else {
        subtotal.textContent = ""
    }

}


