let slideIndex = 0;
        showSlides();

        function showSlides() {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");

            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            slideIndex++;

            if (slideIndex > slides.length) {
                slideIndex = 1;
            }

            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            setTimeout(showSlides, 10000); // Change image every 2 seconds
        }

        document.addEventListener("DOMContentLoaded", function () {
            const imageList = document.querySelector(".image-list");
            const slideButtons = document.querySelectorAll(".slide-button");
            

            const initSlider = () => {
                const maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;

                slideButtons.forEach((button) => {
                    button.addEventListener("click", () => {
                        const direction = button.id === "prev-btn" ? -1 : 1;
                        const scrollAmount = imageList.clientWidth * direction;
                        imageList.scrollBy({ left: scrollAmount, behavior: "smooth" });
                    });
                });

                

            };

            window.addEventListener("resize", initSlider);
            window.addEventListener("load", initSlider);
        });