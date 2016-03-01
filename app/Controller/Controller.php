<?php

namespace SierraSql\Controller;

use League\Csv\Reader;
use League\Csv\Writer;
use \SplTempFileObject;
use League\Plates\Engine;

class Controller
{
	protected $templates;

	public function __construct()
	{
		$this->templates = new Engine('../app/View');
		$this->templates->addFolder('layout', '../app/View/layout');
		$this->templates->addFolder('shared', '../app/View/shared');

		// This function takes a date as formatted by Postgresql and turns it into 
		// American standard date format:  mm/dd/YYYY
		$this->templates->registerFunction('normalizeDate', function ($string) {
			$date = \DateTime::createFromFormat('Y-m-d', $string)->format('m/d/Y');
			return $date;
		});
		// This function takes a date formatted in "American standard" date format
		// and converts it to a format without punctuation so that it can be used
		// in a URL:  YYYYMMDD
		$this->templates->registerFunction('deNormalizeDate', function ($string) {
			$date = \DateTime::createFromFormat('m/d/Y', $string)->format('Ymd');
			return $date;
		});
		// This function prepends the current "web root" to a given string to create
		// a URL.  This is mostly a hack until I can figure out how to get Apache to
		// handle the web root stuff for me.
		// $path allows you to specify an application path to direct the url to, so
		// templates can be more reusable.
		$this->templates->registerFunction('url', function ($string, $path = '') {
			// use this for "live" version on scsdev
			//$web_root = "/sierra/";
			// use this for development version on local machine
			$web_root = "/";
			if($path != '' && $string != '') {
				$path = $path . '/';
			}
			$url = $web_root . $path . $string;
			return $url;
		});
		// This function formats strings to display as dollar amounts
		$this->templates->registerFunction('currency', function ($string) {
			$value = "$" . round(floatval($string), 2);
			return $value;
		});
	}

	protected function writeToCsv($data)
	{
		$writer = Writer::createFromFileObject(new SplTempFileObject());
		$writer->setDelimiter(",");
		$writer->setOutputBOM(Writer::BOM_UTF8);
		$writer->insertAll($data);

		return $writer;
	}

	protected function downloadFile($data, $filename)
	{
		$file = $this->writeToCsv($data);
		// This line pushes the file directly to the user, causing a
		// download prompt from the browser.  It appears to bypass the
		// the router request/response cycle.
		$file->output($filename);
	}	
}