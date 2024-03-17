<table>
  <caption>Tabla de Posiciones</caption>
  <thead>
    <tr>
      <th>Pos <i data-sort="position" class="fa-solid fa-sort"></i></th>
      <th>Equipo</th>
      <th>PJ<i data-sort="games" class="fa-solid fa-sort"></i></th>
      <th>PG<i data-sort="wins" class="fa-solid fa-sort"></i></th>
      <th>PE<i data-sort="ties" class="fa-solid fa-sort"></i></th>
      <th>PP<i data-sort="losses" class="fa-solid fa-sort"></i></th>
      <th>GF<i data-sort="goals_for" class="fa-solid fa-sort"></i></th>
      <th>GC<i data-sort="goals_against" class="fa-solid fa-sort"></i></th>
      <th>GD<i data-sort="goal_difference" class="fa-solid fa-sort"></i></th>
      <th>PTS<i data-sort="points" class="fa-solid fa-sort"></i></th>
      <th>%<i data-sort="possible_points" class="fa-solid fa-sort"></i></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($standings->data as $line) : ?>
      <tr>
        <td><?= $line["position"] ?></td>
        <td style="text-align:left"><?= $line["team"] ?></td>
        <td><?= $line["games"] ?></td>
        <td><?= $line["wins"] ?></td>
        <td><?= $line["ties"] ?></td>
        <td><?= $line["losses"] ?></td>
        <td><?= $line["goals_for"] ?></td>
        <td><?= $line["goals_against"] ?></td>
        <td><?= $line["goal_difference"] ?></td>
        <td><?= $line["points"] ?></td>
        <td><?= $line["possible_points"] * 100 ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>

</table>
<script type="module">
  import Table from "/scripts/Table.js"

  const data = <?php echo json_encode($standings->data) ?>;

  const table = new Table(data)
</script>