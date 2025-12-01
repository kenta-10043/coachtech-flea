//   出品画像プレビュー
// =============================
const itemImage = document.getElementById("item_image");
const previewImg = document.getElementById("preview");
if (itemImage && previewImg) {
    itemImage.addEventListener("change", function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                previewImg.src = event.target.result;
                previewImg.style.display = "block";
            };
            reader.readAsDataURL(file);
        } else {
            previewImg.style.display = "none";
        }
    });
}
