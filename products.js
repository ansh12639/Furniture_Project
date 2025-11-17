document.addEventListener("DOMContentLoaded", () => {
  fetch("products.php")
    .then((res) => {
      if (!res.ok) {
        throw new Error("Network response was not ok");
      }
      return res.json(); // ✅ FIXED: return this
    })
    .then((data) => {
      const main = document.getElementById("images");
      if (!main) {
        console.error("Element with ID 'images' not found.");
        return;
      }

      main.innerHTML = "";

      data.forEach((item) => {
        const card = document.createElement("div");
        card.className = "card";

        card.innerHTML = `
      <a href="detailesPage.php?id=${item.id}" class="card-link">
        <img src="${item.image_path}" alt="${item.name}">
        <div class="info">
          <h3>${item.name}</h3>
          <p><small>${item.info}</small></p>
          <p><strong>Price:</strong> Rs${item.price}</p>
        </div>
      </a>
      `;

        main.appendChild(card);
      });
    })
    .catch((error) => console.error("Error fetching data:", error));
});
