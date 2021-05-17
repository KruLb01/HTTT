let index = 0;
        const slidesContainer = document.getElementsByClassName("slides")[0];
        const slides = document.getElementsByClassName("slide");
        const container = document.getElementsByClassName("slide-container")[0];
        slidesContainer.style.width = (slides.length*100)+"%";
        setInterval(function(){
            if(index===slides.length-1) index=0;
            else index++;
            slidesContainer.style.transform="translateX(-"+index*container.offsetWidth+"px)";
        },6000);