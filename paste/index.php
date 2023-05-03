<?php
// Import config.php
require_once("includes/config.php");

session_start();


$currentvisibility = "public";

if (isset($_COOKIE["visibility"])) {
    $currentvisibility = $_COOKIE["visibility"];
}

?>

<div class="wrapper">


    <?php
    include 'includes/header.php';
    include("includes/ads.php");
    ?>

    <div class="page-header">
        <div class="page-header">
            <h2 class="pagetitle">Create Paste</h2>
        </div>
    </div>
    <form id="createnewpost" method="POST" action="create.php">
        <textarea id="editor" name="content"></textarea>

        <div class="form-elements">
            <input maxlength="50" name="title" type="text" placeholder="Untitled Paste" class="form-element">

            <input maxlength="20" name="password" type="text" placeholder="Password (Optional)" class="form-element">

            <select onchange="changesyntax();" id="syntax" name="syntax" class="form-element">
                <option value="plain">No Syntax</option>
                <option value="html">HTML</option>
                <option value="javascript">Javascript</option>
                <option value="css">CSS</option>
                <option value="xml">XML</option>
                <option value="x-sql">SQL</option>
                <option value="x-php">PHP</option>
                <option value="x-java">Java</option>
                <option value="x-csharp">C#</option>
                <option value="x-sh">Shell</option>
                <option value="x-python">Python</option>
                <option value="x-c++src">C++</option>
            </select>
            <select id="expire" name="expire" class="form-element">
                <option value="0">Never Expires</option>
                <option value="1800">30 Minutes</option>
                <option value="3600">1 Hour</option>
                <option value="43200">12 Hours</option>
                <option value="86400">1 Day</option>
                <option value="259200">3 Days</option>
                <option value="604800">7 Days</option>
                <option value="2592000">1 Month</option>
            </select>
            <select id="visibility" name="visibility" class="form-element">
                <option value="public" <?php if ($currentvisibility == "public") {
                    echo "selected";
                } ?>>Public</option>
                <option value="private" <?php if ($currentvisibility == "private") {
                    echo "selected";
                } ?>>Private</option>
            </select>
            <div class="h-captcha" data-sitekey="10ad4f4d-07a7-4e60-b0cf-d903c6b3f539"></div>
            <button type="submit" name="createpost">Paste</button>
        </div>
    </form>
</div>


<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
        mode: "text/plain",
        theme: 'material-palenight',
        inputStyle: 'textarea',
        lineNumbers: true
    })

    function changesyntax() {
        var syntax = document.getElementById("syntax");
        editor.setOption("mode", "text/" + syntax.value);
    }
</script>

</body>

</html>
<?php include 'includes/footer.php'; ?>