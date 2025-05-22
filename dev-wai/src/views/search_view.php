<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Wyszukiwarka Zdjęć</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <h1>Wyszukiwarka zdjęć</h1>
        <input type="text" id="search" placeholder="Wyszukaj zdjęcie">
        <div id="results"></div>

        <script>
            $(document).ready(function() {
                $('#search').keyup(function() {
                    var query = $(this).val();
                    $.ajax({
                        url: 'search/image',
                        type: 'POST',
                        data: { query: query },
                        success: function(data) {
                            $('#results').html(data);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
