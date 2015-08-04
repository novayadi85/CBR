<?php 
include 'stemmer.php';

Class xml {

	public $author;
	public $title;
	public $date;
	public $ID;
	public $type = array('doc,docx,txt,pdf');
	public $categories;
	public $kamus_kata;
	public $stoplist;
	public $kamus;
	
	public function __construct(){
		$list=file(FILE_DIR.'stoplist/stoplist.txt',FILE_IGNORE_NEW_LINES);
		$kamus = file(FILE_DIR.'kamus/dasar2.txt',FILE_IGNORE_NEW_LINES);
		$this->stoplist = $list;
		$this->kamus_kata = $kamus;
		
	}
 
 
	private function __element($author, $title, $date,$id)
	{
		$this->author = $author;
		$this->title = $title;
		$this->date = $date;
		$this->ID = $id;
		//$this->categories = $categories;
		
	}
	//make some tutorial objects

	public function coba($var){
		return $var;
	}
	
	private function __getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
	}
	
	public function createXML($file,$filename=null,$vals){
		/*
		if(in_array($this->__getExtension($filename),$this->type)){*/
			
			$stemmer = new stemmer;
			$words=str_replace('.',' ',$file);
			$words = explode(' ',$words);
			
			//create the xml document
			$xmlDoc = new DOMDocument();

			//create the root element
			$root = $xmlDoc->appendChild(
			$xmlDoc->createElement("Document"));
		   
			$tutorials = array( $this-> __element(
				$vals['penulis'],
				$vals['title'],
				$vals['th_buat'],
				$vals['ID']
			)
			);
			
			$arrkey = explode(",",$vals['meta_keyword']);
			
			foreach($tutorials as $tut)
			{
				//create a tutorial element
				$tutTag = $root->appendChild(
				$xmlDoc->createElement("Detail"));
					   
				//create the author attribute
				$tutTag->appendChild(
				$xmlDoc->createAttribute("Author"))->appendChild(
				$xmlDoc->createTextNode($this->author));
			   
				//create the title element
				$tutTag->appendChild(
				$xmlDoc->createElement("Title", $this->title));
			   
				//create the date element
				$tutTag->appendChild(
				$xmlDoc->createElement("Year", $this->date));
				
				$tutTag->appendChild(
				$xmlDoc->createElement("ID", $this->ID));

				//create the categories element
				$catTag = $tutTag->appendChild(
				$xmlDoc->createElement("Words"));

			  //create a category element for each category in the array
				foreach($words as $cat)
				{
					$w = $this->casefolding($cat);
					if(!in_array($w,$arrkey)){
						$kata = $stemmer->Root($w);
					} else {
						$kata = $w;
					}
					if(!in_array($kata,$this->stoplist)){
						if(!empty($kata)){
							$catTag->appendChild(
							 $xmlDoc->createElement("Word", trim(strtolower($kata))));
						}
					}
				
				}
			}

			//header("Content-Type: text/plain");
			$file_save = ($filename).'.xml';
			//make the output pretty
			$xmlDoc->formatOutput = true;
			$output = $xmlDoc->saveXML();
			$destination = FILE_DIR . 'xml/';
			if($fd = @fopen($destination . $file_save, 'w')){
				$msg = @fwrite($fd,$output);
			}
			
			return $file_save;
		/*} else {
			$this->validation();
			return false;
		}*/
	}
	
	private function casefolding($kata){
		$after = preg_replace("/[^A-Za-z0-9-+]/", '', $kata);
		return $after;
	}
	
	function validation() {
        echo ' <script type="text/javascript">
        <!--
              alert("Maaf dokumen yang anda masukkan tidak sesuai, program ini hanya menudukung file yang berformat text");
        //-->
        
        </script>';
    }
}