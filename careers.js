// Job data (could also be loaded from a server)
const jobData = [
    {
        title: "Furniture Product Manager",
        location: "Remote",
        description: "Help grow our online inventory and manage product quality."
    },
    {
        title: "Web Developer",
        location: "New York",
        description: "Build and maintain our e-commerce platform."
    },
    {
        title: "Customer Service Representative",
        location: "Remote",
        description: "Provide support for our customers' product inquiries and issues."
    }
];

// Dynamically inject job listings
// const jobContainer = document.querySelector(".job-listings");

function renderJobs() {
    const jobHTML = jobData.map(job => `
        <div class="job-item">
            <h3>${job.title}</h3>
            <p><strong>Location:</strong> ${job.location}</p>
            <p>${job.description}</p>
            <a href="#apply-form">Apply Now</a>
        </div>
    `).join("");
    jobContainer.innerHTML += jobHTML;
}

// Simple form validation
const form = document.querySelector("form");
form?.addEventListener("submit", (e) => {
    const name = document.getElementById("full-name").value.trim();
    const email = document.getElementById("email").value.trim();
    const position = document.getElementById("position").value.trim();
    const resume = document.getElementById("resume").files[0];

    if (!name || !email || !position || !resume) {
        e.preventDefault();
        alert("Please fill in all fields and upload your resume.");
    }
});

// Initialize
document.addEventListener("DOMContentLoaded", () => {
    renderJobs();
});
