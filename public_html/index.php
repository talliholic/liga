<?php

require_once "../vendor/autoload.php";

use Ivan\Liga\Fixtures;
use Ivan\Liga\Standings;
use Ivan\Liga\StandingsMerge;

$championships = $_GET["campeonatos"] ?? null;
$decades = $_GET["decadas"] ?? null;
$decade = $_GET["decada"] ?? null;
$year = $_GET["campeonato"] ?? null;

if ($championships && $decades) {
  $championships = explode(",", $championships);
  $decades = explode(",", $decades);
  $standingsData = [];
  foreach ($championships as $i => $championship) {
    //MAY COMPUTE FIXTURES TO BE SHOWN LATER ON
    $fixtures = new Fixtures($decades[$i], $championship);
    $standings = new Standings($fixtures);
    $standingsData[] = $standings->data;
  }
  $standings = new StandingsMerge($standingsData);
} else if ($decade && $year) {
  $fixtures = new Fixtures($decade, $year);
  $standings = new Standings($fixtures);
}
$title = "Resultados";
?>

<?php require_once "../src/components/header.php" ?>
<main>
  <?php if ($decade && $championship) : ?>
    <?php require_once "../src/components/selector.php" ?>
  <?php endif ?>
  <?php require_once "../src/components/table.php" ?>
</main>
<?php require_once "../src/components/footer.php" ?>