  // hero image slider section
  document.addEventListener('DOMContentLoaded', () => {
    const sliderData = [
      {
        img: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=80',
        title: 'Luxury Meets Comfort',
        desc: 'Experience the finest in modern furniture design.',
        button: 'Shop Now'
      },
      {
        img: './images/slide4.JPG',
        title: 'Elegant Living',
        desc: 'Upgrade your space with timeless furniture pieces.',
        button: 'Explore Collection'
      },
      {
        img: './images/slide5.JPG',
        title: 'Modern & Minimal',
        desc: 'Discover simplicity with style.',
        button: 'Browse Now'
      }
    ];

    const sliderContainer = document.querySelector('.slider-container');
    if (!sliderContainer) {
      console.error('slider-container not found!');
      return;
    }

    sliderData.forEach(data => {
      const slide = document.createElement('div');
      slide.className = 'slide';
      slide.innerHTML = `
        <img src="${data.img}" alt="${data.title}">
        <div class="slide-text">
          <h1>${data.title}</h1>
          <p>${data.desc}</p>
          <button>${data.button}</button>
        </div>
      `;
      sliderContainer.appendChild(slide);
    });

    let currentIndex = 0;
    function slideShow() {
      const slides = document.querySelectorAll('.slide');
      currentIndex = (currentIndex + 1) % slides.length;
      sliderContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    setInterval(slideShow, 4000);
  });

  // product section 



  document.addEventListener('DOMContentLoaded', () => {
    const products = [
      {
        id: '001',
        name: "Luxury Sofa Set",
        desc: "High-quality modern sofa with premium fabric.",
        price: "₹24,999",
        img: "./images/chair1.JPG",
      },
      {
        id: '002',
        name: "Elegant Dining Table",
        desc: "6-seater wooden table with glass top.",
        price: "₹18,500",
        img: "./images/FNSTLC51TA16203_LP.JPG"
      },
      {
        id: '003',
        name: "Work From Home Desk",
        desc: "Minimalist desk for office and home setups.",
        price: "₹7,999",
        img: "./images/FVCHLC62WH50547_LP.JPG"
      },
      {
        id: '004',
        name: "Classic Armchair",
        desc: "Comfortable armchair with soft cushions.",
        price: "₹5,499",
        img: "./images/JJSGSR62PT10874_LP.JPG"
      },
      {
        id: '005',
        name: "Luxury Sofa Set",
        desc: "High-quality modern sofa with premium fabric.",
        price: "₹24,999",
        img: "./images/chair1.JPG",
      },
      {
        id: '006',
        name: "Elegant Dining Table",
        desc: "6-seater wooden table with glass top.",
        price: "₹18,500",
        img: "./images/FNSTLC51TA16203_LP.JPG"
      },
      {
        id: '007',
        name: "Work From Home Desk",
        desc: "Minimalist desk for office and home setups.",
        price: "₹7,999",
        img: "./images/FVCHLC62WH50547_LP.JPG"
      },
      {
        id: '008',
        name: "Classic Armchair",
        desc: "Comfortable armchair with soft cushions.",
        price: "₹5,499",
        img: "./images/JJSGSR62PT10874_LP.JPG"
      },
      {
        id: '009',
        name: "Luxury Sofa Set",
        desc: "High-quality modern sofa with premium fabric.",
        price: "₹24,999",
        img: "./images/chair1.JPG",
      },
      {
        id: '010',
        name: "Elegant Dining Table",
        desc: "6-seater wooden table with glass top.",
        price: "₹18,500",
        img: "./images/FNSTLC51TA16203_LP.JPG"
      },
      {
        id: '011',
        name: "Work From Home Desk",
        desc: "Minimalist desk for office and home setups.",
        price: "₹7,999",
        img: "./images/FVCHLC62WH50547_LP.JPG"
      },
      {
        id: '012',
        name: "Classic Armchair",
        desc: "Comfortable armchair with soft cushions.",
        price: "₹5,499",
        img: "./images/JJSGSR62PT10874_LP.JPG"
      },
      {
        id: '013',
        name: "Luxury Sofa Set",
        desc: "High-quality modern sofa with premium fabric.",
        price: "₹24,999",
        img: "./images/chair1.JPG",
      },
      {
        id: '014',
        name: "Elegant Dining Table",
        desc: "6-seater wooden table with glass top.",
        price: "₹18,500",
        img: "./images/FNSTLC51TA16203_LP.JPG"
      },
      {
        id: '015',
        name: "Work From Home Desk",
        desc: "Minimalist desk for office and home setups.",
        price: "₹7,999",
        img: "./images/FVCHLC62WH50547_LP.JPG"
      },
      {
        id: '016',
        name: "Classic Armchair",
        desc: "Comfortable armchair with soft cushions.",
        price: "₹5,499",
        img: "./images/JJSGSR62PT10874_LP.JPG"
      },
      {
        id: '017',
        name: "Luxury Sofa Set",
        desc: "High-quality modern sofa with premium fabric.",
        price: "₹24,999",
        img: "./images/chair1.JPG",
      },
      {
        id: '018',
        name: "Elegant Dining Table",
        desc: "6-seater wooden table with glass top.",
        price: "₹18,500",
        img: "./images/FNSTLC51TA16203_LP.JPG"
      },
      {
        id: '019',
        name: "Work From Home Desk",
        desc: "Minimalist desk for office and home setups.",
        price: "₹7,999",
        img: "./images/FVCHLC62WH50547_LP.JPG"
      },
      {
        id: '020',
        name: "Classic Armchair",
        desc: "Comfortable armchair with soft cushions.",
        price: "₹5,499",
        img: "./images/JJSGSR62PT10874_LP.JPG"
      },
    ];
  
    const container = document.getElementById('product-container');
  
    products.forEach(product => {
      const card = document.createElement('div');
      card.className = 'product-card';
      card.innerHTML = `
        <img src="${product.img}" alt="${product.name}">
        <div class="product-info">
          <h3>${product.name}</h3>
          <p>${product.desc}</p>
          <div class="price">${product.price}</div>
          <button>Add to Cart</button>
        </div>
      `;
      container.appendChild(card);
    });
  });

  // banner section 

  const bannerData = {
    title: "Upgrade Your Home with Elegance",
    description: "Exclusive deals on modern furniture. Limited time offer!",
    buttonText: "Explore Collection",
    buttonLink: "#",
    backgroundImage: "./images/spacejoy-.JPG"
  };

  const bannerSection = document.getElementById("banner-section");

  bannerSection.innerHTML = `
    <div class="dynamic-banner" style="background-image: url('${bannerData.backgroundImage}')">
      <div class="banner-content">
        <h2>${bannerData.title}</h2>
        <p>${bannerData.description}</p>
        <a href="${bannerData.buttonLink}" class="banner-btn">${bannerData.buttonText}</a>
      </div>
    </div>
  `;




  


  
