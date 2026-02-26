<!DOCTYPE html>
<style>
    <?php require_once 'assets/css/style.css' ?>
</style>

<head>
    <?php require_once '../includes/head.php' ?>
    <title>Mon premier site web en php</title>
</head>

<body>

    <?php require_once '../includes/head.php' ?>

    <section id="contenu">
        <form class="form">
            <div>
                <label>
                    <input type="text" name="nombre1">
                    <select name="Opérateur">
                        <option value="1" selected>+</option>
                        <option value="2">-</option>
                        <option value="3">*</option>
                        <option value="4">/</option>
                    </select>
                    <input type="text" name="nombre1">
                    <input type="submit" name="bouton-envoyer" value="=">
                </label>
            </div>
        </form>

       <div><a href="https://www.google.com/search?q=php&sca_esv=109ab09de071e349&hl=fr&sxsrf=ANbL-n5G9SmHK3BuzLmpeP31bq3IQUJAUw%3A1770993802495&source=hp&ei=ijiPacizHMi_0PEPpbWC0A8&iflsig=AFdpzrgAAAAAaY9GmvMPYjToNURJT9DyLHrxPXLBwmdm&ved=0ahUKEwjIoPuD2taSAxXIHzQIHaWaAPoQ4dUDCDI&uact=5&oq=php&gs_lp=Egdnd3Mtd2l6IgNwaHAyBRAAGIAEMgUQABiABDIFEAAYgAQyCxAuGIAEGMcBGK8BMgUQABiABDIFEAAYgAQyBRAAGIAEMgUQABiABDIFEAAYgAQyBRAAGIAESMgCUABY0AFwAHgAkAEAmAFSoAHyAaoBATO4AQPIAQD4AQGYAgOgAvsBwgIEECMYJ8ICChAjGIAEGCcYigXCAg4QABiABBixAxiDARiKBcICCxAAGIAEGLEDGIMBwgIOEC4YgAQYsQMY0QMYxwHCAggQABiABBixA8ICDhAuGIAEGLEDGIMBGIoFwgIIEC4YgAQYsQOYAwCSBwEzoAe4IbIHATO4B_sBwgcFMC4yLjHIBwaACAA&sclient=gws-wiz">Liens google</a></div>


    </section>

    <?php require_once '../includes/pied.php' ?>


</body>

</html>