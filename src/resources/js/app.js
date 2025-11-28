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

    // ページ表示時：全体未読の復元
    let total = getTotalUnread();
    console.log("全体未読:", total);

    if (badge) {
        badge.textContent = total > 0 ? total : "";
        badge.style.display = total > 0 ? "inline-block" : "none";
    }

    // メッセージ受信処理
    if (userId) {
        window.Echo.private(`chat.${userId}`).listen(".MessageSent", (e) => {
            console.log("受信:", e);

            const sender = Number(e.sender_id);
            const item = Number(e.item_id);

            if (sender === userId) return;
            if (currentItemId === item) return;

            const key = `badge_item_${item}`;
            const prev = Number(localStorage.getItem(key)) || 0;
            const next = prev + 1;
            localStorage.setItem(key, next);

            total = getTotalUnread();

            if (badge) {
                badge.textContent = total > 0 ? total : "";
                badge.style.display = total > 0 ? "inline-block" : "none";
            }
        });
    }

    // チャットページの場合：その itemId 未読だけリセット
    if (currentItemId !== null) {
        console.log("リセット対象 item:", currentItemId);

        localStorage.setItem(`badge_item_${currentItemId}`, 0);

        total = getTotalUnread();
        console.log("全体未読（再）:", total);

        if (badge) {
            badge.textContent = total > 0 ? total : "";
            badge.style.display = total > 0 ? "inline-block" : "none";
        }
    }

    // 商品一覧ページ：個別未読バッジ表示
    document.querySelectorAll(".item-row").forEach((row) => {
        const itemId = row.dataset.itemId;
        const badgeElem = row.querySelector(`#badge-item-${itemId}`);

        if (!badgeElem) return;

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
