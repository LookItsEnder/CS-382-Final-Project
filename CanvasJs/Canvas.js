let saveStates = [];    //for undoing (ctrl+z)
let redoStates = [];    //for redoing (shift+ctrl+z)
let selectedArea = [];




function setup() {
  createCanvas(500, 500); //canvas size
  background("#FFFFFF"); //color of canvas
  createColorPallets();
  
  
  initializeStart();



  saveCurrentState(); // Save initial blank state
}

function initializeStart() {
  //global variables 
  secondary_color = "#FFFFFF";  //secondary color = white
  primary_color = "#000000";    //primary color = black
  draw_color = primary_color;   //the true drawing color
  brush_size = 50;              //how big the brush will be
  eraser_size = brush_size*2;   //how big the eraser will be
  clonestamp_size = 3;          //how big the clonestamp will be
  size = brush_size;            //the true drawing size
  cursor('assets/circle.png');

  selectedArea = get(0, 0, 1, 1)  //sets selectedArea to a starting value, to fix a crash when the tool was used before a selection was made.


  //tools, true means it's currently selected.
  brush=true;                   //this is how you draw
  eraser=false;                 //this is how you erase
  eyedropper=false;             //this is how you select a color on the canvas to be assined as the primary color
  clonestamp=false;             //this is how you select a square of pixels, and draw with it.



  //setting values
  setPrimaryColorPallet();            //this changes what's displayed in the top layered circle
  setSecondaryColorPallet();          //this changes what's displayed in the bottom layered circle
 
  colorPallet.input(palletColor1);
  colorPallet2.input(palletColor2);

}



//Toolbar 
function createColorPallets() {
  colorPallet2 = createColorPicker();
  colorPallet = createColorPicker();
  
  colorPallet.elt.style.position = 'absolute';
  colorPallet.elt.style.marginTop = '0%';
  colorPallet.elt.style.width = '50px';
  colorPallet.elt.style.height = '50px';
  colorPallet.elt.style.borderRadius = '100%';
  colorPallet.elt.style.outlineWidth = '5px';
  colorPallet.elt.style.outlineColor = 'black';
  colorPallet.elt.style.outlineStyle = 'solid';
  colorPallet.elt.style.marginLeft = '30px';
//------------------------------------------//
  colorPallet2.elt.style.position = 'absolute';
  colorPallet2.elt.style.width = '50px';
  colorPallet2.elt.style.height = '50px';
  colorPallet2.elt.style.borderRadius = '100%';
  colorPallet2.elt.style.outlineWidth = '5px';
  colorPallet2.elt.style.outlineColor = 'black';
  colorPallet2.elt.style.outlineStyle = 'solid';
 
  
  colorPallet.elt.style.opacity = '110%';
  colorPallet2.elt.style.opacity = '110%';
  
  document.querySelector('.box').appendChild(colorPallet2.elt);
  document.querySelector('.box').appendChild(colorPallet.elt);
}



function palletColor1() {
    let newColor = colorPallet.value();
    primary_color = newColor; 
    draw_color = primary_color;
    setPrimaryColorPallet();
}
function palletColor2() {
    let newColor = colorPallet2.value();
    secondary_color = newColor; 
    setSecondaryColorPallet();
}




$(document).ready(function () {
  // Brush button
  $("#brushButton").on("click", function () {
    console.log("Brush tool selected");
    swapTool("brush");
  });

  // Eraser button
  $("#eraserButton").on("click", function () {
    console.log("Eraser tool selected");
    swapTool("eraser");
  });

  // Eyedropper button
  $("#eyedropperButton").on("click", function () {
    console.log("Eyedropper tool selected");
    swapTool("eyedropper");
  });

  // Clonestamp button
  $("#stampButton").on("click", function () {
    console.log("Clonestamp tool selected");
    swapTool("clonestamp");
  });
});







//end of toolbar









function draw() {
  
  // Only draw inside the border area
  
  if (mouseIsPressed && mouseX > 0 && mouseX < width &&  mouseY > 0 && mouseY < height ) {
      
    //eyedropper - assigns pixel's color to primary_color
      if (eyedropper) {
        let color_array = get(mouseX, mouseY); // returns [R, G, B, A];
        let new_color = ("#"+hex(color_array[0], 2)+hex(color_array[1], 2)+hex(color_array[2], 2)); //converts RGB to HEX  
        primary_color = new_color;
        setPrimaryColorPallet();
        draw_color = primary_color;
      }


      //clonestamp - Draw the selected 32x32 area of the selected area
      else if (clonestamp && selectedArea) {
        
        let x = mouseX + 2; //Adjusted to be center-ish of the cloned area on the mouse
        let y = mouseY + 3; //Adjusted to be center-ish of the cloned area on the mouse
        image(selectedArea, x, y, 32, 32); // Draw the cloned/selected area
      
      }
      else if (clonestamp && !selectedArea) {
        console.log("select area");
      }

    //brush - draw on the canvas
      else {
        stroke(draw_color);
        strokeWeight(size); 
        // Draw line within the canvas
        line(mouseX + 16, mouseY + 16, pmouseX+16, pmouseY+16); 
      }
    }

}

