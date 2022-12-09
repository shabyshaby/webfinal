let userSearch = document.getElementsByClassName("search");
var search_box = document.getElementById("search-box");
var searchShelf = document.querySelector(".search");
var searchToggle = document.getElementById("search");
searchToggle.style.display = "none";


//TODO: Get books from API and then use it to make shelves 

//      Prompt values to help instruct user where they may be at
//      during process
//

//Purpose: Help open google's API for book information
//Argument: Book data they want; Author, title, descripition etc...
//Return: Data we want from book with matching parameters
const getBooks = async (book) => {
    console.log("trying to open API")
    const response = await fetch(
        `https://www.googleapis.com/books/v1/volumes?q=${book}`
    );
    const result = await response.json();
    return result;
}

//Purpose: Provide default cover if book doesn't have one
//Argument: Image link from book volume data
//Return:   file path to default book cover
const getCover = ({imageLinks}) => {
    const DEFAULT_COVER = "./images/default.png";
    if (!imageLinks || !imageLinks.thumbnail){
        return DEFAULT_COVER;
    }
    return imageLinks.thumbnail.replace("http://","https://");

}

//Purpose: create html code that makes shelf of books from google API
//         from one subject
//Argument: book subject and an index for size of book shelf
//Return: code that makes html code for shelf
const fillShelf = async (subject, startIndex = 0) => {
    console.log("TRYING TO MAKE SHELF");
    let shelf = document.querySelector(`.${subject}`);
    shelf.innerHTML = `<div class='prompt'><div class="loader"></div></div>`;
    const books = await getBooks(`subject:${subject}&startIndex=${startIndex}&maxResults=7`);
    if (books.error) {
        shelf.innerHTML = `<div class='prompt'><h2>If you don't see any books, wait a moment and then restart. API had trouble receiving it due to too many requests.
        Trying clicking the arrow to the right if you don't want to restart.</h2></div>`;
      } else if (books.totalItems == 0) {
        shelf.innerHTML = `<div class='prompt'>;_; Nothing could be found from search result! ;_; </div>`;
    } else {
        //Getting specific data from the JSON shelf 
        shelf.innerHTML = books.items;
        shelf.innerHTML = books.items.map(
            ({volumeInfo, number = randomNumber(7,20), price = randomPrice(number)}) => 
            `<div class='book' style='background: linear-gradient(#ccd4c6, #dde1de);'>
                <img class='cover' src='` + getCover(volumeInfo) + `' alt='cover' onclick='toggleDesc(this);'>` +
                    `<div class='desc' style="display: none">
                        <div class='prompt-info' style='background: #ccd4c6;' onclick=''>
                            <span onclick='hide(this)'class="close">&times;</span>
                            <img class='prompt-cover' alt='cover' src='${getCover(volumeInfo)}'> 
                            <h1> ${volumeInfo.title} </h1>
                            <h2> Author(s): ${volumeInfo.authors} </h2>
                            <h2> Price: $${price} </h1>
                            <h2> Description: </h2> 
                            <div class='prompt-desc'><h3>` +
                                (volumeInfo.description === undefined
                                 ? "No Description Available"
                                 : volumeInfo.description)
                                +
                            `</h3></div>
                            <button id='add' onclick='' value='${price}' style='margin-top: 10px;'>Add To Cart</button>
                        </div>
                    </div>` + 
                `<div class='book-info'><h3 class='book-title'>${volumeInfo.title}</h3>
                    <div class='book-authors' onclick=''>`+
                        (volumeInfo.authors === undefined
                        ? "No Authors Available"
                        : volumeInfo.authors) +
                    `</div>
                    <div class='genre'>` + 
                        (volumeInfo.categories === undefined
                        ? "Others"
                        : volumeInfo.categories) +
                    `</div>     
                    <button id='add' onclick='' value='${price}' style='margin-left: 0; margin-top: 10px;'>
                        Add To Cart 
                    </button>                       
                </div>
            </div>` 
              

        ).join("");
    }
}

//Purpose: Fill the search shelf with books that user searches
//Arguments: None
//Returns: code that writes html for shelf 

