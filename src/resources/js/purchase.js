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
