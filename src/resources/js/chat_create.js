//   チャット画像プレビュー
// =============================
const realFile = document.getElementById("realFile");
const previewContainer = document.getElementById("preview-container");
if (realFile && previewContainer) {
    realFile.addEventListener("change", function () {
        previewContainer.innerHTML = "";
        Array.from(this.files).forEach((file) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.maxWidth = "100px";
                img.style.marginRight = "5px";
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
}

//   チャット本文 draft 保存
// =============================

const input = document.getElementById("chat-input");

const itemId = document.querySelector("[data-item-id]")?.dataset.itemId;

const key = itemId ? `chat_draft_${itemId}` : "chat_draft";

if (input) {
    input.value = localStorage.getItem(key) || "";

    input.addEventListener("input", () => {
        localStorage.setItem(key, input.value);
    });

    const form = document.getElementById("chat-form");
    if (form) {
        form.addEventListener("submit", () => {
            localStorage.removeItem(key);
        });
    }
}
