document.addEventListener("DOMContentLoaded", () => {
  const searchForm = document.getElementById("searchForm");
  const searchInput = document.getElementById("searchInput");

  searchForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const query = searchInput.value.trim();

    if (query.length < 1) {
      alert("Please enter a search term.");
      searchInput.focus();
      return;
    }

    // Redirect to results page with query
    window.location.href = `search_Results.php?query=${encodeURIComponent(query)}`;
  });
});



