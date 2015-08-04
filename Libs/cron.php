<?php 

Class cron {
	
	public $start;
	public $end;
	public $interval;
	
	private function __element($array)
	{
		$this->start = $array['start'];
		$this->end = $array['end'];
		$this->interval = $array['interval'];
	}
	
	public function create($array){

		$xmlDoc = new DOMDocument();

		$root = $xmlDoc->appendChild(
		$xmlDoc->createElement("Cron"));
	   
		$this-> __element($array);

		//create a tutorial element
		$tutTag = $root->appendChild(
		$xmlDoc->createElement("Detail"));
			   
		//create the author attribute
		$tutTag->appendChild(
		$xmlDoc->createAttribute("Author"))->appendChild(
		$xmlDoc->createTextNode('Novayadi'));
	   
		//create the title element
		$tutTag->appendChild(
		$xmlDoc->createElement("start", $this->start));
		
		$tutTag->appendChild(
		$xmlDoc->createElement("end", $this->end));
		
		$tutTag->appendChild(
		$xmlDoc->createElement("interval", $this->interval));

		//header("Content-Type: text/plain");
		$file_save = ('cron.xml');
		//make the output pretty
		$xmlDoc->formatOutput = true;
		$output = $xmlDoc->saveXML();
		$destination = FILE_DIR . 'cron/';
		if($fd = @fopen($destination . $file_save, 'w')){
			$msg = @fwrite($fd,$output);
		}
		
		return $file_save;
	}


}

?>