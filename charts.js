
// ==============================
// Comments Status Chart
// ==============================

const commentsCanvas = document.getElementById("commentsChart");

if (commentsCanvas) {

    const pending = Number(commentsCanvas.dataset.pending);
    const approved = Number(commentsCanvas.dataset.approved);
    const rejected = Number(commentsCanvas.dataset.rejected);

    new Chart(commentsCanvas, {

        type: "doughnut",

        data: {

            labels: [
                "Pending",
                "Approved",
                "Rejected"
            ],

            datasets: [{

                label: "Comments",

                data: [
                    pending,
                    approved,
                    rejected
                ],

                backgroundColor: [
                    "#ffc107",
                    "#198754",
                    "#dc3545"
                ],

                borderWidth: 2,
                hoverOffset: 10

            }]

        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {

                legend: {
                    position: "bottom"
                },

                title: {
                    display: true,
                    text: "Comments Distribution"
                }

            }

        }

    });

}


// ==============================
// Posts & Comments Chart
// ==============================

const postsCanvas = document.getElementById("postsChart");

if (postsCanvas) {

    const posts = Number(postsCanvas.dataset.posts);
    const comments = Number(postsCanvas.dataset.comments);

    new Chart(postsCanvas, {

        type: "bar",

        data: {

            labels: [
                "Posts",
                "Comments"
            ],

            datasets: [{

                label: "Total Count",

                data: [
                    posts,
                    comments
                ],

                backgroundColor: [
                    "#0d6efd",
                    "#20c997"
                ],

                borderRadius: 8,
                maxBarThickness: 70

            }]

        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                },

                title: {
                    display: true,
                    text: "Website Content Overview"
                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    }

                }

            }

        }

    });

}
