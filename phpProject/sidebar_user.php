<!-- sidebar.php -->

<?php
$baseUrl = 'http://localhost/phpProject';
?>
<div class="sidebar">
        <div class="toggle-button" onclick="toggleSidebar()">
            <span class="toggle-icon"></span>
        </div>
<ul>
    

    <li><a href="https://www.cmczs.cz">Zpět na stránky školy</a></li>
    <li><a href="<?php echo $baseUrl; ?>/events/event_list_user.php">Registrace</a></li>
    <li><a href="<?php echo $baseUrl; ?>/reservations/reservation.php">Všechny rezervace</a></li>

</ul>
</div>

    <script>
function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  sidebar.classList.toggle('show');
}    </script>



