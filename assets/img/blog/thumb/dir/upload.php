<?php

const ACCESS = true;

include_once 'function.php';

// login


$title = 'Upload files';

include_once 'header.php';

echo '<div class="title">' . $title . '</div>';

if ($dir == null || !is_dir(processDirectory($dir))) {
    echo '<div class="list"><span>The path does not exist</span></div>
            <div class="title">Function</div>
            <ul class="list">
                <li><img src="icon/list.png" alt=""/> <a href="index.php' . $pages['paramater_0'] . '">List</a></li>
            </ul>';
} else {
    $dir = processDirectory($dir);

    if (isset($_POST['submit'])) {
        $isEmpty = true;

        foreach ($_FILES['file']['name'] as $entry) {
            if (!empty($entry)) {
                $isEmpty = false;
                break;
            }
        }

        if ($isEmpty) {
            echo '<div class="notice_failure">File not selected</div>';
        } else {
            for ($i = 0; $i < count($_FILES['file']['name']); ++$i) {
                if (!empty($_FILES['file']['name'][$i])) {
                    if ($_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE) {
                        echo '<div class="notice_failure">File <strong class="file_name_upload">' . $_FILES['file']['name'][$i] . '</strong> Exceeds the allowed size</div>';
                    } else {
                        if (copy($_FILES['file']['tmp_name'][$i], $dir . '/' . str_replace(['_jar', '.jar1', '.jar2'], '.jar', $_FILES['file']['name'][$i])))
                            echo '<div class="notice_succeed">Upload files <strong class="file_name_upload">' . $_FILES['file']['name'][$i] . '</strong>, <span class="file_size_upload">' . size($_FILES['file']['size'][$i]) . '</span> successfully</div>';
                        else
                            echo '<div class="notice_failure">Upload files <strong class="file_name_upload">' . $_FILES['file']['name'][$i] . '</strong> failure</div>';
                    }
                }
            }
        }
    }

    echo '<div class="list">
                <span>' . printPath($dir, true) . '</span><hr/>
                <form action="upload.php?dir=' . $dirEncode . $pages['paramater_1'] . '" method="post" enctype="multipart/form-data">
                    <span class="bull">&bull; </span>File 1:<br/>
                    <input type="file" name="file[]" size="18"/><br/>
                    <span class="bull">&bull; </span>File 2:<br/>
                    <input type="file" name="file[]" size="18"/><br/>
                    <span class="bull">&bull; </span>File 3:<br/>
                    <input type="file" name="file[]" size="18"/><br/>
                    <span class="bull">&bull; </span>File 4:<br/>
                    <input type="file" name="file[]" size="18"/><br/>
                    <span class="bull">&bull; </span>File 5:<br/>
                    <input type="file" name="file[]" size="18"/><br/>
                    <input type="submit" name="submit" value="Upload"/>
                </form>
            </div>
            <div class="title">Function</div>
            <ul class="list">
                <li><img src="icon/create.png" alt=""/> <a href="create.php?dir=' . $dirEncode . $pages['paramater_1'] . '">Create new</a></li>
                <li><img src="icon/import.png" alt=""/> <a href="import.php?dir=' . $dirEncode . $pages['paramater_1'] . '">Import files</a></li>
                <li><img src="icon/list.png" alt=""/> <a href="index.php?dir=' . $dirEncode . $pages['paramater_1'] . '">List</a></li>
            </ul>';
}

include_once 'footer.php';
