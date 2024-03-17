export default class Table {
  faSorts = document.querySelectorAll('.fa-sort')
  tbody = document.querySelector('tbody')

  constructor(data) {
    this.data = data
    this.faSorts.forEach(icon => icon.addEventListener("click", e => this.handleFaSortClick(e)))
  }

  handleFaSortClick(e) {
    this.sort = e.target.dataset.sort
    this.resetFaSort()
    this.handleClassSorts(e)
    this.sortData()
    this.renderTable()
  }

  resetFaSort() {
    this.faSorts.forEach(icon => {
      if (icon.dataset.sort !== this.sort) icon.className = "fa-solid fa-sort"
    })
  }

  handleClassSorts(e) {
    if (e.target.classList.contains("fa-sort")) {
      this.sortPosition = "up"
      e.target.classList.add("fa-sort-up")
      e.target.classList.remove("fa-sort")
    } else if (e.target.classList.contains("fa-sort-up")) {
      this.sortPosition = "down"
      e.target.classList.add("fa-sort-down")
      e.target.classList.remove("fa-sort-up")
    } else if (e.target.classList.contains("fa-sort-down")) {
      this.sortPosition = "up"
      e.target.classList.add("fa-sort-up")
      e.target.classList.remove("fa-sort-down")
    }
  }

  sortData() {
    if (this.sortPosition === "down" && this.sort === "points") this.sortPointsDesc()
    else if (this.sortPosition === "up" && this.sort === "points") this.sortPointsAsc()
    else if (this.sortPosition === "up")
      this.data = this.data.sort((a, b) => b[this.sort] - a[this.sort])
    else if (this.sortPosition === "down")
      this.data = this.data.sort((a, b) => a[this.sort] - b[this.sort])
  }  

  trHtml(line) {
    return `
      <tr>
        <td>${line["position"]}</td>
        <td style="text-align:left">${line["team"]}</td>
        <td>${line["games"]}</td>
        <td>${line["wins"]}</td>
        <td>${line["ties"]}</td>
        <td>${line["losses"]}</td>
        <td>${line["goals_for"]}</td>
        <td>${line["goals_against"]}</td>
        <td>${line["goal_difference"]}</td>
        <td>${line["points"]}</td>
        <td>${Math.round(line["possible_points"]*100)}</td>
      </tr>
    `
  }

  renderTable() {
    this.tbody.innerHTML = this.data.map(line => this.trHtml(line)).join("")
  }

  sortPointsDesc() {
    this.data.sort((a, b) => {
      if (a["points"] === b["points"]) {
        return a["goal_difference"] - b["goal_difference"]
      } else return a["points"] - b["points"]
    })
  }

  sortPointsAsc() {
    this.data.sort((a, b) => {
      if (a["points"] === b["points"]) {
        return b["goal_difference"] - a["goal_difference"]
      } else return b["points"] - a["points"]
    })
  }
}