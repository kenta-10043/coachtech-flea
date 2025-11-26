import "./bootstrap";

// ----------------------
// URL から item_id を取得
// ----------------------
function getItemIdFromPath() {
    const m = window.location.pathname.match(/^\/chat\/(\d+)/);
    return m ? Number(m[1]) : null;
}

// ----------------------
// 全体未読数を計算して返す
// ----------------------
function getTotalUnread() {
    let sum = 0;
    for (const key in localStorage) {
        if (key.startsWith("badge_item_")) {
            sum += Number(localStorage.getItem(key)) || 0;
        }
    }
    return sum;
}

document.addEventListener("DOMContentLoaded", () => {
    const userId = Number(
        document.querySelector('meta[name="user-id"]')?.content
    );
    const badge = document.getElementById("chat-badge");
    const currentItemId = getItemIdFromPath();

    console.log("userId:", userId);
    console.log("現在のページ itemId:", currentItemId);

    // ==========================================
    // ① ページ表示時：全体未読の復元
    // ==========================================
    let total = getTotalUnread();
    console.log("全体未読:", total);

    if (badge) {
        badge.textContent = total > 0 ? total : "";
        badge.style.display = total > 0 ? "inline-block" : "none";
    }

    // ==========================================
    // ② メッセージ受信処理
    // ==========================================
    if (userId) {
        window.Echo.private(`chat.${userId}`).listen("MessageSent", (e) => {
            console.log("受信:", e);

            const sender = Number(e.sender_id);
            const item = Number(e.item_id);

            // 自分のメッセージ → カウント不要
            if (sender === userId) return;

            // 今開いているチャット → カウント不要
            if (currentItemId === item) {
                console.log("今開いているチャット → 未読にしない");
                return;
            }

            // -------- 個別未読 +1 --------
            const key = `badge_item_${item}`;
            const prev = Number(localStorage.getItem(key)) || 0;
            const next = prev + 1;
            localStorage.setItem(key, next);

            console.log(`item ${item} 未読 ${prev} → ${next}`);

            // -------- 全体未読再計算 --------
            total = getTotalUnread();
            console.log("全体未読 →", total);

            if (badge) {
                badge.textContent = total > 0 ? total : "";
                badge.style.display = total > 0 ? "inline-block" : "none";
            }
        });
    }

    // ==========================================
    // ③ チャットページの場合：その itemId 未読だけリセット
    // ==========================================
    if (currentItemId) {
        console.log("リセット対象 item:", currentItemId);

        // この itemId の未読だけリセット
        localStorage.setItem(`badge_item_${currentItemId}`, 0);

        // 全体未読再計算
        total = getTotalUnread();
        console.log("全体未読（再）:", total);

        if (badge) {
            badge.textContent = total > 0 ? total : "";
            badge.style.display = total > 0 ? "inline-block" : "none";
        }
    }

    // =============================
    // 🔵 商品一覧ページ：個別未読バッジ表示
    // =============================
    document.querySelectorAll(".item-row").forEach((row) => {
        const itemId = row.dataset.itemId;
        const badgeElem = row.querySelector(`#badge-item-${itemId}`);

        if (!badgeElem) return;

        // localStorage の個別未読取得
        const unread =
            Number(localStorage.getItem(`badge_item_${itemId}`)) || 0;

        if (unread > 0) {
            badgeElem.textContent = unread;
            badgeElem.style.display = "inline-block";
        } else {
            badgeElem.textContent = "";
            badgeElem.style.display = "none";
        }
    });
});

// =============================
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

// =============================
//   購入方法選択 即時反映
// =============================
const select = document.getElementById("payment_method");
const display = document.getElementById("selectedPayment");
if (select && display) {
    display.textContent = select.options[select.selectedIndex].text;
    select.addEventListener("change", function () {
        display.textContent = this.options[this.selectedIndex].text;
    });
}

// =============================
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

// =============================
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

// =============================
//   チャット本文 draft 保存
// =============================
const input = document.getElementById("chat-input");
if (input) {
    input.value = localStorage.getItem("chat_draft") || "";
    input.addEventListener("input", () => {
        localStorage.setItem("chat_draft", input.value);
    });
}
