<?php
    // Check if the event ID and slot time parameters exist in the URL
    if (isset($_GET['eventId']) && isset($_GET['slotTime'])) {
        // Retrieve the event ID and slot time from the URL query parameters
        $eventId = $_GET['eventId'];
        $slotTime = $_GET['slotTime'];


      
    } else {
        // Handle the case when the required parameters are missing
        echo '<p>Error: Required parameters missing.</p>';
    }
    ?>
    <!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../styles.css">
    <meta charset="UTF-8">
    <title>User Information</title>
     
    <script src="questions.js"></script>
    
    <script src="../sidebar.js"></script>

    
</head>
<body>
<div class="sidebar">
        <div class="toggle-button" onclick="toggleSidebar()">
            <span class="toggle-icon"></span>
        </div>
        <ul>
            <li><a href="../events/create_event.html">Vytvořit událost</a></li>
            <li><a href="../events/event_list.php">Události</a></li>
            <li><a href="questions.html">Dotazník</a></li>
        </ul>
    </div>

    <div class="content">
    <div class="page-container">

    <form action="submit.php?eventId=<?php echo $eventId; ?>&slotTime=<?php echo urlencode($slotTime); ?>" method="POST" onsubmit="return validateForm()">
    <h3>Podrobnosti dítěte</h3>
    
    <div class="field-group">
            <label for="firstname">Jméno<span class="required">*</span></label>
            <input class="text" type="text" id="firstname" name="firstname" required>
        </div>

        <div class="field-group">
            <label for="lastname">Příjmení<span class="required">*</span></label>
            <input class="text" type="text" id="lastname" name="lastname" required>
        </div>

        <div class="field-group">
            <label for="childBirthDay">Narození<span class="required">*</span></label>

            <input class="text" type="text" id="childBirthDay" name="childBirthDay"  required>
        </div>

        <div class="field-group">
            <label for="childHomeAddressStreet">Ulice<span class="required">*</span></label>
            <input class="text" type="text" id="childHomeAddressStreet" name="childHomeAddressStreet" required>
        </div>

        <div class="field-group">
            <label for="childHomeAddressNumber">Orientační číslo<span class="required">*</span></label>
            <input class="text" type="text" id="childHomeAddressNumber" name="childHomeAddressNumber" required>
        </div>

        <div class="field-group">
            <label for="childHomeAddressCity">Město<span class="required">*</span></label>
            <input class="text" type="text" id="childHomeAddressCity" name="childHomeAddressCity" required>
        </div>

        <div class="field-group">
            <label for="childHomeAddressPostcode">PSČ<span class="required">*</span></label>
            <input class="text" type="text" id="childHomeAddressPostcode" name="childHomeAddressPostcode" required>
        </div>

        <h3>Podrobnosti zákonného zástupce</h3>
        <fieldset class="group">
            <legend><span>Shodné bydliště</span></legend>
            <div class="checkbox">
                <input class="checkbox" type="checkbox" name="sameAddress" id="sameAddress" onclick="copyChildAddress()">
                <label for="sameAddress">&nbsp;</label>
            </div>
            <div>Zákonný zástupce má shodné bydliště jako dítě</div>
        </fieldset>

            <div class="field-group">
                <label for="legalRepresentativeFirstname">Jméno<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeFirstname" name="legalRepresentativeFirstname" required>
            </div>

            <div class="field-group">
                <label for="legalRepresentativeSurname">Příjmení<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeSurname" name="legalRepresentativeSurname" required>
            </div>

            <div class="field-group">
                <label for="legalRepresentativeEmail">E-mail<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeEmail" name="legalRepresentativeEmail" required>
            </div>

            <div class="field-group">
                <label for="legalRepresentativePhone">Telefon<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativePhone" name="legalRepresentativePhone" required>
            </div>

            <div class="field-group">
                <label for="legalRepresentativeHomeAddressStreet">Ulice<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeHomeAddressStreet" name="legalRepresentativeHomeAddressStreet" required>
            </div>

            <div class="field-group">
                <label for="legalRepresentativeHomeAddressNumber">Orientační číslo<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeHomeAddressNumber" name="legalRepresentativeHomeAddressNumber" required>
            </div>

            <div class="field-group">
                <label for="legalRepresentativeHomeAddressCity">Město<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeHomeAddressCity" name="legalRepresentativeHomeAddressCity" required>
            </div>
          
            <div class="field-group">
                <label for="legalRepresentativeHomeAddressPostcode">PSČ<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeHomeAddressPostcode" name="legalRepresentativeHomeAddressPostcode" required>
            </div>

            <div class="field-group">
    <label for="note">Čas rezervace</label>
    <textarea class="textarea" id="note" name="note" readonly><?php echo isset($_GET['slotTime']) ? $_GET['slotTime'] : ''; ?></textarea>

</div>
<div class="field-group">
<label for="eventDate">Datum rezervace</label>
<textarea class="textarea" id="eventDate" name="eventDate" readonly><?php echo isset($_GET['startDate']) ? date('d.m.Y', strtotime($_GET['startDate'])) : ''; ?></textarea>
</div>
  

        <button type="submit">Submit</button>
        <a href="../events/event_list_user.php">Zrušit</a>

        
    </form>
</div>
</div>

</body>
</html>
