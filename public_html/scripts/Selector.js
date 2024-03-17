export default class Selector {
  div = document.querySelector('#selector')
  championships = [
    {year: "2024-1", decade: "2020s"},
    {year: "2023-2", decade: "2020s"},
    {year: "2023-1", decade: "2020s"},
    {year: "2022-2", decade: "2020s"},
    {year: "2022-1", decade: "2020s"},
    {year: "2021-2", decade: "2020s"},
    {year: "2021-1", decade: "2020s"},
    {year: "2020", decade: "2020s"},
    {year: "2019-2", decade: "2010s"},
    {year: "2019-1", decade: "2010s"},
    {year: "2018-2", decade: "2010s"},
    {year: "2018-1", decade: "2010s"},
    {year: "2017-2", decade: "2010s"},
    {year: "2017-1", decade: "2010s"},
    {year: "2016-2", decade: "2010s"},
    {year: "2016-1", decade: "2010s"},
    {year: "2015-2", decade: "2010s"},
    {year: "2015-1", decade: "2010s"},
    {year: "2014-2", decade: "2010s"},
    {year: "2014-1", decade: "2010s"},
    {year: "2013-2", decade: "2010s"},
    {year: "2013-1", decade: "2010s"},
    {year: "2012-2", decade: "2010s"},
    {year: "2012-1", decade: "2010s"},
    {year: "2011-2", decade: "2010s"},
    {year: "2011-1", decade: "2010s"},
    {year: "2010-2", decade: "2010s"},
    {year: "2010-1", decade: "2010s"},
    {year: "2009-2", decade: "2000s"},
    {year: "2009-1", decade: "2000s"},
    {year: "2008-2", decade: "2000s"},
    {year: "2008-1", decade: "2000s"},
    {year: "2007-2", decade: "2000s"},
    {year: "2007-1", decade: "2000s"},
    {year: "2006-2", decade: "2000s"},
    {year: "2006-1", decade: "2000s"},
    {year: "2005-2", decade: "2000s"},
    {year: "2005-1", decade: "2000s"},
    {year: "2004-2", decade: "2000s"},
    {year: "2004-1", decade: "2000s"},
    {year: "2003-2", decade: "2000s"},
    {year: "2003-1", decade: "2000s"},
    {year: "2002-2", decade: "2000s"},
    {year: "2002-1", decade: "2000s"},
    {year: "2001", decade: "2000s"},
    {year: "2000", decade: "2000s"},
  ]

  constructor() {
    this.div.addEventListener("change", e => this.changeHandler(e))
  }

  changeHandler(e) {
    const year = e.target.value
    const champtionship = this.championships.find(champtionship => champtionship.year === year)
    window.location.replace(`/?decada=${champtionship.decade}&campeonato=${year}`)
  }
}