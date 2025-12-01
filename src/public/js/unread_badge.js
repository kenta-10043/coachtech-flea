//チャットの未読クリア処理
//======================

document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll(".item__link");
    links.forEach((link) => {
        link.addEventListener("click", async (e) => {
            e.preventDefault();

            const formId = link.dataset.formId;
            const form = document.getElementById(formId);

            const token = form.querySelector('[name="_token"]').value;

            await fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: new FormData(form),
            });

            window.location.href = link.href;
        });
    });
});
