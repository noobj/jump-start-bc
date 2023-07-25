import rater from 'rater-js';

let total = 0;
const subTotals = new Map([
  ["Rent", 0],
  ["Food", 0],
  ["Transportation", 0],
  ["Mobile", 0]
]);

const checkboxes = document.querySelectorAll("input[type=checkbox]");

for (const checkbox of checkboxes) {
  checkbox.addEventListener("change", function() {
    const category = this.getAttribute("category");
    let subTotal = subTotals.get(category);

    if (this.checked) {
      total += parseInt(this.value);
      subTotal += parseInt(this.value);
    } else {
      total -= parseInt(this.value);
      subTotal -= parseInt(this.value);
    }

    subTotals.set(category, subTotal);
    document.getElementById("total").innerHTML = total;
    document.getElementById(category + "Total").innerHTML = subTotal;
  })
}
let myRating = rater( {
  element:document.querySelector("#rater"),
  rateCallback:function rateCallback(rating, done) {
    document.getElementsByName('rating')[0].value = rating.toString();
    this.setRating(rating);
    done();
  },
  starSize: 40
});

myRating.enable();
myRating.setRating(5);
