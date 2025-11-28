//   プロフィール画像即時表示
// =============================
const profile = document.getElementById("profile_image");
if (profile) {
    profile.addEventListener("change", function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById("preview");
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                preview.src = event.target.result;
                preview.style.display = "inline";
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = "none";
        }
    });
}
