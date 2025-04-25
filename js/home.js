

function displayCars(cars, containerClass) {
    const container = document.querySelector(`.${containerClass}`);
    container.innerHTML = '';
    cars.forEach(car => {
        const card = document.createElement('div');
        card.classList.add('col-md-4', 'car-card'); 
        card.innerHTML = `
            <img src="${car.image}" alt="${car.make} ${car.model}">
            <h3>${car.make} ${car.model}</h3>
            <p>Year: ${car.year}</p>
            <p>Price: $${car.price.toLocaleString()}</p>
            <button class="btn btn-sm btn-primary">View Details</button>
        `;
        container.appendChild(card);
    });
}

function displayReviews(reviews) {
    const container = document.querySelector('.review-grid');
    container.innerHTML = ''; 
    reviews.forEach(review => {
        const card = document.createElement('div');
        card.classList.add('col-md-4', 'review-card'); 
        card.innerHTML = `
            <p>Rating: ${review.rating} <i class="fas fa-star"></i></p>
            <p>${review.comment}</p>
            <p>- ${review.name}</p>
        `;
        container.appendChild(card);
    });
}

    $(document).ready(function() {
        $('#carouselExampleControls').carousel();

        const langButton = document.getElementById('langSwitch');
        const langCSS = document.getElementById('lang-css');
        const body = document.querySelector('body');
        let isArabic = false;
        langButton.addEventListener('click', () => {
            isArabic = !isArabic;
            langButton.textContent = isArabic ? 'EN' : 'AR';
            body.classList.toggle('ar', isArabic);
            body.classList.toggle('en', !isArabic);
    
        
            if (isArabic) {
                langCSS.href = "lung.css"; 
            } else {
                langCSS.href = "home.css"; 
            }});
       

        const adContainers = {};

        function rotateAd(placement) {
            const containerId = placement + '-ads-container';
            const container = $('#' + containerId);
            const ads = adContainers[placement];

            if (container.length && ads && ads.length > 0) {
                let currentIndex = container.data('index') || 0;
                const ad = ads[currentIndex];
                const adHtml = `
                    <div class="ad-banner">
                        <a href="${ad.ad_url}" target="_blank">
                            <img src="${ad.image}" alt="${ad.full_name}">
                        </a>
                    </div>
                `;
                container.html(adHtml);
                currentIndex = (currentIndex + 1) % ads.length;
                container.data('index', currentIndex);
            } else if (container.length) {
                container.empty();
            }
        }

        function loadAllAds() {
            $.ajax({
                url: 'get_ads.php',
                method: 'GET',
                dataType: 'json',
                success: function(adsByPlacement) {
                   
                    for (const placement in adsByPlacement) {
                        adContainers[placement] = adsByPlacement[placement];
                 
                        rotateAd(placement);
                        setInterval(() => rotateAd(placement), 5000);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading ads:', error);
                    $('.ad-banner').html('<p class="text-muted">Failed to load advertisements.</p>'); 
                }
            });
        }

        loadAllAds();
    });


const langButton = document.getElementById('langSwitch');
let isArabic = false; 

langButton.addEventListener('click', () => {
    isArabic = !isArabic;
    if (isArabic) {
        langButton.textContent = 'EN';
        
    } else {
        langButton.textContent = 'AR';
     
    }
});


displayCars(latestCars, 'latest-cars .car-grid');
displayCars(featuredCars, 'featured-cars .car-grid');
displayCars(soldCars, 'sold-cars .car-grid');
displayReviews(reviews);