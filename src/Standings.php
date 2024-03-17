<?php

namespace Ivan\Liga;

require_once "../vendor/autoload.php";

class Standings
{
  public array $data = [];
  public array $homeData = [];
  public array $awayData = [];

  public function __construct(private Fixtures $fixtures)
  {
    $this->getData();
  }

  private function getData()
  {
    $defaultValues = ["wins" => 0, "ties" => 0, "losses" => 0, "goals_for" => 0, "goals_against" => 0];
    $this->data = array_map(fn ($team) => ["team" => $team, ...$defaultValues], $this->fixtures->activeTeams);
    $this->homeData = array_map(fn ($team) => ["team" => $team, ...$defaultValues], $this->fixtures->activeTeams);
    $this->awayData = array_map(fn ($team) => ["team" => $team, ...$defaultValues], $this->fixtures->activeTeams);
    $dataCopy = array_map(fn ($team) => ["team" => $team], $this->fixtures->activeTeams);
    foreach ($this->fixtures->data as $fixture) {
      $homeIndex = array_search(["team" => $fixture["home"]], $dataCopy);
      $awayIndex = array_search(["team" => $fixture["away"]], $dataCopy);
      foreach ($this->data as $dataLine) {
        $this->getHomeStats($fixture, $dataLine, $homeIndex);
        $this->getAwayStats($fixture, $dataLine, $awayIndex);
      }
    }
    $this->computeStats();
  }

  private function getHomeStats(array $fixture, array $dataLine, int $index)
  {
    if ($fixture["home"] === $dataLine["team"]) {
      if ($fixture["home_goals"] > $fixture["away_goals"]) {
        $this->data[$index]["wins"] = $this->data[$index]["wins"] + 1;
        $this->homeData[$index]["wins"] = $this->homeData[$index]["wins"] + 1;
      } else if ($fixture["home_goals"] === $fixture["away_goals"]) {
        $this->data[$index]["ties"] = $this->data[$index]["ties"] + 1;
        $this->homeData[$index]["ties"] = $this->homeData[$index]["ties"] + 1;
      } else if ($fixture["home_goals"] < $fixture["away_goals"]) {
        $this->data[$index]["losses"] = $this->data[$index]["losses"] + 1;
        $this->homeData[$index]["losses"] = $this->homeData[$index]["losses"] + 1;
      }
      $this->data[$index]["goals_for"] = $this->data[$index]["goals_for"] + $fixture["home_goals"];
      $this->data[$index]["goals_against"] = $this->data[$index]["goals_against"] + $fixture["away_goals"];
      $this->homeData[$index]["goals_for"] = $this->homeData[$index]["goals_for"] + $fixture["home_goals"];
      $this->homeData[$index]["goals_against"] = $this->homeData[$index]["goals_against"] + $fixture["away_goals"];
    }
  }

  private function getAwayStats(array $fixture, array $dataLine, int $index)
  {
    if ($fixture["away"] === $dataLine["team"]) {
      if ($fixture["away_goals"] > $fixture["home_goals"]) {
        $this->data[$index]["wins"] = $this->data[$index]["wins"] + 1;
        $this->awayData[$index]["wins"] = $this->awayData[$index]["wins"] + 1;
      } else if ($fixture["away_goals"] === $fixture["home_goals"]) {
        $this->data[$index]["ties"] = $this->data[$index]["ties"] + 1;
        $this->awayData[$index]["ties"] = $this->awayData[$index]["ties"] + 1;
      } else if ($fixture["away_goals"] < $fixture["home_goals"]) {
        $this->data[$index]["losses"] = $this->data[$index]["losses"] + 1;
        $this->awayData[$index]["losses"] = $this->awayData[$index]["losses"] + 1;
      }
      $this->data[$index]["goals_for"] = $this->data[$index]["goals_for"] + $fixture["away_goals"];
      $this->data[$index]["goals_against"] = $this->data[$index]["goals_against"] + $fixture["home_goals"];
      $this->awayData[$index]["goals_for"] = $this->awayData[$index]["goals_for"] + $fixture["away_goals"];
      $this->awayData[$index]["goals_against"] = $this->awayData[$index]["goals_against"] + $fixture["home_goals"];
    }
  }

  private function computeStats()
  {
    $this->data = $this->mapStats($this->data);
    $this->homeData = $this->mapStats($this->homeData);
    $this->awayData = $this->mapStats($this->awayData);

    $this->sort();

    $this->data = array_map(fn ($line, $i) => ["position" => $i + 1, ...$line], $this->data, array_keys($this->data));
    $this->homeData = array_map(fn ($line, $i) => ["position" => $i + 1, ...$line], $this->homeData, array_keys($this->homeData));
    $this->awayData = array_map(fn ($line, $i) => ["position" => $i + 1, ...$line], $this->awayData, array_keys($this->awayData));
  }

  private function mapStats(array $data): array
  {
    return array_map(function ($statLine) {
      $games = $statLine["wins"] + $statLine["ties"] + $statLine["losses"];
      $goalDifference = $statLine["goals_for"] - $statLine["goals_against"];
      $points = $statLine["wins"] * 3 + $statLine["ties"];
      $possiblePoints = round($points / ($games * 3), 2);
      return ["games" => $games, ...$statLine, "goal_difference" => $goalDifference, "points" => $points, "possible_points" => $possiblePoints];
    }, $data);
  }

  private function sort()
  {
    usort($this->data, function ($a, $b) {
      if ($a["points"] === $b["points"]) return $b["goal_difference"] <=> $a["goal_difference"];
      return $b["points"] <=> $a["points"];
    });
    usort($this->homeData, function ($a, $b) {
      if ($a["points"] === $b["points"]) return $b["goal_difference"] <=> $a["goal_difference"];
      return $b["points"] <=> $a["points"];
    });
    usort($this->awayData, function ($a, $b) {
      if ($a["points"] === $b["points"]) return $b["goal_difference"] <=> $a["goal_difference"];
      return $b["points"] <=> $a["points"];
    });
  }
}
