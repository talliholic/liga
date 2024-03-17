<?php
$years = [
  "2024-1",
  "2023-2",
  "2023-1",
  "2022-2",
  "2022-1",
  "2021-2",
  "2021-1",
  "2020",
  "2019-2",
  "2019-1",
  "2018-2",
  "2018-1",
  "2017-2",
  "2017-1",
  "2016-2",
  "2016-1",
  "2015-2",
  "2015-1",
  "2014-2",
  "2014-1",
  "2013-2",
  "2013-1",
  "2012-2",
  "2012-1",
  "2011-2",
  "2011-1",
  "2010-2",
  "2010-1",
  "2009-2",
  "2009-1",
  "2008-2",
  "2008-1",
  "2007-2",
  "2007-1",
  "2006-2",
  "2006-1",
  "2005-2",
  "2005-1",
  "2004-2",
  "2004-1",
  "2003-2",
  "2003-1",
  "2002-2",
  "2002-1",
  "2001",
  "2000",
];
?>

<select name="year" id="selector">
  <?php foreach ($years as $year) : ?>
    <?php if ($championship === $year) : ?>
      <option selected value="<?= $year ?>"><?= $year ?></option>
    <?php else : ?>
      <option value="<?= $year ?>"><?= $year ?></option>
    <?php endif ?>
  <?php endforeach ?>
</select>

<script type="module">
  import Selector from "/scripts/Selector.js"
  const selector = new Selector()
</script>