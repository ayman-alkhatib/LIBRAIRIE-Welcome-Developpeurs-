let booksId = [0, 1, 4, 6]
let count = 0

let checkoutbtn = document.querySelector(".checkout")

putInPanier(booksId, count)

checkoutbtn.onclick = handleCheckout

function putInPanier(booksId, bookCount) {
    booksId.map((id) => books[id]).forEach((bookObj) => {

        // create element html
        let myMainElement = document.querySelector(".books")
        let book = document.createElement("li")
        let info = document.createElement("div")
        let subtotal = document.createElement("div")

        // start Book images

        let img = document.createElement("img")

        img.src = `../images/books-images/${bookObj.url}` // Add the link of the img

        book.append(img) // Add img to book

        // end Book images

        // start book title

        let title = document.createElement("h3");

        title.append(bookObj.title);    // Add book title

        title.className = "title"       // Add class to the title

        info.appendChild(title);        // Add title To info    

        // end book title

        // start book author
        let author = document.createElement("div")

        author.append(bookObj.author) //add author name

        info.appendChild(author) // Add author to info

        // end book author

        // start book price

        let price = document.createElement("div");

        price.append(`$${bookObj.price}`) // Add price Text

        price.className = "price"         // Ass class to the price

        price.setAttribute("data-price", bookObj.price) // add the price to the element

        info.appendChild(price); // Add price To info

        // end book price

        // start book btn
        let btns = document.createElement("div")

        let plusBtn = document.createElement("button")
        let moinsBtn = document.createElement("button")

        let plusIcon = document.createElement("i")
        let moinsIcon = document.createElement("i")

        let count = document.createElement("span")


        count.append(bookCount)
        count.id = `C-${bookObj.id}`

        plusIcon.className = "fas fa-circle-plus"  // add icon class 
        moinsIcon.className = "fas fa-circle-minus" // add icon class 

        plusBtn.append(plusIcon)  // add plusBtn icon 
        moinsBtn.append(moinsIcon) // add moinsBtn icon 

        plusBtn.className = "plus-btn" // add class  to btns
        moinsBtn.className = "moins-btn"// add class to btns

        plusBtn.id = bookObj.id // add book-id to btns
        moinsBtn.id = bookObj.id// add book-id to btns

        plusBtn.onclick = handlePlusFn
        moinsBtn.onclick = handleMoinsFn

        btns.appendChild(moinsBtn) // add moinsBtn to btns
        btns.appendChild(count)
        btns.appendChild(plusBtn)  // add plusBtn to btns

        info.append(btns)  // add btns to info

        // end book btn

        // Add info class
        info.className = "info"

        // Add info to book
        book.appendChild(info)

        // Add id to book bookObj
        book.id = bookObj.id;

        // add class to subtotal 
        subtotal.className = "sub-total"

        // add subtotal to book
        book.append(subtotal)

        // add book to html-ul
        myMainElement.appendChild(book)
    })

}

function handlePlusFn() {
    let count = document.getElementById(`C-${this.id}`) // get the count element
    if (+count.textContent < 10) {
        count.textContent++
    }
    if (+count.textContent > 0) {
        updateSubTotal()
    }
}
function handleMoinsFn() {
    let count = document.getElementById(`C-${this.id}`) // get the count element

    if (+count.textContent > 0) {
        count.textContent--

    }
}
function handleCheckout() {
    let total = 0
    let prices = document.querySelectorAll(".price")
    let counts = document.querySelectorAll(".main-section .info div span")
    let cartTotal = document.querySelector(".cart-total span")

    // sum of the prices
    for (let i = 0; i < prices.length; i++) {
        updateSubTotal(+prices[i].getAttribute("data-price") * +counts[i].textContent, i)
        total += +prices[i].getAttribute("data-price") * +counts[i].textContent
    }


    cartTotal.textContent = total.toFixed(2)
    if (total < 50) cartTotal.style = "color:green;"
    if (total > 50 && total < 75) cartTotal.style = "color:orange;"
    if (total > 75) cartTotal.style = "color:red;"


}


function updateSubTotal(sub, index) {
    let subtotals = document.querySelectorAll(".sub-total")
    subtotals[index] = sub
}

