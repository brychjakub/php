<?php
    // Check if the event ID and slot time parameters exist in the URL
    if (isset($_GET['eventId']) && isset($_GET['slotTime'])) {
        // Retrieve the event ID and slot time from the URL query parameters
        $eventId = $_GET['eventId'];
        $slotTime = $_GET['slotTime'];
/* 
        // Display the event ID and slot time
        echo '<p>Event ID: ' . $eventId . '</p>';
        echo '<p>Slot Time: ' . $slotTime . '</p>';
 */
        // Add your question form or other content here
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

</head>
<body>
    <ul>
        <li><a href="../events/create_event.html">Vytvořit událost</a></li>
        <li><a href="../events/event_list.php">Události</a></li>
        <li><a href="questions.html">Dotazník</a></li>
    </ul>
    
    <h1>User Information</h1>
    <div class="page-container">

    <form action="submit.php?eventId=<?php echo $eventId; ?>&slotTime=<?php echo urlencode($slotTime); ?>" method="POST" onsubmit="return validateForm()">
        <div class="field-group">
            <label for="firstname">Jméno<span class="required">*</span></label>
            <input class="text" type="text" id="firstname" name="firstname" required>
            <div class="description">Jméno (Dítě)</div>
        </div>

        <div class="field-group">
            <label for="lastname">Příjmení<span class="required">*</span></label>
            <input class="text" type="text" id="lastname" name="lastname" required>
            <div class="description">Příjmení (Dítě)</div>
        </div>

        <div class="field-group">
            <label for="childBirthDay">Narození<span class="required">*</span></label>
            <input class="text" type="text" id="childBirthDay" name="childBirthDay" value="dd.mm.rrrr" required>
            <div class="description">Narození (Dítě). Datum je ve formátu dd.mm.rrrr</div>
        </div>

        <div class="field-group">
            <label for="childHomeAddressStreet">Ulice<span class="required">*</span></label>
            <input class="text" type="text" id="childHomeAddressStreet" name="childHomeAddressStreet" required>
            <div class="description">Ulice (Dítě)</div>
        </div>

        <div class="field-group">
            <label for="childHomeAddressNumber">Orientační číslo<span class="required">*</span></label>
            <input class="text" type="text" id="childHomeAddressNumber" name="childHomeAddressNumber" required>
            <div class="description">Orientační číslo (Dítě)</div>
        </div>

        <div class="field-group">
            <label for="childHomeAddressCity">Město<span class="required">*</span></label>
            <input class="text" type="text" id="childHomeAddressCity" name="childHomeAddressCity" required>
            <div class="description">Město (Dítě)</div>
        </div>

        <div class="field-group">
            <label for="childHomeAddressPostcode">PSČ<span class="required">*</span></label>
            <input class="text" type="text" id="childHomeAddressPostcode" name="childHomeAddressPostcode" required>
            <div class="description">PSČ (Dítě)</div>
        </div>

        <h3>Podrobnosti zákonného zástupce</h3>
        <fieldset class="group">
            <legend><span>Shodné bydliště</span></legend>
            <div class="checkbox">
                <input class="checkbox" type="checkbox" name="sameAddress" id="sameAddress" onclick="copyChildAddress()">
                <label for="sameAddress">&nbsp;</label>
            </div>
            <div class="description">Zákonný zástupce má shodné bydliště jako dítě</div>
        </fieldset>

        <fieldset>
            <div class="field-group">
                <label for="legalRepresentativeFirstname">Jméno<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeFirstname" name="legalRepresentativeFirstname" required>
                <div class="description">Jméno (Zákonný zástupce)</div>
            </div>

            <div class="field-group">
                <label for="legalRepresentativeSurname">Příjmení<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeSurname" name="legalRepresentativeSurname" required>
                <div class="description">Příjmení (Zákonný zástupce)</div>
            </div>

            <div class="field-group">
                <label for="legalRepresentativeEmail">E-mail<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeEmail" name="legalRepresentativeEmail" required>
                <div class="description">E-mail (Zákonný zástupce)</div>
            </div>

            <div class="field-group">
                <label for="legalRepresentativePhone">Telefon<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativePhone" name="legalRepresentativePhone" required>
                <div class="description">Telefon (Zákonný zástupce)</div>
            </div>

            <div class="field-group">
                <label for="legalRepresentativeHomeAddressStreet">Ulice<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeHomeAddressStreet" name="legalRepresentativeHomeAddressStreet" required>
                <div class="description">Ulice (Zákonný zástupce)</div>
            </div>

            <div class="field-group">
                <label for="legalRepresentativeHomeAddressNumber">Orientační číslo<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeHomeAddressNumber" name="legalRepresentativeHomeAddressNumber" required>
                <div class="description">Orientační číslo (Zákonný zástupce)</div>
            </div>

            <div class="field-group">
                <label for="legalRepresentativeHomeAddressCity">Město<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeHomeAddressCity" name="legalRepresentativeHomeAddressCity" required>
                <div class="description">Město (Zákonný zástupce)</div>
            </div>
          
            <div class="field-group">
                <label for="legalRepresentativeHomeAddressPostcode">PSČ<span class="required">*</span></label>
                <input class="text" type="text" id="legalRepresentativeHomeAddressPostcode" name="legalRepresentativeHomeAddressPostcode" required>
                <div class="description">PSČ (Zákonný zástupce)</div>
            </div>

            <div class="field-group">
                <label for="note">Poznámka</label>
                <textarea class="textarea" type="text" id="note" name="note"></textarea>
                <div class="description">Poznámka (Zákonný zástupce), 250 Maximální počet znaků</div>
            </div>

            
        </fieldset>

        <button type="submit">Submit</button>
        
    </form>
</div>
</body>
</html>
