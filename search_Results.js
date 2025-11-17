document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search);
  const query = urlParams.get("query");

  if (!query) return;

  const container = document.getElementById("results");
  container.innerHTML = `<div class="spinner" role="status" aria-live="polite" aria-label="Loading results"></div>`;

  fetch(`search.php?query=${encodeURIComponent(query)}`)
    .then((res) => res.json())
    .then((data) => {
      if (!data || data.length === 0) {
        container.innerHTML = "<p>No results found.</p>";
        container.classList.remove("single-result");
        return;
      }

      if (data.error) {
        container.innerHTML = `<p>Error: ${data.error}</p>`;
        container.classList.remove("single-result");
        return;
      }

      container.innerHTML = "";

      // Add or remove single-result class on container
      if (data.length === 1) {
        container.classList.add("single-result");
      } else {
        container.classList.remove("single-result");
      }

      data.forEach((item, index) => {
        const card = document.createElement("div");
        card.className = "card";
        // Add small-card class if only one result
        if (data.length === 1) {
          card.classList.add("small-card");
        }
        card.tabIndex = 0;
        card.setAttribute("role", "article");
        card.setAttribute(
          "aria-label",
          `Product: ${item.name}, Price: Rs${item.price}`
        );
        card.innerHTML = `
          <a href="detailesPage.php?id=${item.id}" class="card-link" aria-label="View details for ${item.name}">
            <img src="${item.image_path}" alt="${item.name}">
            <div class="info">
              <h3>${item.name}</h3>
              <p><small>${item.info}</small></p>
              <p><strong>Price:</strong> Rs${item.price}</p>
            </div>
          </a>
        `;
        container.appendChild(card);

        // Focus first card for accessibility
        if (index === 0) {
          card.focus();
        }
      });
    })
    .catch((error) => {
      container.innerHTML =
        "<p>Failed to load results. Please try again later.</p>";
      container.classList.remove("single-result");
      console.error("Search error:", error);
    });

  // Keyboard navigation for cards
  container.addEventListener("keydown", (e) => {
    const focusableCards = container.querySelectorAll(".card");
    const focusedElement = document.activeElement;
    const currentIndex = Array.from(focusableCards).indexOf(focusedElement);

    if (e.key === "ArrowRight") {
      e.preventDefault();
      const nextIndex = (currentIndex + 1) % focusableCards.length;
      focusableCards[nextIndex].focus();
    } else if (e.key === "ArrowLeft") {
      e.preventDefault();
      const prevIndex =
        (currentIndex - 1 + focusableCards.length) % focusableCards.length;
      focusableCards[prevIndex].focus();
    }
  });
});
