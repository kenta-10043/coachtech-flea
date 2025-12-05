//  評価モーダル
//==============
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("myModal");
    const openButton = document.getElementById("btuOpen");

    if (!modal) return;

    if (window.ratingSeller) {
        modal.classList.add("active");
    }

    modal.addEventListener("click", (e) => {
        e.stopPropagation();
    });

    document.addEventListener("click", () => {
        if (modal.classList.contains("active")) {
            modal.classList.remove("active");
        }
    });
});

//評価機能
//=========
const stars = document.querySelectorAll("#star-box .star");
console.log(stars);
const ratingInput = document.getElementById("rating");

stars.forEach((star) => {
    star.addEventListener("click", () => {
        const score = star.dataset.score;
        ratingInput.value = score;
        console.log(score);

        stars.forEach((s) => s.classList.remove("active"));
        stars.forEach((s) => {
            if (s.dataset.score <= score) {
                s.classList.add("active");
            }
        });
    });
});
