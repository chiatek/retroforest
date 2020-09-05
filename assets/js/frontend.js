// frontend.js

/*-------------------------------------------------------------------------------------------*/
/* Preload.js   ||---------------------------- */
/*-------------------------------------------------------------------------------------------*/

let progress = document.getElementById("progress");
let mountains = document.querySelector(".mountains");
let forest = document.querySelector(".forest");
let clouds = document.querySelector(".clouds");

let queue = new createjs.LoadQueue(false);

queue.on("progress", event => {
    console.log(event);
    let progress = Math.floor(event.progress * 100);
    this.progress.style.width = progress+"%";
});

queue.on("complete", event => {
    progress.classList.add("fadeOut");

    setTimeout(() => {
        document.querySelector(".parallax-container").style.display = "block";
    }, 1000);
});

queue.on("fileload", handleFileComplete);
queue.loadFile("https://retroforest.com/assets/img/uploads/forest.png");
queue.loadFile("https://retroforest.com/assets/img/uploads/mountains.png");
queue.loadFile("https://retroforest.com/assets/img/uploads/clouds.png");

function handleFileComplete(event) {
    let item = event.item;
    let type = item.type;
    let image = event.item.src;

    if (type == createjs.Types.IMAGE) {
        if (image.includes("mountains")) {
            setTimeout(() => {
                mountains.style.backgroundImage = "url(" + image + ")";
            }, 500);
        }
        else if (image.includes("clouds")) {
            setTimeout(() => {
                clouds.style.backgroundImage = "url(" + image + ")";;
            }, 1000);
        }
        else {
            setTimeout(() => {
                forest.style.backgroundImage = "url(" + image + ")";
            }, 500);
        }
    }

}

/*-------------------------------------------------------------------------------------------*/
/* Lax.js   ||---------------------------- */
/*-------------------------------------------------------------------------------------------*/

window.onload = function() {
    lax.setup() // init

    const updateLax = () => {
        lax.update(window.scrollY)
        window.requestAnimationFrame(updateLax)
    }

    window.requestAnimationFrame(updateLax)
}

/*-------------------------------------------------------------------------------------------*/
/* Owl Carousel   ||---------------------------- */
/*-------------------------------------------------------------------------------------------*/

$(document).ready(function() {
    $("#owl-slide").owlCarousel({
        autoplay:true,
        autoplayTimeout:10000,
        loop: true,
        lazyLoad : true,
        items: 3,
        dots: false,
        stagePadding: 300,
        responsive : {
            0 : {stagePadding: 0},
            600 : {stagePadding: 100},
            900 : {stagePadding: 200},
            1199 : {}
        },
    });
});