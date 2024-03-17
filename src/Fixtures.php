<?php

namespace Ivan\Liga;

use Exception;

class Fixtures
{
  private array $teams =
  [
    "Alianza",
    "América",
    "Águilas",
    "Bucaramanga",
    "Cali",
    "Cartagena",
    "Centauros",
    "Chicó",
    "Cúcuta",
    "Pasto",
    "Envigado",
    "Fortaleza",
    "Huila",
    "Itagüí",
    "Jaguares",
    "Junior",
    "La Equidad",
    "Leones",
    "Magdalena",
    "Medellín",
    "Millonarios",
    "Nacional",
    "Once Caldas",
    "Patriotas",
    "Pasto",
    "Pereira",
    "Quindío",
    "Santa Fe",
    "Tigres",
    "Tolima",
    "Tuluá",
    "Uniautónoma",
  ];
  public array $activeTeams = [];
  private array $rawData = [];
  private string $decade;
  private string $year;
  public array $data = [];

  public function __construct(string $decade, string $year)
  {
    $this->decade = $decade;
    $this->year = $year;
    $this->getRawData("../src/results/$this->decade/$this->year.txt");
    $this->getData();
    $this->getActiveTeams();
  }

  private function getRawData($file_path)
  {
    if (file_exists($file_path)) {
      $file = fopen($file_path, "r");
      if (!$file) {
        http_response_code(404);
        die();
      }
      while (!feof($file)) {
        $this->rawData[] = fgets($file);
      }
      fclose($file);
    } else {
      http_response_code(404);
      die();
    }
  }

  private function getData()
  {
    $round = 0;
    foreach ($this->rawData as $line) {
      $line_is_round = str_contains($line, "Fecha") || str_contains($line, "Round");
      if ($line_is_round) $round++;
      $result = $this->getResult($line);
      if (isset($result["separator_position"])) {
        $home = $this->getTeam("home", $line, $result["separator_position"]);
        $away = $this->getTeam("away", $line, $result["separator_position"]);
        unset($result["separator_position"]);
        if ($home && $away && $result) $this->data[] = ["round" => $round, "home" => $home, ...$result, "away" => $away];
      }
    }
  }

  private function getTeam(string $team_status, string $line, int $separator_position): null|string
  {
    foreach ($this->teams as $team) {
      if (str_contains($line, $team)) {
        $team_position = strpos($line, $team);
        if ($team_status === "home")
          if ($team_position < $separator_position) return $team;
        if ($team_status === "away")
          if ($team_position > $separator_position) return $team;
      }
    }
    return null;
  }

  private function getResult(string $line): null|array
  {
    if (str_contains($line, ":")) $separator = ":";
    else if (str_contains($line, "-")) $separator = "-";
    else return null;
    $separator_position = strpos($line, $separator);
    $home_goals = (int) trim(substr($line, $separator_position - 2, 2));
    $away_goals = (int) trim(substr($line, $separator_position + 1, 2));
    return ["separator_position" => $separator_position, "home_goals" => $home_goals, "away_goals" => $away_goals];
  }

  private function getActiveTeams()
  {
    foreach ($this->data as $match) {
      if (!in_array($match["home"], $this->activeTeams)) $this->activeTeams[] = $match["home"];
      if (!in_array($match["away"], $this->activeTeams)) $this->activeTeams[] = $match["away"];
    }
  }
}
