<table class="table">
  <thead class="thead-dark">
    <tr>
      <th colspan="3" style="text-align:center;">Connection Information</th>
    </tr>
  </thead>
  <tbody>
    <tr class="table-active">
      <th scope="row"></th>
      <td>USERNAME</td>
      <td><?php echo $_SESSION['username']; ?></td>
    </tr>
    <tr class="table-active">
      <th scope="row"></th>
      <td>NAME</td>
      <td><?php echo $_SESSION['name']; ?></td>
    </tr>
    <tr class="table-active">
      <th scope="row"></th>
      <td>LOCATION</td>
      <td><?php echo $_SESSION['location']; ?></td>
    </tr>
    <tr class="table-active">
    <th scope="row"></th>
      <td>EMAIL</td>
      <td><?php echo $_SESSION['email']; ?></td>
    </tr>
    <tr class="table-active">
      <th scope="row"></th>
      <td>SOCIAL MEDIA</td>
      <td><?php echo $_SESSION['link']; ?></td>
    </tr>
    <tr class="table-active">
      <th scope="row"></th>
      <th>SKILL</th>
      <td>
        <?php 
            foreach($_SESSION['skills'] as $skill){
                echo "<span class='badge badge-secondary'>".$skill['skill_name']."</span>";
            }
        ?>
      </td>
    </tr>
  </tbody>
</table>
<div class="row">
    <div class="col" style="text-align: center;">
        <a href='add.php' class='btn btn-outline-light'>UPDATE</a>
    </div>
</div>