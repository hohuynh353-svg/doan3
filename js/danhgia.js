const ratingInputs = document.querySelectorAll('input[name="rating"]');
const ratingText = document.getElementById("ratingText");

const ratingLabels = {
  1: "Tệ",
  2: "Không hài lòng",
  3: "Bình thường",
  4: "Hài lòng",
  5: "Tuyệt vời",
};

ratingInputs.forEach((input) => {
  input.addEventListener("change", () => {
    const rating = input.value;
    ratingText.textContent = ratingLabels[rating];
  });
});
