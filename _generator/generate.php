<?php

require 'vendor/autoload.php';

use Symfony\Component\Finder\Finder;


// Configuration
//------------------------------

$basepath = dirname(__DIR__) . '/src';
$docpath = dirname(__DIR__);
$templates = __DIR__ . '/templates';


// Helpers
//------------------------------

function l($text)
{
    global $docpath;
    echo strtr("$text\n", ["$docpath/" => '']);
}

function addPage(array &$arr, $path)
{
    $path = explode('/', $path);
    $val = array_pop($path);

    $loc = & $arr;
    foreach ($path as $step) {
        $loc = & $loc[$step];
    }
    return $loc[] = $val;
}

function mkdirIfNonExistent($dir)
{
    if (!is_dir($dir)) {
        l("Creating directory $dir");
        mkdir($dir, 0777, true);
    }
}

function addHeaderToPage($source, $destination, $layout)
{
    l("Preparing $destination");
    $content = file_get_contents($source);

    $header = "---\nlayout: $layout\ntitle: " . basename($destination, ".md") . "\n---\n";

    file_put_contents($destination, $header . $content);
}

function writeToc($base_url, $sections, $destination)
{
    l("Generating Table of content in $destination");

    $content = "<ul class=nav>\n";

    foreach ($sections as $section => $pages) {

        $content .= "<li><strong>$section</strong><ul class=nav>\n";
        foreach ($pages as $page) {
            $page = str_replace('.md', '', $page);
            $content .= "<li><a href='{{site.github.url}}$base_url/$section/$page.html'>$page</a></li>\n";
        }
        $content .= "</ul></li>\n";
    }

    $content .= "</ul>\n";

    file_put_contents($destination, $content);
}

function writeComponentLayout($toc)
{
    l("Generating the layout for the component");
    global $templates, $docpath;
    $content = file_get_contents("$templates/layout.html");

    file_put_contents("$docpath/_layouts/{$toc}.html", str_replace('__TOC_LINK__', "$toc.html", $content));
}

/**
 * Generate a URL friendly "slug" from a given string.
 *
 * @param string $title
 * @param string $separator
 * @return string
 */
function slugify($title, $separator = '-')
{
    // Convert all dashes/underscores into separator
    $flip = $separator == '-' ? '_' : '-';
    $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);
    // Remove all characters that are not the separator, letters, numbers, or whitespace.
    $title = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', mb_strtolower($title));
    // Replace all separator characters and whitespace by a single separator
    $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);
    return trim($title, $separator);
}


// Main
//------------------------------

$finder = new Finder();
$finder->files()->name('*.md')->in($basepath);

$files = $homepage = [];
foreach ($finder as $file) {
    addPage($files, $file->getRelativePathname());
}

//Generate pages
foreach ($files as $project => $components) {
    foreach ($components as $component => $sections) {
       l("\nGenerating $project -> $component");

        //TODO :: order the pages according to toc.yml

        //generate table of contents
        $toc = "toc_" . slugify("{$project}_{$component}");
        writeToc("/$project/$component", $sections, "$docpath/_includes/{$toc}.html");
        writeComponentLayout($toc);

        //find or create homepage
        if (array_key_exists("Getting Started", $sections)
            && in_array("Introduction.md", $sections["Getting Started"])
        ) {
            $homepage[$project][$component] = "Getting Started/Introduction.html";
        } else {
            addHeaderToPage("$templates/dummy_index.md", "$docpath/$project/$component/index", $toc);
            $homepage[$project][$component] = "";
        }

        foreach ($sections as $section => $pages) {
            mkdirIfNonExistent("$docpath/$project/$component/$section");

            foreach ($pages as $page) {
                addHeaderToPage(
                    "$basepath/$project/$component/$section/$page",
                    "$docpath/$project/$component/$section/$page",
                    $toc
                );
            }
        }
    }
}

// Prepare homepage
$content = "";
foreach ($homepage as $project => $components) {
    $content .= "\n## $project\n";
    foreach ($components as $component => $link) {
        $content .= "### [$component]({{site.github.url}}/$project/$component/$link)\n";
    }
}

$header = "---\nlayout: default\ntitle: Index\n---\n";
file_put_contents("$docpath/index.md", $header . $content);
