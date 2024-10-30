
function setup() {
  createCanvas(500, 500); //canvas size
  //background_color = "#FFFFFF";
  background("#FFFFFF"); //color of canvas
  

  createColorPallets();
  initializeStart();
  colorPallet.input(palletColor1);
  colorPallet2.input(palletColor2);



  
}

function initializeStart() {
  //global variables 
  secondary_color = "#FFFFFF";  //secondary color = white
  primary_color = "#000000";    //primary color = black
  draw_color = primary_color;   //the true drawing color
  brush_size = 50;              //how big the brush will be
  eraser_size = brush_size*2;            //how big the eraser will be
  size = brush_size;            //the true drawing size

  //tools, true means it's currently selected.
  brush=true;                   //this is how you draw
  eraser=false;                 //this is how you erase
  eyedropper=false;             //this is how you select a color on the canvas to be assined as the primary color

  //setting values
  setPrimaryColorPallet();            //this changes what's displayed in the top layered circle
  setSecondaryColorPallet();          //this changes what's displayed in the bottom layered circle

}


function createColorPallets() {
  colorPallet2 = createColorPicker();
  colorPallet2.position(10,80);

  colorPallet = createColorPicker();
  colorPallet.position(10,80);
  
  colorPallet.elt.style.position = 'absolute';
  colorPallet.elt.style.marginTop = '5%';
  colorPallet.elt.style.marginLeft = '6%';
  colorPallet.elt.style.width = '100px';
  colorPallet.elt.style.height = '100px';
  colorPallet.elt.style.borderRadius = '100%';
  colorPallet.elt.style.outlineWidth = '5px';
  colorPallet.elt.style.outlineColor = 'black';
  colorPallet.elt.style.outlineStyle = 'solid';
//------------------------------------------//
  colorPallet2.elt.style.position = 'absolute';
  colorPallet2.elt.style.width = '100px';
  colorPallet2.elt.style.height = '100px';
  colorPallet2.elt.style.borderRadius = '100%';
  colorPallet2.elt.style.outlineWidth = '5px';
  colorPallet2.elt.style.outlineColor = 'black';
  colorPallet2.elt.style.outlineStyle = 'solid';

  colorPallet.elt.style.opacity = '0';
  colorPallet2.elt.style.opacity = '0';
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

function draw() {
  
  // Only draw inside the border area
  
  if (mouseIsPressed && mouseX > 0 && mouseX < width &&  mouseY > 0 && mouseY < height ) {
      
    //assigns pixel's color to primary_color
      if (eyedropper) {
        let color_array = get(mouseX, mouseY); // returns [R, G, B, A];
        let new_color = ("#"+hex(color_array[0], 2)+hex(color_array[1], 2)+hex(color_array[2], 2)); //converts RGB to HEX  
        primary_color = new_color;
        setPrimaryColorPallet();
        draw_color = primary_color;
      }


    //draw on the canvas
      else {
        stroke(draw_color);
        strokeWeight(size); 
        // Draw line within the canvas
        line(mouseX, mouseY, pmouseX, pmouseY); 
      }
    }
    
}



function keyPressed() {
  // Save the canvas when the 's' key is pressed
  
  if (key == 's' || key == 'S') {
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
}








function swapTool(tool) {
  brush = false; eraser = false; eyedropper = false;
  noErase();
  if (tool == 'brush'){
    brush = true;
    draw_color = primary_color;
    size = brush_size;
    cursor(ARROW);
  }

  else if (tool == 'eraser') {
    eraser=true;
    erase();
    size = eraser_size;
    cursor(ARROW);
  }


  else if (tool == 'eyedropper') {
    eyedropper=true;
    size = 1;
    cursor(CROSS);
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


