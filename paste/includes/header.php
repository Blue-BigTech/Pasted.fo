<!DOCTYPE html>

<html lang="en">


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasted.fo</title>
     <link rel="shortcut icon" href="pn.ico" />
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="codemirror/theme/material-palenight.css">
    <script src="codemirror/lib/codemirror.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="codemirror/mode/xml/xml.js"></script>
    <script src="codemirror/mode/javascript/javascript.js"></script>
    <script src="codemirror/mode/css/css.js"></script>
    <script src="codemirror/mode/sql/sql.js"></script>
    <script src="codemirror/mode/php/php.js"></script>
    <script src="codemirror/mode/python/python.js"></script>
    <script src="codemirror/mode/shell/shell.js"></script>
    <script src="codemirror/mode/clike/clike.js"></script>
    <script src="codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="https://js.hcaptcha.com/1/api.js?hl=en" async defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ec69d3798b.js" crossorigin="anonymous"></script>
    <link href='https://fonts.googleapis.com/css?family=Fredoka One' rel='stylesheet'>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-W6GHLW6E3X"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-W6GHLW6E3X');
</script>

    <style>

        .user-title {

            font-size: 12px !important;

            color: white !important;

            font-family: 'Source Code Pro', monospace;

        }



        .user-info {

            font-size: 12px;

            color: white;

            font-family: 'Source Code Pro', monospace;

        }
    </style>



    <!-- Include the Dark theme -->

    <link rel="stylesheet" href="/node_modules/@sweetalert2/theme-dark/dark.css">

    <script src="/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>

    <script>

        function reqListener() {

            if (this.responseText == "OK") {

                location.reload();

            }

        }



        function remove(id) {

            Swal.fire({

                title: 'Confirm',

                text: "Do you really want to delete that paste?",

                icon: 'question',

                showDenyButton: true,

                confirmButtonText: 'Yes',

                denyButtonText: `No`,

                allowOutsideClick: true

            }).then((result) => {

                /* Read more about isConfirmed, isDenied below */

                if (result.isConfirmed) {

                    const req = new XMLHttpRequest();

                    req.addEventListener("load", reqListener);

                    req.open("GET", "deletepaste.php?pid=" + id);

                    req.send();

                } else if (result.isDenied) {



                }

            })

        }

    </script>

    <script>

        function onSubmit(token) {

            document.getElementById("hcpr").value = token;

            document.getElementById("regform").submit();

        }

    </script>



    <script>

        function login(token) {

            document.getElementById("hcpr").value = token;

            document.getElementById("logform").submit();

        }

    </script>

        <script>

        function createpost(token) {

            document.getElementById("hcpr").value = token;

            document.getElementById('createnewpost').submit();

        }

    </script>
    <script>
        function myFunction() {
    var x = document.getElementById("centered_nav");
    if (x.className === "rc_nav") {
        x.className += " responsive";
    } else {
        x.className = "rc_nav";
    }
}
    </script>




</head>



<?php



        $accounttext = "Account";

        $accountug = 0;



        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {

            $accounttext = $_SESSION["username"];

            $ugres = $mysqli->query("SELECT usergroup FROM accounts WHERE username = '{$_SESSION["username"]}';");

            $ugrow = mysqli_fetch_array($ugres);

            $accountug = $ugrow["usergroup"];

        }



        ?>
    

<body>

<div class="wrapper">
 <div class="header">
<h3><a href="/">Create Paste</a></h3>
<h3><a href="/top">Top Pastes</a></h3>
<h3><a href="/recent">Recent Pastes</a></h3>
<h3><a href="/settings">Settings</a></h3>
<h3><a href="/dashboard">Account</a></h3>
</div>               
  </div>


        <script>

            /* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */

            function myFunction() {

                var x = document.getElementById("myTopnav");

                if (x.className === "topnav") {

                    x.className += " responsive";

                } else {

                    x.className = "topnav";

                }

            }

        </script>