
const body = document.body;
const main = document.querySelector('.sscrol');
const wrapper = document.querySelector('.wrapper');


let sx = 0;
let sy = 0;

let dx = sx;
let dy = sy;


body.style.height = window.innerHeight + 'px';
wrapper.style.height = window.innerHeight + 'px';


window.addEventListener('scroll', scroll);

function scroll() {

  sx = window.pageXOffset;
  sy = window.pageYOffset;
}


window.requestAnimationFrame(render);

function render() {

  
  dx = lerp(dx, sx, 0.1);
  dy = lerp(dy, sy, 0.1);
  
  dx = Math.floor(dx * 100) / 100;
  dy = Math.floor(dy * 100) / 100;
  

  main.style.transform = `translate(-${dx}px, -${dy}px)`;
  
  // And we loop again.
  window.requestAnimationFrame(render);
}


function lerp(a, b, n) {
  return (1 - n) * a + n * b;
}
