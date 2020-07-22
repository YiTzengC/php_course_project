<table class="table table-striped">
  <thead>
    <tr>
      <th colspan="2" style="text-align:center;">Connection Information</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">USERNAME</th>
      <td><?php echo $_SESSION['username']; ?></td>
    </tr>
    <tr>
      <th scope="row">NAME</th>
      <td><?php echo $_SESSION['name']; ?></td>
    </tr>
    <tr>
      <th scope="row">LOCATION</th>
      <td><?php echo $_SESSION['location']; ?></td>
    </tr>
    <tr>
      <th scope="row">EMAIL</th>
      <td><?php echo $_SESSION['email']; ?></td>
    </tr>
    <tr>
      <th scope="row">SOCIAL MEDIA</th>
      <td><?php echo $_SESSION['link']; ?></td>
    </tr>
    <tr>
      <th scope="row">SKILL</th>
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
        <a href='add.php' class='btn btn-secondary'>UPDATE</a>
    </div>
</div>