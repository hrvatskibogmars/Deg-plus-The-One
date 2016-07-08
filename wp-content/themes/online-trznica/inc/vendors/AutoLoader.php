<?php

class AutoLoader {

    private $files = array(
        "global" => "global",
        "custom-post-types" => "custom-post-types",
//        "custom-fields" => "custom-fields",
        "ShortcodeLoader" => "shortcodes/ShortcodeLoader",
        "partials" => "helpers/partials",
        "images" => "helpers/images",
        "relations" => "helpers/relations",
        "UpdateChecker" => "theme-update-checker",
        "plugin-dependency" => "plugin-dependency",
        "scripts" => "scripts",
        "custom-taxonomy" => "custom-taxonomy",

    );


    public function loadFiles() {
        foreach ($this->files as $fileName => $filePath) {
            if (file_exists(INCLUDE_PATH . $filePath . ".php")) {
                require_once INCLUDE_PATH . $filePath . ".php";
            }
        }
    }

    private function glob_recursive($pattern, $flags = 0) {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, $this->glob_recursive($dir . '/' . basename($pattern), $flags));
        }
        return $files;
    }

    public function loadFolders(array $folders, $recursive = false) {
        if ($recursive) {
            $globFunction = function ($path) {
                return $this->glob_recursive($path);
            };
        }
        else {
            $globFunction = function ($path) {
                return glob($path);
            };
        }
        foreach ($folders as $folder) {
            foreach ($globFunction(get_template_directory() . DIRECTORY_SEPARATOR  . trim($folder, '/\\') . DIRECTORY_SEPARATOR . '*.php') as $filename) {
                require_once $filename;
            }
        }
    }

}

$autoLoader = new AutoLoader();
$autoLoader->loadFiles();
$autoLoader->loadFolders(array(
    'inc',
));