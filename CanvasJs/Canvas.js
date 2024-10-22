
function setup() {
  createCanvas(420, 420); 
  
  background(255); 
  
}

function draw() {
  
  // Only draw inside the border area
  
  if (mouseIsPressed &&  mouseX > 0 && mouseX < width &&  mouseY > 0 && mouseY < height ) {
    
    stroke(0);
   
    strokeWeight(4); 
    
    // Draw line within the canvas
    
    line(mouseX, mouseY, pmouseX, pmouseY); 
  
  }

}

function keyPressed() {
  // Save the canvas when the 's' key is pressed
  
  if (key == 's' || key == 'S') {
    
    saveCanvas('myDrawing', 'png');
  }
}
