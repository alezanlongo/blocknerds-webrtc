 // Area:
 function area(increment, count, width, height, margin = 10) {
    let i = w = 0;
    let h = increment * 0.75 + (margin * 2);
    while (i < (count)) {
        if ((w + increment) > width) {
            w = 0;
            h = h + (increment * 0.75) + (margin * 2);
        }
        w = w + increment + (margin * 2) ;
        i++;
    }
    if (h > height) return false;
    else return increment;
}
// Dish:
function dish() {
    // variables:
    const margin = 2;
    let boxes = document.getElementsByClassName('box');
    const boxesContainer = document.getElementById('containerBoxes');
    const width = boxesContainer.offsetWidth - (margin * 2);
    const height = boxesContainer.offsetHeight - (margin * 2);
    let max = 0;
    
    boxes = Array.from(boxes).filter(b=> !$(b).hasClass('d-none') || $(b).css("display") !== "none")

    let w, i = 1;
    while (i < 3000) {
        w = area(i, boxes.length, width, height, margin);
        if (w === false) {
            max = i - 1;
            break;
        }
        i++;
    }

    // set styles
    max = max - (margin * 2);
    setWidth(max, margin);
}

// Set Width and Margin 
function setWidth(width, margin) {
    const boxes = document.getElementsByClassName('box');
    for (let s = 0; s < boxes.length; s++) {
        boxes[s].style.width = width + "px";
        boxes[s].style.margin = margin + "px";
        boxes[s].style.height = (width * 0.75) + "px";
    }
}

window.addEventListener("load", function (event) {
    dish();
}, false);

$( window ).resize(function() {
    dish()
});   