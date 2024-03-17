<?php

namespace Ivan\Liga;

class StandingsMerge
{
  public array $data = [];
  private array $dataTeams;

  public function __construct(private array $standings)
  {
    $this->dataTeams = array_map(fn ($line) => $line["team"], $this->standings[0]);
    $this->pushData();
    $this->mapData();
  }

  private function pushData()
  {
    $this->data = $this->standings[0];
    for ($i = 1; $i < count($this->standings); $i++) {
      $standings = $this->standings[$i];
      foreach ($standings as $line) {
        if (!in_array($line["team"], $this->dataTeams)) {
          $this->dataTeams[] = $line["team"];
          $this->data[] = $line;
        } else {
          $this->addData($line);
        }
      }
    }
    usort($this->data, function ($a, $b) {
      if ($a["points"] === $b["points"]) return $b["goal_difference"] <=> $a["goal_difference"];
      return $b["points"] <=> $a["points"];
    });
  }

  private function addData($line)
  {
    $index = array_search($line["team"], $this->dataTeams);
    $points = $this->data[$index]["points"] + $line["points"];
    $games = $this->data[$index]["games"] + $line["games"];
    $this->data[$index]["games"] =  $games;
    $this->data[$index]["wins"] =  $this->data[$index]["wins"] + $line["wins"];
    $this->data[$index]["ties"] =  $this->data[$index]["ties"] + $line["ties"];
    $this->data[$index]["losses"] =  $this->data[$index]["losses"] + $line["losses"];
    $this->data[$index]["goals_for"] =  $this->data[$index]["goals_for"] + $line["goals_for"];
    $this->data[$index]["goals_against"] =  $this->data[$index]["goals_against"] + $line["goals_against"];
    $this->data[$index]["goal_difference"] =  $this->data[$index]["goal_difference"] + $line["goal_difference"];
    $this->data[$index]["points"] =  $points;
    $this->data[$index]["possible_points"] =  round($points / ($games * 3), 2);
  }

  private function mapData()
  {
    $this->data = array_map(function ($line, $i) {
      unset($line["position"]);
      return ["position" => $i + 1, ...$line];
    }, $this->data, array_keys($this->data));
  }
}
