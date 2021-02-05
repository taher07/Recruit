const ctx = document.querySelector("#stats").getContext("2d");
const chart = new Chart(ctx, {
  type: "pie",
  data: {
    datasets: [
      {
        data: [
          document.querySelector("#accepted").value,
          document.querySelector("#rejected").value
        ],
        backgroundColor: ["#ffcf79", "#e5e4d7"],
        label: "Candidates",
        borderColor: "rgb(66,66,66)"
      }
    ],
    labels: ["Accepted", "Rejected"]
  },
  options: {
    responsive: true
  }
});
