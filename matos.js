let slideIndex = 0;
const slides = document.querySelectorAll('.carousel-slide img');

function showSlide(index) {
    const slideWidth = slides[0].clientWidth;
    const newTransformValue = -index * slideWidth;
    document.querySelector('.carousel-slide').style.transform = `translateX(${newTransformValue}px)`;
}

function moveSlide(direction) {
    slideIndex += direction;
    if (slideIndex < 0) {
        slideIndex = slides.length - 1;
    } else if (slideIndex >= slides.length) {
        slideIndex = 0;
    }
    showSlide(slideIndex);
}

window.addEventListener('resize', () => {
    showSlide(slideIndex);
});

document.addEventListener('DOMContentLoaded', () => {
    showSlide(slideIndex);
});