function mousePressed() {
  //ctrl+leftMouseButton, select a 32x32 area to start cloning from and put into the selectedArea array.
  if (keyIsDown(CONTROL) && mouseButton === LEFT && clonestamp) {
    
    let xStart=mouseX; //get center of square
    let yStart=mouseY; //get center of square
    selectedArea = get(xStart, yStart, 32, 32); //save the selected 32x32 pixel region
    console.log(selectedArea.length);
  }
}


function mouseReleased() {
  if (!eyedropper) { 
    saveCurrentState();
  }
}






function saveCurrentState() {
  let currentState = get();
  saveStates.push(currentState); 
  //redoStates = [];
  console.log("saved canvas to: saveStates["+saveStates.length+"]");
}

function undo() {
  if (saveStates.length > 1) { //states available for undo
    redoStates.push(saveStates.pop()); // Push the current state to redoStates
    image(saveStates[saveStates.length-1], 0, 0); //state gets redrawn on canvas
  }
}

function redo() {
  if (redoStates.length > 0) { // Ensure there's a state to redo
    let redoState = redoStates.pop(); // Pop the last undone state from redoStates
    saveStates.push(redoState); // Push the redone state to saveStates
    image(redoState, 0, 0); //state gets redrawn on canvas
  }
}









function keyPressed() {





  //save canvas to downloads
  if ((key == 's' || key == 'S') && keyIsDown(SHIFT)) {
    saveCanvas('myDrawing', 'png');
  }

  //swap between color pallets
  if (key == 'x' || key == 'X') { 
    let temp = primary_color;
    primary_color = secondary_color;
    secondary_color = temp;
    draw_color = primary_color;
    setPrimaryColorPallet();
    setSecondaryColorPallet();
  }

  //undo action(s)
  if ((key == 'z' || key == 'Z') && keyIsDown(CONTROL) && !keyIsDown(SHIFT)) {
    undo();
  }
  //redo action(s)
  if ((key == 'z' || key == 'Z') && keyIsDown(CONTROL) && keyIsDown(SHIFT)) {
    redo();
  }




  //tool swapping
  if (key == 'b' || key == 'B') {
    swapTool("brush");
  }
  if (key == 'i' || key == "I") {
    swapTool("eyedropper");
  }
  if (key == 'e' || key == 'E') {
    swapTool("eraser");
  }
  if (key == 's' || key == 'S') {
    swapTool("clonestamp");
  }


  //brush settings
  if (brush) {
      //increase and decrease brush_size
      if (key == ']') {
        brush_size += 1;
        size = brush_size;
      }
      if (key == '[') {
        brush_size -= 1;
        size = brush_size;
      }
  }


  //eraser settings
  if (eraser) {
      //increase and decrease eraser size
      if (key == ']') {
        eraser_size += 1;
        size  = eraser_size;
      }
      if (key == '[') {
        eraser_size -= 1;
        size = eraser_size;
      }
  }

  if (eyedropper) {
    //eyedropper tool stuff
  }

  if (clonestamp) {
    if (key == ']') {
      clonestamp_size += 1;
      size  = clonestamp_size;
    }
    if (key == '[') {
      clonestamp_size -= 1;
      size = clonestamp_size;
    }
  }
}








function swapTool(tool) {
  brush = false; eraser = false; eyedropper = false; clonestamp=false;
  noErase();
  if (tool == 'brush'){
    brush = true;
    draw_color = primary_color;
    size = brush_size;
    cursor('assets/circle.png');
  }

  else if (tool == 'eraser') {
    eraser=true;
    erase();
    size = eraser_size;
    cursor('assets/circle.png');
  }


  else if (tool == 'eyedropper') {
    eyedropper=true;
    size = 1;
    cursor(CROSS);
  }


  else if (tool == 'clonestamp') {
    clonestamp=true;
    size = clonestamp_size;
    cursor('assets/square.png', clonestamp_size, clonestamp_size);
  }




  else if (tool == '') {
    
  }

}


//set the color pallets to show the assigned colors of primary and secondary colors
function setPrimaryColorPallet() {
  document.getElementById('primary').style.backgroundColor = primary_color;
  colorPallet.value(primary_color);
  console.log("New Primary Color Pallet : "+primary_color);
}
function setSecondaryColorPallet() {
  document.getElementById('secondary').style.backgroundColor = secondary_color;
  colorPallet2.value(secondary_color);
  console.log("New Secondary Color Pallet : "+secondary_color);
}


