function myFunction() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
  
  /*__________more_details______________ */
let thumbnails = document.getElementsByClassName('thumbnail')

let activeImages = document.getElementsByClassName('active')

for (var i=0; i < thumbnails.length; i++){

  thumbnails[i].addEventListener('mouseover', function(){
    console.log(activeImages)
    
    if (activeImages.length > 0){
      activeImages[0].classList.remove('active')
    }
    

    this.classList.add('active')
    document.getElementById('featured').src = this.src
  })
}


let buttonRight = document.getElementById('slideRight');
let buttonLeft = document.getElementById('slideLeft');

buttonLeft.addEventListener('click', function(){
  document.getElementById('slider').scrollLeft -= 180
})

buttonRight.addEventListener('click', function(){
  document.getElementById('slider').scrollLeft += 180
})


/*__________more_details______________ */
  