const fillSearchShelf = async () => {
    console.log("TRYING TO CREATE SEARCH SHELF")
    //Checking if user inputs something first
    if (search_box.value != ""){
        searchToggle.style.display = "flex";
        searchShelf.innerHTML = `<div class='prompt'><div class="loader"></div></div>`;
        const books = await getBooks(`${search_box.value}&maxResults=7`);
        if (books.error) {
            bookContainer.innerHTML = `<div class='prompt'><h2> If you don't see any books, wait a moment and then restart. API had trouble receiving it due to too many requests.</h2></div>`;
        } else if (books.innerHTML == 0){
            searchShelf.innerHTML = `<div class='prompt> <h2> No results found! </h2></div>`;
        } else {
            searchShelf.innerHTML = books.items.map(
                ({volumeInfo, number = randomNumber(6, 20), price = randomPrice(number)}) =>
                `<div class='book' style='background: linear-gradient(#ccd4c6, #dde1de);'>
                    <img class='cover' src='` + getCover(volumeInfo) + `' alt='cover' onclick='toggleDesc(this);'>` +
                        `<div class='desc'>
                            <div class='prompt-info' style='background: #ccd4c6;' onclick=''>
                                <span onclick='hide(this)'class="close">&times;</span>
                                <img class='prompt-cover' alt='cover' src='${getCover(volumeInfo)}'> 
                                <h1> ${volumeInfo.title} </h1>
                                <h2> Author(s): ${volumeInfo.authors} </h2>
                                <h2> Price $${price} </h1>
                                <h2> Description: </h2> 
                                <div class='prompt-desc'><h3>` +
                                (volumeInfo.description === undefined
                                 ? "No Description Available"
                                 : volumeInfo.description)
                                +
                            `</h3></div>
                                <button id='add' onclick='' value='${price}' style='margin-top: 10px;'>Add To Cart</button>
                            </div>
                        </div>` + 
                    `<div class='book-info'><h3 class='book-title'>${volumeInfo.title}</h3>
                        <div class='book-authors' onclick=''>`+
                            (volumeInfo.authors === undefined
                            ? "No Authors"
                            : volumeInfo.authors) +
                        `</div>
                        <div class='genre'>` + 
                            (volumeInfo.categories === undefined
                            ? "Others"
                            : volumeInfo.categories) +
                        `</div>     
                        <button id='add' onclick='' value='${price}' style='margin-left: 0; margin-top: 10px;'>
                            Add To Cart 
                        </button>                       
                    </div>
                </div>` 
            ).join("");
        }
    } else {
        searchToggle.style.display = "none";
        // searchShelf.style.display = "none";
    }
}

const debouce = (to = 0, time, func) => {
    to ? clearTimeout(to) : (to = setTimeout(fillSearchShelf, time));
};

//Listen for an input and then wait a second to allow for function
//to run smoothly and not cause any connection issues to API, I
//find this much quicker than using async 
search_box.addEventListener("input", () => debouce(fillSearchShelf(), 1000));

//Function that makes me delay the request send outs
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
//Stock bookshelfs once completely loaded
document.addEventListener("DOMContentLoaded", async () => {
    console.log("DOCUMENT LOADED")
    fillShelf("mystery");
    await sleep(3000);
    fillShelf("fantasy");
    await sleep(3000);
    fillShelf("history");
    await sleep(3000);
    fillShelf("poetry");
    await sleep(3000);
    fillShelf("thriller");
    await sleep(3000);
    fillShelf("nature");
    await sleep(3000);
    fillShelf("cooking");
    await sleep(3000);
    fillShelf("comics");
    console.log("NOW FILLED");
    var span = document.getElementsByClassName("close")[0];
    const opendesc = $(".desc").attr("style", "display: none");
});
function hide(desc){
    console.log("INSIDE HIDE FUNCTION")
    console.log($(desc).parents(".desc"));
    $(desc).parents(".desc").attr("style", "display: none");

}

function toggleDesc(desc){
    console.log("description toggled");
    console.log($(desc).next());
    const opendesc = $(desc).next();
    console.log(opendesc);
    console.log(opendesc.attr("display"));
    if (opendesc.attr("display") == "none"){
        opendesc.attr("style", 'display: block');
    } else if (typeof opendesc.attr("display") === "undefined"){
        opendesc.attr('style', 'display: block');
        console.log("TRYING TO SHOW - THROUGH undefined triggered");
    } else {
        console.log("HERE");
        opendesc.attr('style', 'display: none');
    } 
    
}

function randomNumber(min, max) { 
    return Math.floor(Math.random() * (max - min) + min);
} 
function randomPrice(number){
    return number + ".99";
}
let startIndex = 0;
const next = (subject) => {
  let sub_books = $(`${subject}-prev`);
  startIndex += 7;
  if (startIndex >= 0) {
    sub_books.css("style", "display: inline-flex");
    fillShelf(subject, startIndex);
  } else {
    sub_books.css("style", "display: none");
  }
};
const prev = (subject) => {
    let sub_books = $(`${subject}-prev`);
    startIndex -= 7;
    if (startIndex <= 0) {
      startIndex = 0;
      fillShelf(subject, startIndex);
      sub_books.css("style", "display: none");
    } else {
      sub_books.css("style", "display: inline-flex");
      fillShelf(subject, startIndex);
    }
  };










