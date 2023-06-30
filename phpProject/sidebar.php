<!-- sidebar.php -->

<?php
$baseUrl = 'http://localhost/phpProject';
?>
<div class="sidebar">
        <div class="toggle-button" onclick="toggleSidebar()">
            <span class="toggle-icon"></span>
        </div>
<ul>
    <li><a href="<?php echo $baseUrl; ?>/events/create_event.php">vytvořit událost</a></li>
    <li><a href="<?php echo $baseUrl; ?>/events/event_list.php">všechny události</a></li>
    <li><a href="<?php echo $baseUrl; ?>/reservations/reservation_admin.php">všechny rezervace</a></li>
    <li><a href="<?php echo $baseUrl; ?>/login/logout.php">Odhlásit se</a></li>

</ul>
</div>

    <script>
function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  sidebar.classList.toggle('show');
}    </script>



