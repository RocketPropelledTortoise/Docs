<?php

require 'vendor/autoload.php';

use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Parser;


// Configuration
//------------------------------

$basepath = dirname(__DIR__) . '/src';
$docpath = dirname(__DIR__);
$templates = __DIR__ . '/templates';


// Helpers
//------------------------------

function check_diff_multi($array1, $array2){
	$result = array();
	foreach($array1 as $key => $val) {
		if(isset($array2[$key])){
       		if(is_array($val) && $array2[$key]){
				$res = check_diff_multi($val, $array2[$key]);
				if (!empty($res)) {
					$result[$key] = $res;
				}
			}
		} else {
			$result[$key] = $val;
		}
    }

    return $result;
}

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

function addHeaderToPage($source, $destination, array $options)
{
    l("Preparing $destination");
    $content = file_get_contents($source);

    $header = "title: " . basename($destination, ".md") . "\n";
	foreach($options as $key => $value) {
		$header .= "$key: $value\n";
	}

    file_put_contents($destination, "---\n$header\n---\n$content");
}

function writeToc($base_url, $sections, $destination)
{
	global $basepath;

	l("Generating Table of content in $destination");

	$clean_sections = [];
    foreach ($sections as $section => $pages) {
        foreach ($pages as $page) {
            $clean_sections[$section][] = str_replace('.md', '', $page);
        }
    }

	$final_sections = $clean_sections;
	if (file_exists($basepath . $base_url . "/toc.yml")) {
		$final_sections = (new Parser())->parse(file_get_contents($basepath . $base_url . "/toc.yml"));

		$not_in_files = check_diff_multi($final_sections, $clean_sections);
		foreach($not_in_files as $section => $pages) {
			foreach ($pages as $page) {
				l("=> $section/$page is in toc.yml but no file is corresponding.");
			}
		}

		$not_in_toc = check_diff_multi($clean_sections, $final_sections);
		foreach($not_in_toc as $section => $pages) {
			foreach ($pages as $page) {
				l("=> $section/$page is missing from toc.yml");
			}
		}
	}


    $content = "<ul class=nav>\n";
    foreach ($final_sections as $section => $pages) {
        $content .= "<li><strong>$section</strong><ul class=nav>\n";
        foreach ($pages as $page) {
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

        //generate table of contents
        $toc = "toc_" . slugify("{$project}_{$component}");
        writeToc("/$project/$component", $sections, "$docpath/_includes/{$toc}.html");
        writeComponentLayout($toc);

        mkdirIfNonExistent("$docpath/$project/$component");

        //find or create homepage
        if (array_key_exists("Getting Started", $sections)
            && in_array("Introduction.md", $sections["Getting Started"])
        ) {
            $homepage[$project][$component] = "Getting Started/Introduction.html";

            // Index page short link
            $redirect = file_get_contents("$templates/redirect.html");
            $redirect = str_replace('{{link}}', "$project/$component/" . $homepage[$project][$component], $redirect);
            file_put_contents("$docpath/$project/$component/index.html", $redirect);
        } else {
            addHeaderToPage(
				"$templates/dummy_index.md",
				"$docpath/$project/$component/index",
				['layout' => $toc, 'component' => "$project / $component"]
			);
            $homepage[$project][$component] = "";
        }

        foreach ($sections as $section => $pages) {
            mkdirIfNonExistent("$docpath/$project/$component/$section");

            foreach ($pages as $page) {
                addHeaderToPage(
                    "$basepath/$project/$component/$section/$page",
                    "$docpath/$project/$component/$section/$page",
                    ['layout' => $toc, 'component' => "$project / $component"]
                );
            }
        }
    }
}

// Prepare homepage
$content = "---\nlayout: default\ntitle: Index\ncomponent: Documentation\n---\n";
foreach ($homepage as $project => $components) {
    $content .= "\n## $project\n";
    foreach ($components as $component => $link) {
        $content .= "### [$component]({{site.github.url}}/$project/$component/$link)\n";
    }
}
file_put_contents("$docpath/index.md", $content);
