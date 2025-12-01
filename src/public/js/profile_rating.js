//評価の平均値表示
//===============

document.addEventListener("DOMContentLoaded", () => {
    const ratingStars = document.querySelectorAll("#stars-box .stars");
    const ratingAvg = document.getElementById("ratingAvg");

    if (!ratingStars.length || !ratingAvg) {
        return;
    }

    const score = Number(ratingAvg.value);

    console.log("評価平均：", score);

    ratingStars.forEach((s) => s.classList.remove("active"));

    ratingStars.forEach((s) => {
        if (Number(s.dataset.score) <= score) {
            s.classList.add("active");
        }
    });
});
